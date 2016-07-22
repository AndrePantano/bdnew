<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";
}else{
    include "../services/sessao_controller.php";
    include "../services/captcha_controller.php";
}

class Cliente_Controller extends Sessao_Controller{
   	private $dbal;
    private $tabela = "cliente";
    private $valores = array();
    private $idCorredor;

    public function __construct() {
    	$this->dbal = new DBAL_Model();
        $this->getAutenticarSessao();
        $this->idCorredor = $this->getIdCorredorFuncionarioSessao();
    }
    public function DBAL(){
        return $this->dbal;
    }

    public function getTerminais(){
        
        $criterio = "";
        if($this->getIdFuncaoFuncionarioSessao() != 1)
    	   $criterio = " WHERE idCorredor = ". $this->idCorredor;

         // seleciona os dados do cliente
        $atributos = array(
            array('corredor'), // tabelas
            array('idCorredor'), // campos indices de pesquisa
            array('Corredor_Model'), // models
            array('setCorredor') // metodos de atribuicao da model_main
        );
        return $this->dbal-> Select("terminal", "nmTerminal", "Terminal_Model", $atributos ,$criterio);
    }
   
    public function getDados($id){
        
        
        $where = "";

        if(!is_null($id)){
            $where = "WHERE idCliente =".$id;
        }else{

            if($this->getIdFuncaoFuncionarioSessao() != 1){ // se o usuario nao for administrador
                // incrementa todos os terminais do corredor do usuario
                $terminais = $this->getTerminais();

                $criterio = "";
                
                foreach ($terminais as $terminal) {
                    $criterio .= " (idTerminal = ".$terminal->getIdTerminal().") OR ";
                }
                
                $string = explode(" ",$criterio);
                unset($string[count($string)-2]);
                $string = implode($string);

                $where = "WHERE ".$string;
            }
        }

        // seleciona os dados do cliente
        $atributos = array(
            array('terminal'), // tabelas
            array('idTerminal'), // campos indices de pesquisa
            array('Terminal_Model'), // models
            array('setTerminal') // metodos de atribuicao da model_main
        );
        
        $dados = $this->dbal->Select('cliente', 'nmCliente', 'Cliente_Model', $atributos, $where);
        
        return $dados;
        
        //header("Location: ../../view/services/erro.php?msg=".base64_encode(7));
        
    }

    public function getClientes(){
        return $this->getDados(null);
    }
    public function getCliente($id){
        $dados = $this->getDados($id);     
        return $dados[0];
    }
    public function insert(){
        return $this->DBAL()->Insert($this->tabela, $this->valores);
    }
    public function update($idCliente){
        $valores["idCliente"] = $idCliente;
        $idCampo = "idCliente =".$idCliente;
        $this->DBAL()->Update($this->tabela, $idCampo, $this->valores);
    }
    public function delete($idCliente){
        $this->DBAL()->Delete($this->tabela,"idCliente",$idCliente);
    }
    public function setValores($dados){        
        $this->valores["nmCliente"]  = $dados["nmcliente"];
        $this->valores["peCliente"]  = $dados["pecliente"];
        $this->valores["idTerminal"] = $dados["idterminal"];
        $this->valores["fxCliente"] = $dados["fxcliente"];
    }
   
}

class Pedra_Controller extends Cliente_Controller{
    private $tabela = "pedra";
    private  $valores = array();

    public function __construct(){
        parent::__construct();       
        $this->setValoresPadrao();
    }
    public function DBAL(){
        return parent::DBAL();
    }
    public function find($idCliente){
        $query = "SELECT * FROM ".$this->tabela." WHERE idCliente = ".$idCliente." AND dtPedra = '".date("Y-m-d",strtotime("- 1 day"))."'";
        return $this->DBAL()->Query($query);
    }
    public function insert(){
        $this->DBAL()->Insert($this->tabela, $this->valores);
    }
    public function update($idCliente){
        $condicao = "idCliente =".$idCliente;
        $this->DBAL()->Update($this->tabela, $condicao, $this->valores);
    }
    public function delete($idCliente){
        $this->DBAL()->Delete($this->tabela,"idCliente",$idCliente);
    }
    public function setIdCliente($idCliente){
        $this->valores["idCliente"] = $idCliente;
    }
    public function setValoresPadrao(){
        $this->valores["dtPedra"] = date("Y-m-d",strtotime("-1 day"));
        $this->valores["pvPedra"] = 0;
        $this->valores["rePedra"] = 0;        
        $this->valores["idFuncionario"] = $this->getIdFuncionarioSessao();
        $this->valores['daPedra'] = date("Y-m-d H:i:s");
        $this->valores['dmPedra'] = date("Y-m-d H:i:s");
    }
   
}

