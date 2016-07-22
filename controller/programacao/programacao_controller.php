<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";

}else{
    include "../services/sessao_controller.php";
    include "../services/captcha_controller.php";    
}

class Programacao_Controller extends Sessao_Controller{
   	private $dbal;
    private $fpt;

    public function __construct() {
    	$this->dbal = new DBAL_Model();
        $this->getAutenticarSessao();
    }
    public function DBAL(){
        return $this->dbal;
    }
    public function getArmadores(){
    	return $this->dbal-> Select("armador", "nmArmador", "Armador_Model", null ,"");
    }
    public function getTerminais(){
    	return $this->dbal-> Select("terminal", "nmTerminal", "Terminal_Model", null ,"");
    }
    public function getGruposClientes(){
    	return $this->dbal-> Select("grupo_cliente", "nmGrupoCliente", "GrupoCliente_Model", null ,"");
    }
    public function getTiposContaineres(){
        return $this->dbal-> Select("tipo_container", "nmTipoContainer", "TipoContainer_Model", null ,"");   
    }
    public function getPortos(){
        return $this->dbal-> Select("porto", "nmPorto", "Porto_Model", null ,"");
    }
    public function getProdutos(){
        return $this->dbal-> Select("produto", "nmProduto", "Produto_Model", null ,"");
    }

    public function getDados($id){
        $where = "";
        if(!is_null($id)){
            $where = "WHERE idProgramacao =".$id;
        }

        // seleciona os dados do cliente
        $atributos = array(
            array('armador', 'tipo_container', 'grupo_cliente', 'funcionario','terminal','porto','produto'), // tabelas
            array('idArmador', 'idTipoContainer', 'idGrupoCliente', 'idFuncionario','idTerminal','idPorto','idProduto'), // campos indices de pesquisa
            array('Armador_Model', 'TipoContainer_Model', 'GrupoCliente_Model', 'Funcionario_Model','Terminal_Model','Porto_Model','Produto_Model'), // models
            array('setArmador', 'setTipoContainer', 'setGrupoCliente', 'setFuncionario','setTerminal','setPorto','setProduto') // metodos de atribuicao da model_main
        );
        return $this->dbal->Select('programacao', 'dlcProgramacao', 'Programacao_Model', $atributos, $where);        
    }

    public function getProgramacoes(){
        return $this->getDados(null);
    }
    public function getProgramacao($id){
        $dados = $this->getDados($id)[0];
        $this->setFPT($dados->getBkProgramacao());        
        return $dados;
    }
    public function getFPT(){
        return $this->fpt[0];
    }
    public function setFPT($bk){
        $query = "SELECT MAX(ocorrencia) as data, (SELECT COUNT(*) FROM fpt WHERE booking LIKE '$bk' ) as qtd FROM fpt WHERE booking LIKE '$bk'";
        $this->fpt = $this->dbal->Query($query);
    }
    public function Lista(){
        $query =  "SELECT *, "
            ." (select count(*) from fpt where programacao.bkProgramacao = fpt.booking ) as qt, "
            ." (select MAX(ocorrencia) from fpt where programacao.bkProgramacao = fpt.booking ) as oc "
            ."FROM programacao "
            ."LEFT JOIN fpt ON programacao.bkProgramacao = fpt.booking "
            ."LEFT JOIN funcionario USING(idFuncionario) "
            ."LEFT JOIN grupo_cliente USING(idGrupoCliente) "
            ."LEFT JOIN armador USING(idArmador) "
            ."LEFT JOIN tipo_container USING(idTipoContainer) "
            ."LEFT JOIN terminal USING(idTerminal) "
            ."LEFT JOIN porto USING(idPorto) "
            ."LEFT JOIN produto USING(idProduto)"
            ."GROUP BY bkProgramacao;";
            
        $dados = $this->dbal->Query($query);
        return $dados;
    }
}


function GravaDados($id){

    $con = new Programacao_Controller();

    $data = $_POST['deadline_cliente_data'];
    $hora = $_POST['deadline_cliente_hora'];
    $deadline_cliente = date('Y-m-d H:i', strtotime("$data $hora"));
    $tabela = "programacao";
    $valores = array(
        "dsProgramacao" => $_POST["solicitacao"],
        "idTerminal" => $_POST["terminal"],
        "idGrupoCliente" => $_POST["cliente"],
        "bkProgramacao" => strtoupper($_POST["booking"]),
        "idArmador" => $_POST["armador"],
        "idProduto" => $_POST["produto"],
        "inProgramacao" => strtoupper($_POST["instrucao"]),
        "idPorto" => $_POST["porto"],
        "nvProgramacao" => strtoupper($_POST["navio"]),
        "qtProgramacao" => $_POST["quantidade"],
        "idTipoContainer" => $_POST["tipo_container"],
        "dlcProgramacao" => $deadline_cliente,
        "idFuncionario" => $con->getIdFuncionarioSessao(),
        "dcProgramacao" => date("Y-m-d")
        );

    if(is_null($id)){
        return $con->DBAL()->Insert($tabela, $valores);
    }else{
        $idCampo = "idProgramacao =".$id;
        $con->DBAL()->Update($tabela, $idCampo, $valores);
        return $id;
    }

}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["acao"])){
                
        if(!ValidarCaptcha()){
            switch ($_POST["acao"]) {
                case 'inserir':
                    $url = "inserir.php?msg=".base64_encode(3);
                    break;
                case 'editar':
                    $url = "programacao.php?prog=".$prog."&msg=".base64_encode(3);   
                    break;
                case 'deletar':     
                    $url = "programacao.php?prog=".$prog."&msg=".base64_encode(3);
                    break;
                default:                
                    $url = "lista.php?";
                    break;
            }
         }else{       
            switch ($_POST["acao"]) {
                case 'inserir':
                    $prog = GravaDados(null);
                    $url = "programacao.php?prog=".$prog."&msg=".base64_encode(0);
                    break;
                case 'editar':                
                    $prog = GravaDados($_POST["programacao"]);                
                    $url = "programacao.php?prog=".$prog."&msg=".base64_encode(1);
                    break;
                case 'deletar':
                    $con = new Programacao_Controller();                
                    $con->DBAL()->Delete("programacao", "WHERE idProgramacao =".$_POST["programacao"]);                
                    $url = "lista.php?msg=".base64_encode(2);
                    break;          
                default:                
                    $url = "lista.php?";
                    break;
            }
        }
        header("Location: ../../view/programacao/".$url);
    }
    
}
