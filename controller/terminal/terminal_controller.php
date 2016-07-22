<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";
}else{
    include "../services/sessao_controller.php";
    include "../services/captcha_controller.php";
}

class Terminal_Controller extends Sessao_Controller{
   	private $dbal;    
    private $tabela = "terminal";
    private $valores = array();    

    public function __construct() {
    	$this->dbal = new DBAL_Model();
        $this->getAutenticarSessao();
    }
    public function DBAL(){
        return $this->dbal;
    }

    public function getCorredores(){
    	return $this->dbal-> Select("corredor", "nmCorredor", "Corredor_Model", null ,"");
    }
    public function getTerminais(){
        return $this->getDados(null);
    }
    public function getTerminal($id){
        $dados = $this->getDados($id);     
        return $dados[0];
    }
    public function getDados($id){
        $where = "";
        if(!is_null($id)){
            $where .= "WHERE idTerminal = ".$id;
        }else{
            if($this->getIdFuncaoFuncionarioSessao() != 1){ // se o usuario nao for administrador
                $where .= "WHERE idCorredor = ".$this->getIdCorredorFuncionarioSessao();
            }
        }

        // seleciona os dados do cliente
        $atributos = array(
            array('corredor'), // tabelas
            array('idCorredor'), // campos indices de pesquisa
            array('Corredor_Model'), // models
            array('setCorredor') // metodos de atribuicao da model_main
        );
        $dados = $this->dbal->Select('terminal', 'idCorredor', 'Terminal_Model', $atributos, $where);
        if($dados){
            return $dados;
        }else{
            header("Location: ../../view/services/erro.php?msg=".base64_encode(7));
        }
        
    }
   
    public function insert(){
        return $this->DBAL()->Insert($this->tabela, $this->valores);
    }
    public function update($id){
        $valores["idTerminal"] = $id;
        $idCampo =  "idTerminal = ".$id;        
        $this->DBAL()->Update($this->tabela, $idCampo, $this->valores);
    }
    public function delete($id){
        $this->DBAL()->Delete($this->tabela,"idTerminal",$id);
    }
    public function setValores($dados){        
        $this->valores["nmTerminal"]  = strtoupper($dados["nmterminal"]);
        $this->valores["sgTerminal"]  = strtoupper($dados["sgterminal"]);
        $this->valores["idCorredor"] = $dados["idcorredor"];
    }
   
}

if($_SERVER["REQUEST_METHOD"] == "POST"){


    if(isset($_POST["acao"])){

        $dados = unserialize(serialize($_POST));
        $terminal = new Terminal_Controller();
        $terminal->setValores($dados);

        switch ($_POST["acao"]) {            

            case 'insert':
                $terminal->insert();
                $msg .= base64_encode(0);
                break;
            case 'edit':                
                $terminal->update($_POST["idterminal"]);                    
                $msg .= base64_encode(1);
                break;
            case 'delete':
                $terminal->delete($_POST["idterminal"]);                   
                $msg .= base64_encode(2);
                break;          
        }
    }

    header("Location: ../../view/terminais/?".$msg);
    
}