class Pedra_Dia_Controller extends Pedra_Controller{
    
    private $tabela = "pedra_dia";
    private  $valores = array();

    public function __construct() {
        parent::__construct();
        $this->setValoresPadrao();        
    }
    public function DBAL(){
        return parent::DBAL();
    }
    public function find($idCliente){
        $query = "SELECT * FROM ".$this->tabela." WHERE idCliente = ".$idCliente;
        return $this->DBAL()->Query($query);
    }
    public function insert(){        
        $this->DBAL()->Insert($this->tabela, $this->valores);
    }
    public function update($idCliente){
        $condicao = "idCliente =".$idCliente;
        $this->DBAL()->Update($this->tabela, $condicao, $this->valores);
    }
    public function delete($idCliente){
        $this->DBAL()->Delete($this->tabela,"idCliente",$idCliente);
    }
    public function setIdCliente($idCliente){
        $this->valores["idCliente"] = $idCliente;
    }    
    public function setValoresPadrao(){                
        $this->valores["pv_d"]          = 0;
        $this->valores["pv_dmai"]       = 0;
        $this->valores["pv_dmaii"]      = 0;
        $this->valores["re_d"]          = 0;
        $this->valores["re_dmai"]       = 0;
        $this->valores["re_dmaii"]      = 0;
        $this->valores["re_dmaiii"]     = 0;
    }   
    
}    


if($_SERVER["REQUEST_METHOD"] == "POST"){


    if(isset($_POST["acao"])){
                
        $msg = "msg=";

        $dados = unserialize(serialize($_POST));
        $cliente = new Cliente_Controller();
        $cliente->setValores($dados);

        switch ($_POST["acao"]) {            

            case 'insert':
                $idCliente = $cliente->insert();
                //SE A PEDRA FOR ATIVA
                if($dados["pecliente"]){
                    $pedra = new Pedra_Controller();
                    $pedra->setIdCliente($idCliente);
                    $pedra->insert();

                    $pedra_dia = new Pedra_Dia_Controller();
                    $pedra_dia->setIdCliente($idCliente);
                    $pedra_dia->insert();

                }
                $msg .= base64_encode(0);
                break;
            case 'edit':                
                $cliente->update($_POST["idcliente"]);
                
                // SE A PEDRA FOR ATIVA
                if($_POST["pecliente"]){
                    $pedra = new Pedra_Controller();
                
                    // SE NÃO HOUVER PEDRA COM D-1, CRIA-A
                    if(count($pedra->find($_POST["idcliente"])) == 0){
                        $pedra->setIdCliente($_POST["idcliente"]);
                        $pedra->insert();
                
                        // SE NÃO HOUVER PEDRA_DIA, CRIA-A
                        $pedra_dia = new Pedra_Dia_Controller();
                        if(count($pedra_dia->find($_POST["idcliente"])) == 0){
                            $pedra_dia->setIdCliente($_POST["idcliente"]);
                            $pedra_dia->insert();
                        }
                    }
                }
                $msg .= base64_encode(1);
                break;
            case 'delete':
                $cliente->delete($_POST["idcliente"]);
                $pedra = new Pedra_Controller();
                $pedra->delete($_POST["idcliente"]);
                $pedra_dia = new Pedra_Dia_Controller();
                $pedra_dia->delete($_POST["idcliente"]);
                $msg .= base64_encode(2);
                break;          
        }

        header("Location: ../../view/clientes/?".$msg);
    }
    
}
