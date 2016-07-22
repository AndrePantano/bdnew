<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";

}else{
    include "../../controller/services/sessao_controller.php";    
    include "../services/sessao_controller.php";
    include "../services/captcha_controller.php";   
}

class Volumes_Controller extends Sessao_Controller{
   	private $dbal;
    private $corredor;

    public function __construct() {
    	$this->dbal = new DBAL_Model();
        $this->getAutenticarSessao();
    }

    public function DBAL(){return $this->dbal;}
    
    // CONFIGURA A VARIAVEL CORREDOR
    public function setCorredor($corredor){$this->corredor = $corredor;}

    // RETORNA O NOME DO CORREDOR
    public function getCorredor(){
        if($this->corredor != 0){
            $corredores =  $this->DBAL()->Query("SELECT * FROM corredor WHERE idCorredor = ". $this->corredor);
            return $corredores[0];
        }else{
            return array("idCorredor" => 0, "nmCorredor" => "TODOS");
        }
    }
    // RETORNA OS DADOS DOS CORREDORES
    public function getTerminais(){

        $where = "";
        $group_by = "";
        if($this->corredor != 0){
            $where = " WHERE idCorredor = ". $this->corredor;
            $group_by .= " GROUP BY terminal";
        }else{
            $group_by .= " GROUP BY idCorredor";
        }

        $query = " SELECT *," 
            ." terminal," 
            ." SUM(orcamento) as orcamento," 
            ." SUM(programa) as programa," 
            ." SUM(ritmo) as ritmo," 
            ." SUM(acumulado) as acumulado" 
            ." FROM ritmo"
            ." JOIN corredor USING(idCorredor)"
            ." ".$where
            ." ".$group_by
            ." ORDER BY programa DESC";

        return $this->DBAL()->Query($query);
    }
/*
    public function getTerminais(){
        //$query = "SELECT corredor, terminal ,SUM(orcamento) as orcamento, SUM(programa) as programa, SUM(ritmo) as ritmo, SUM(acumulado) as acumulado FROM `ritmo` GROUP BY terminal ORDER BY programa DESC";
        $query = "SELECT corredor," 
            ." terminal," 
            ." SUM(orcamento) as orcamento," 
            ." SUM(programa) as programa," 
            ." SUM(ritmo) as ritmo," 
            ." SUM(acumulado) as acumulado" 
            ." FROM ritmo" 
            ." GROUP BY terminal" 
            ." ORDER BY programa DESC";

        return $this->DBAL()->Query($query);
    }
*/
    public function getClientes(){
        $where = "";
        if($this->corredor != 0)
            $where = " WHERE idCorredor = ". $this->corredor;

        return $this->DBAL()->Query("SELECT * FROM ritmo ".$where." ORDER BY terminal, programa DESC");
    }

    public function getMesRelatorio($data){
        $meses = array(
            "mes",
            "janeiro",
            "fevereiro",
            "marÇo",
            "abril",
            "maio",
            "junho",
            "julho",
            "agosto",
            "setembro",
            "outubro",
            "novembro",
            "dezembro"
        );        
        
        

        $mes = intval(date("m",strtotime($data)));
        
        $dia = date("d");
        if($dia == 1) // se hoje for dia primeiro, exibe o mes passado
        $mes -= 1;

        if(($mes -1) == 0 ){
            return strtoupper($meses[12]);
        }else{
            return strtoupper($meses[$mes]);
        }
        
    }
}
