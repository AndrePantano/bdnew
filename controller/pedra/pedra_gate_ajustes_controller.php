<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";
}else{
    include "../services/sessao_controller.php";    
}

class Pedra_Gate_Ajustes_Controller extends Sessao_Controller{
    private $dbal;
    private $tabela = "pedra";
    private $valores = array();
    private $limite_por_pagina = 10;
    private $total_registros_encontrados = 0;
    private $total_registros_atual = 0;
    private $total_paginas = 0;

    public function __construct() {
        $this->dbal = new DBAL_Model();
        $this->getAutenticarSessao();         
    }

    public function DBAL(){

        return $this->dbal;
    }
 
    // INSERE REGISTROS NA TABELA PEDRA
    public function insert(){
        return $this->DBAL()->Insert($this->tabela, $this->valores);
    }

    // ATUALIZA OS DADOS DA PEDRA
    public function update($idPedra){
        $idCampo = "idPedra = ".$idPedra;
        $this->DBAL()->Update($this->tabela, $idCampo, $this->valores);
    }

    // EXCLUI O REGISTRO
    public function delete($idPedra){
        $this->DBAL()->Delete($this->tabela,"idPedra",$idPedra);
    }

    // SETA OS VALORES PARA ATUALIZAÇÃO
    public function setValores($dados){
        $this->valores["pvPedra"] = $dados['previa'];
        $this->valores["rePedra"] = $dados["real"]; 
        
        // VERIFICA SE O CHAVE MOTIVO EXISTE
        if(array_key_exists("motivo", $dados)){
            $this->valores["idPedraMotivo"] = $dados["motivo"];
        }else{
            $this->valores["idPedraMotivo"] = "";
        }

         // VERIFICA SE O CHAVE OBSERVACAO EXISTE
        if(array_key_exists("observacao", $dados)){
            $this->valores["obPedra"] = $dados["observacao"];
        }else{
            $this->valores["obPedra"] = "";
        }

    }
    
    // SETA OS VALORES PARA INSERÇÃO
    public function setValoresPadroes($dados){
        $this->valores["idCliente"] = $dados['cliente'];
        $this->valores["dtPedra"] = $dados["data"];                          
    }

    // VALIDA SE A PEDRA JA EXISTE
    public function validaPedra($dados){

        $cont = $this->DBAL()->Query("SELECT * FROM pedra WHERE idCliente = ".$dados['cliente']. " AND dtPedra = '".$dados["data"]."';");
        //return count($cont);
             
        if(count($cont) > 0)
            return false;
            
        return true;
        
    }

    // RETORNA TODOS OS MOTIVOS
    public function getPedraMotivos(){

        return $this->DBAL()->Query("SELECT * FROM pedra_motivo");
    }
    
    // RETORNA TODOS OS CORREDORES
    public function getCorredores(){

        return $this->DBAL()->Query("SELECT * FROM corredor");
    }

    // RETORNA TODOS OS TERMINAIS DO CORREDOR PASSADO()
    public function getTerminais($idCorredor){

        return $this->DBAL()->Query("SELECT * FROM terminal WHERE idCorredor = ".$idCorredor." ORDER BY nmTerminal");
    }

    // RETORNA TODOS OS CLIENTES DO TERMINAL PASSADO()
    public function getClientes($idTerminal){

        return $this->DBAL()->Query("SELECT * FROM cliente WHERE idTerminal = ".$idTerminal." ORDER BY nmCliente");
    }

    // RETORNA TODAS AS PEDRAS DO CLIENTE DENTRO DO PERIODO PASSADO
    public function getRelatorioAjustes($chave,$valor,$inicio,$fim,$pagina){

        if($chave == "idCorredor")
            $chave = "corredor.idCorredor";

        // registros por página        
        $começo = $pagina - 1;
        $começo *= $this->limite_por_pagina;

        // RETORNA TODOS OS REGISTROS
        $query = "SELECT * FROM pedra"
            ." JOIN cliente USING(idCliente)"
            ." LEFT JOIN pedra_motivo USING(idPedraMotivo)"
            ." JOIN terminal USING(idTerminal)"
            ." JOIN corredor USING(idCorredor)"
            ." LEFT JOIN funcionario USING(idFuncionario)"
        ." WHERE "
            .$chave." = ".$valor." AND"
            ." dtPedra BETWEEN '".$inicio."' AND '".$fim."'";

        // ATRIBUI O TOTAL DE REGISTROS ENCONTRADOS
        $this->total_registros_encontrados = count($this->DBAL()->Query($query));

        $query = "SELECT * FROM pedra"
            ." JOIN cliente USING(idCliente)"
            ." LEFT JOIN pedra_motivo USING(idPedraMotivo)"
            ." JOIN terminal USING(idTerminal)"
            ." JOIN corredor USING(idCorredor)"
            ." LEFT JOIN funcionario USING(idFuncionario)"
        ." WHERE "
            .$chave." = ".$valor." AND"
            ." dtPedra BETWEEN '".$inicio."' AND '".$fim."' ORDER BY dtPedra ASC LIMIT ".$começo.",".$this->limite_por_pagina;
        
        return $this->DBAL()->Query($query);

    }

