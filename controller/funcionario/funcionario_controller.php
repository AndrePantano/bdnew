<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";
}else{
    include "../services/sessao_controller.php";
    include "../services/captcha_controller.php";
}

class Funcionario_Controller extends Sessao_Controller{
   	private $dbal;
    private $tabela = "funcionario";
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

    public function getFuncoes(){    	 
        return $this->dbal-> Select("funcao", "nmFuncao", "Funcao_Model", null ,"");
    }
    public function getCorredores(){         
        return $this->dbal-> Select("corredor", "nmCorredor", "Corredor_Model", null ,"");
    }
    public function getEstatus(){        
        return $this->dbal-> Select("estatus", "nmEstatus", "Estatus_Model", null ,"");
    }

    public function getDados($id){
        $where = "";
        if(!is_null($id)){
            $where = "WHERE idFuncionario =".$id;
        }

        // seleciona os dados do cliente
        $atributos = array(
            array('funcao','corredor','estatus'), // tabelas
            array('idFuncao','idCorredor','idEstatus'), // campos indices de pesquisa
            array('Funcao_Model','Corredor_Model','Estatus_Model'), // models
            array('setFuncao','setCorredor','setEstatus') // metodos de atribuicao da model_main
        );
        $dados = $this->dbal->Select($this->tabela, 'nmFuncionario', 'Funcionario_Model', $atributos, $where);
        if($dados){
            return $dados;
        }else{
            header("Location: ../../view/services/erro.php?msg=".base64_encode(7));
        }
        
    }

    public function getFuncionarios(){
        return $this->getDados(null);
    }
    public function getFuncionario($id){
        $funcionarios = $this->getDados($id);     
        return $funcionarios[0];
    }
    public function insert(){
        $this->AtribuirSenhaPadrao();
        return $this->DBAL()->Insert($this->tabela, $this->valores);
    }
    public function update($idFuncionario){        
        $idCampo = "idFuncionario =".$idFuncionario;
        $this->DBAL()->Update($this->tabela, $idCampo, $this->valores);
    }
    public function delete($idFuncionario){
        $this->DBAL()->Delete($this->tabela,"idFuncionario",$idFuncionario);
    }

    public function setValores($dados){        
        $this->valores["nmFuncionario"]  = $dados["nmfuncionario"];
        $this->valores["emFuncionario"]  = $dados["emfuncionario"];        
        $this->valores["idFuncao"]       = $dados["idfuncao"];
        $this->valores["idCorredor"]     = $dados["idcorredor"];
        $this->valores["idEstatus"]      = $dados["idestatus"];
    }
    public function AtribuirSenhaPadrao(){
        $this->valores["shFuncionario"]   = md5("brado");        
    }
   
}

if($_SERVER["REQUEST_METHOD"] == "POST"){


    if(isset($_POST["acao"])){
                
        $msg = "msg=";

        $dados = unserialize(serialize($_POST));
        $funcionario = new Funcionario_Controller();
        $funcionario->setValores($dados);

        switch ($_POST["acao"]) {            

            case 'insert':
                $funcionario->insert();                                                
                $msg .= base64_encode(0);
                break;
            case 'edit':                
                $funcionario->update($_POST["idfuncionario"]);                    
                $msg .= base64_encode(1);
                break;
            case 'delete':
                $funcionario->delete($_POST["idfuncionario"]);                   
                $msg .= base64_encode(2);
                break;
            case 'senha':
                $funcionario->AtribuirSenhaPadrao();              
                $funcionario->update($_POST["idfuncionario"]);                    
                $msg .= base64_encode(1);
                break;         
        }
    }
    header("Location: ../../view/funcionarios/?".$msg);
    
}
