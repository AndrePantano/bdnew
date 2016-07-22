<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";
}else{
    include "../services/sessao_controller.php";    
}

class Pedra_Relatorio_Controller extends Sessao_Controller{
    private $dbal;
    private $origens = array();
    private $clientes = array();

    public function __construct() {
        $this->dbal = new DBAL_Model();
        $this->getAutenticarSessao();         
    }

    public function DBAL(){
        return $this->dbal;
    }

    public function getPedraMotivo(){
        
        return $this->DBAL()->Query("SELECT * FROM pedra_motivo");
    }
    
    public function getGerarRelatorio($data_inicio,$data_fim){
        $motivos = $this->getPedraMotivo();

        $sub_query = "";

        foreach ($motivos as $motivo) {
                $sub_query .= ""
                ." IFNULL((SELECT SUM(rePedra - pvPedra)"
                ." FROM pedra"   
                ." WHERE" 
                    ." (idPedraMotivo = ".$motivo["idPedraMotivo"]." AND"
                        ." (idCliente = c.idCliente AND" 
                            ." (dtPedra BETWEEN '".$data_inicio."' AND '".$data_fim."')))),0) AS ".$motivo["nmPedraMotivo"].",";
        }

        $sub_query .= ""
                ." IFNULL((SELECT SUM(rePedra - pvPedra)"
                ." FROM pedra"             
                ." WHERE" 
                    ." (idCliente = c.idCliente AND"
                        ."(idPedraMotivo IS NOT NULL AND"
                            ." (dtPedra BETWEEN '".$data_inicio."' AND '".$data_fim."')))),0) AS Total";

        $query =  "SELECT sgTerminal AS unidade, nmCliente AS cliente,"
        .$sub_query
        ." FROM pedra"
        ." JOIN cliente c USING(idCliente)"
        ." JOIN terminal USING(idTerminal)"
        ." WHERE (dtPedra BETWEEN '".$data_inicio."' AND '".$data_fim."') AND"
        ." IFNULL((SELECT SUM(rePedra - pvPedra)"
                ." FROM pedra"             
                ." WHERE" 
                    ." (idCliente = c.idCliente AND"
                        ."(idPedraMotivo IS NOT NULL AND"
                            ." (dtPedra BETWEEN '".$data_inicio."' AND '".$data_fim."')))),0) <> 0"
        ." GROUP BY c.idCliente"
        ." ORDER BY unidade, cliente";
        
        //echo $query;

        $this->clientes = $this->DBAL()->Query($query);

        $this->setResumoOrigens($data_inicio,$data_fim);
    }

    public function setResumoOrigens($data_inicio,$data_fim){
                
        $motivos = $this->getPedraMotivo();

        $sub_query = "";

        foreach ($motivos as $motivo) {
            $sub_query .= ""
            ." IFNULL((SELECT SUM(rePedra - pvPedra)"
            ." FROM pedra" 
            ." JOIN cliente USING(idCliente)" 
            ." JOIN terminal USING(idTerminal)" 
            ." WHERE" 
                ." (idPedraMotivo = ".$motivo["idPedraMotivo"]." AND"
                    ." (idTerminal = t.idTerminal AND" 
                        ." (dtPedra BETWEEN '".$data_inicio."' AND '".$data_fim."')))),0) AS ".$motivo["nmPedraMotivo"].",";
        }

        $sub_query .= ""
            ." IFNULL((SELECT SUM(rePedra - pvPedra)"
            ." FROM pedra" 
            ." JOIN cliente USING(idCliente)" 
            ." JOIN terminal USING(idTerminal)" 
            ." WHERE" 
                ." (idTerminal = t.idTerminal AND"
                    ."(idPedraMotivo IS NOT NULL AND"
                        ." (dtPedra BETWEEN '".$data_inicio."' AND '".$data_fim."')))),0) AS Total";

        $query =  "SELECT t.sgTerminal AS unidade,"
            .$sub_query
            ." FROM pedra"
            ." JOIN cliente USING(idCliente)"
            ." JOIN terminal t USING(idTerminal)"
            ." WHERE (dtPedra BETWEEN '".$data_inicio."' AND '".$data_fim."') AND"
            ." IFNULL((SELECT SUM(rePedra - pvPedra)"
                    ." FROM pedra" 
                    ." JOIN cliente USING(idCliente)" 
                    ." JOIN terminal USING(idTerminal)" 
                    ." WHERE" 
                        ." (idTerminal = t.idTerminal AND"
                            ."(idPedraMotivo IS NOT NULL AND"
                                ." (dtPedra BETWEEN '".$data_inicio."' AND '".$data_fim."')))),0) <> 0"
            ." GROUP BY t.idTerminal";
        
        $this->origens = $this->DBAL()->Query($query);
    }

    public function getResumoClientes(){
        return $this->clientes;
    }
    public function getResumoOrigens(){
        return $this->origens;
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
    public function getRelatorioAjustes($idcliente,$inicio,$fim){
        /*
        $total_reg = 2;
        
        if(!$pag)
            $pag = 1;

        $começo = $pag - 1;
        $começo *= $total_reg;
        */
        $query = "SELECT * FROM pedra"
            ." JOIN cliente USING(idCliente)"
            ." JOIN pedra_motivo USING(idPedraMotivo)"
            ." JOIN terminal USING(idTerminal)"
            ." JOIN funcionario USING(idFuncionario)"
        ." WHERE"
            ." idCliente = ".$idcliente." AND"
            ." dtPedra BETWEEN '".$inicio."' AND '".$fim."'";//" LIMIT ".$começo.",".$total_reg;
        return $this->DBAL()->Query($query);
    }
    public function getExportarMotivos($data_inicio,$data_fim){
        $i = date("Y-m-d",strtotime(base64_decode($data_inicio)));
        $f = date("Y-m-d",strtotime(base64_decode($data_fim)));

        $query = ""
        ."SELECT sgTerminal as origem,"
        ." nmcliente as cliente,"
        ." IFNULL(SUM(rePedra - pvPedra),0) as delta,"
        ." dtPedra AS 'data',"
        ." nmPedraMotivo as motivo"
        ." FROM pedra"
        ." INNER JOIN cliente USING(idCliente)"
        ." INNER JOIN pedra_motivo USING(idPedraMotivo)"
        ." INNER JOIN terminal USING(idTerminal)"
        ." WHERE idPedraMotivo is not null AND (dtPedra BETWEEN '".$i."' AND '".$f."')"
        ." GROUP BY idPedraMotivo, idCliente"
        ." ORDER BY data ASC";

        return $this->DBAL()->Query($query);
    }
}

if(isset($_POST["data_inicio"]) && isset($_POST["data_fim"])){
    
    header("Location: ../../view/pedra/rel_01.php?i=".base64_encode($_POST["data_inicio"])."&f=".base64_encode($_POST["data_fim"]));

}

if(isset($_POST["relatorio"])){
    $con = new Pedra_Relatorio_Controller();
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
}