    // RETORNA A QUANTIDADE DE REGISTROS
    public function getTotalRegistrosEncontrados(){
        return $this->total_registros_encontrados;
    }

    // RETORNA A QUANTIDADE DE REGISTROS ATUAL
    public function getTotalRegistrosAtual(){
        return $this->total_registros_atual;
    }

    // RETORNA A QUANTIDADE DE PÁGINAS
    public function getTotalPaginas(){
        return ceil($this->getTotalRegistrosEncontrados() / $this->limite_por_pagina);
    }

    // EXPORTA RELATORIO DE PEDRAS UTILIZANDO OS CRITERIOS PASSADO
    public function getExportarPedras($chave,$valor,$inicio,$fim){

        if($chave == "idCorredor")
            $chave = "corredor.idCorredor";

        // RETORNA TODOS OS REGISTROS
        $query = "SELECT * FROM pedra"
            ." JOIN cliente USING(idCliente)"
            ." LEFT JOIN pedra_motivo USING(idPedraMotivo)"
            ." JOIN terminal USING(idTerminal)"
            ." JOIN corredor USING(idCorredor)"
            ." JOIN funcionario USING(idFuncionario)"
        ." WHERE "
            .$chave." = ".$valor." AND"
            ." dtPedra BETWEEN '".$inicio."' AND '".$fim."'";
        
        return $this->DBAL()->Query($query);

    }
}

// RETORNA O JSON DAS CHAMADAS AJAX DA PEDRA AJUSTE
if(isset($_POST["relatorio"])){
    $con = new Pedra_Gate_Ajustes_Controller();
    $result = array();

    switch ($_POST["tabela"]) {
        case 'terminal':
            $result = $con->getTerminais($_POST['valor']);
            break;
        case 'cliente':
            $result = $con->getClientes($_POST['valor']);
            break;       
    }
    
    header("Content-type: application/json");    
    echo json_encode($result);
    //echo "<pre>".print_r($result,1)."</pre>";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // REALIZA A OPERAÇÃO DE ATUALIZAÇÃO NAS PEDRAS RETROATIVAS
    if(isset($_POST["acao"])){
                
        $msg = "msg=";
        $dados = unserialize(serialize($_POST));
        //echo "<pre>".print_r($dados,1)."</pre>";

        $pedra = new Pedra_Gate_Ajustes_Controller();
        $pedra->setValores($dados);
        switch ($_POST["acao"]) {
            case "insert":
                $pedra->setValoresPadroes($dados);

                //echo $pedra->validaPedra($dados);
                
                if($pedra->validaPedra($dados)){
                    $pedra->insert();
                    $msg .= base64_encode(0);
                }else{
                    $msg .= base64_encode(8);   
                }
                
                break;
            case 'edit':                             
                $pedra->update($_POST["pedra"]);                   
                $msg .= base64_encode(1);
                break;
            case 'delete':                             
                $pedra->delete($_POST["pedra"]);                   
                $msg .= base64_encode(2);
                break;
        } 
        
        $pg = $_POST['pagina'];
        $co = $_POST['corredor'];
        $te = $_POST['terminal'];
        $cl = $_POST['cliente'];
        $di = $_POST['inicio'];
        $df = $_POST['fim'];

        header("Location: ../../view/pedra/pedra_gate_ajuste.php?pg=".$pg."&co=".$co."&te=".$te."&cl=".$cl."&di=".$di."&df=".$df."&".$msg);

    }

    // REALIZA A POST DOS CRITERIOS DA PESQUISA
    if(isset($_POST["ajustes"])){
                
        
        //$dados = unserialize(serialize($_POST));
        //echo "<pre>".print_r($dados,1)."</pre>";        

        $pg = $_POST['pg'];
        $co = $_POST['co'];
        $te = $_POST['te'];
        $cl = $_POST['cl'];
        $di = $_POST['di'];
        $df = $_POST['df'];

        header("Location: ../../view/pedra/pedra_gate_ajuste.php?pg=".$pg."&co=".$co."&te=".$te."&cl=".$cl."&di=".$di."&df=".$df);

    }
}
