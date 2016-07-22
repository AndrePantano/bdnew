<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";
}else{
    include "../services/sessao_controller.php";    
}

class Pedra_Gate_Controller extends Sessao_Controller{
    private $dbal;
    private $tabela = "pedra";
    private $valores = array();    
    private $dias = array("DOM","SEG","TER","QUA","QUI","SEX","SÁB");
    private $corredor;

    public function __construct() {
        $this->dbal = new DBAL_Model();
        $this->getAutenticarSessao();
        //$this->MovimentarPedra();
        $this->corredor = $this->getIdCorredorFuncionarioSessao();
    }
    public function DBAL(){

        return $this->dbal;
    }
    /*
    // RETORNA A DATA DA ULTIMA MOVIMENTAÇÃO DA PEDRA
    public function getDataUltimaMovimentacaoPedra(){
        $data = $this->DBAL()->query("SELECT MAX(dmPedra) as data FROM ".$this->tabela);
        return $data[0]["data"];
    }
    */
    // ATUALIZA OS DADOS DA PEDRA
    public function update($idPedra){
        $idCampo = "idPedra = ".$idPedra;
        $this->DBAL()->Update($this->tabela, $idCampo, $this->valores);
        
        if($this->valores["idPedraMotivo"] == ""){
            $criterio = array("idPedraMotivo" => NULL);
            $this->DBAL()->Update("pedra", $idCampo, $criterio);
        }
    }

    // SETA OS VALORES PADRAO
    public function setValores($dados){
        $this->valores["rePedra"] = $dados["repedra"];
        $this->valores["idFuncionario"] = $this->getIdFuncionarioSessao();
        $this->valores["daPedra"] = date("Y-m-d H:i:s");            
        $this->valores["idPedraMotivo"] = $dados["idpedramotivo"];
        $this->valores["obPedra"] = $dados["obpedra"];
    }

    public function getDados($terminal){

        return $this->Query($terminal, 1);
    }

    // RETORNA TODOS OS CLIENTES QUE POSSUEM PEDRA ATIVA DO TERMINAL ESPECÍFICO
    public function Query($terminal, $d){
        
        // SE O TERMINAL FOR NULO É PORQUE A PEDRA SERÁ ATUALIZADA
        // RETORNANDO TODOS OS CLIENTES COM PEDRA ATIVA DE TODOS OS CORREDORES
        $criterio = "";
        if(!is_null($terminal))
            $criterio = " AND idTerminal = ".$terminal
                ." AND idCorredor = ". $this->corredor;

        $query = " SELECT * FROM cliente "
            ." JOIN pedra USING(idCliente)"
            ." JOIN pedra_dia USING(idCliente)"
            ." JOIN terminal USING(idTerminal)"
            ." LEFT JOIN pedra_motivo USING(idPedraMotivo)"         
            ." WHERE "
                ." peCliente = TRUE AND "
                ." dtPedra = '".date("Y-m-d",strtotime("- ".$d." day"))."'"                
                .$criterio
            ." ORDER BY nmCliente";
        
        $resultado = $this->DBAL()->Query($query);
        
        // SE NÃO EXISTIR O D-1 RETORNA NO MAIS RECENTE
        if(count($resultado) > 0){
            return $resultado;
        }else{
            $d++;
            return $this->Query($terminal,$d);
        }
    }

    // RETORNA OS DADOS DO TERMINAL ESPECIFICO
    public function getDadosTerminal($id){

        return $this->getDados($id);
    }

/*
    // MOVIMENTA A PEDRA QUANDO NECESSÁRIO
    public function MovimentarPedra(){

        // Usa a função strtotime() e pega o timestamp das duas datas:
        
        // ultima movimentação da pedra
        $time_inicial = strtotime(date("Y-m-d",strtotime($this->getDataUltimaMovimentacaoPedra())));
        // hoje
        $time_final = strtotime(date("Y-m-d"));
        
        // Calcula a diferença de segundos entre as duas datas:
        $diferenca = $time_final - $time_inicial; // 19522800 segundos
        
        // Calcula a diferença de dias
        $dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
             
        if($dias > 0){
                        
            $dados = $this->Query(null,1);
            
            //    if(count($dados) > 0 ){
            //        echo "Diferente em dias da ultima movimentação até hoje = ".$dias."<br/>";
            //        echo "Quantidades de clientes para alterar = ".count($dados)."<br/>";
            //    }
                
            if(count($dados) > 0){

                foreach($dados as $dado){

                    // PARA CADA CLIENTE ATUALIZA A TABELA PEDRA DIA:
                    $pedra_dia = array(
                        "pv_d"       => $dado["re_dmai"],
                        "pv_dmai"    => $dado["re_dmaii"],
                        "pv_dmaii"   => $dado["re_dmaiii"],
                        "re_d"       => 0,
                        "re_dmai"    => 0,
                        "re_dmaii"   => 0,
                        "re_dmaiii"  => 0
                    );

                    $idCampo = "idCliente = ".$dado["idCliente"];
                    
                    $this->DBAL()->Update("pedra_dia", $idCampo, $pedra_dia);

                    
                    // BUSCA A ULTIMA PEDRA DESTE CLIENTE
                    $ultima_pedra = $this->getUltimaPedraCliente($dado['idCliente']);

                    // SE A PREVIA E O REAL DA ÚLTIMA PEDRA FOREM ZERADOS, 
                    // ATUALIZA A DATA DA ULTIMA PEDRA PARA D-1
                    // CASO CONTRARIO
                    // CRIA UM NOVO REGISTRO NA TABELA PEDRA
                    if($ultima_pedra['pvPedra'] == 0 && $ultima_pedra['rePedra'] == 0){ 
                        
                        $idCampo = "idPedra = ".$ultima_pedra['idPedra'];
                        $valores = array(
                            'dtPedra' => date("Y-m-d",strtotime("-1 day"))
                        );                        
                        $this->DBAL()->Update("pedra", $idCampo, $valores);
                        
                    }else{
                
                        $pedra = array(
                            "dtPedra"   => date("Y-m-d",strtotime("-1 day")),
                            "pvPedra"   => $dado["re_d"],
                            "rePedra"   => 0,
                            "daPedra"   => date("Y-m-d H:i:s"),
                            "dmPedra"   => date("Y-m-d H:i:s"),
                            "idCliente" => $dado["idCliente"]
                        );
                        $this->DBAL()->Insert("pedra",$pedra);
                    }
                }
            }
        
        }
    }

    // RETORNA A ÚLTIMA PEDRA DO CLIENTE
    public function getUltimaPedraCliente($idCliente){
        $resultado = $this->DBAL()->Query("SELECT * FROM pedra WHERE idCliente = ".$idCliente." ORDER BY dtPedra DESC LIMIT 1");
        return $resultado[0];
    }
*/
    // RETORNA TODOS OS TERMINAIS DO CORREDOR DO USUARIO QUE TEM PEDRA ATIVA
    public function getTerminaisComPedra(){
                
        $query = "SELECT * FROM cliente"
        ." JOIN terminal USING(idTerminal)"
        ." JOIN corredor USING(idCorredor)"
        ." WHERE"
            ." peCliente = TRUE AND "                
            ." idCorredor = ". $this->corredor
        ." GROUP BY idTerminal"
        ." ORDER BY nmTerminal ASC";
        
        return $this->DBAL()->Query($query);
    }

    // RETORNA TODOS OS MOTIVOS DA PEDRA
    public function getPedraMotivo(){

        return $this->DBAL()->Query("SELECT * FROM pedra_motivo");
    }
 
    // RETORNA TODOS OS CORREDORES
    public function getCorredores(){

        return $this->DBAL()->Query("SELECT * FROM corredor");
    }

    // RETORNA O CORREDOR ATUAL
    public function getCorredorDaPedra(){

        return $this->corredor;
    }

    // ALTERA O CORREDOR ATUAL
    public function setCorredorDaPedra($id){

        $this->corredor = $id;
    }

    // RETORNA O CORREDOR DO USUARIO ATUAL
    public function getFuncaoUsuarioAtual(){

        return $this->getIdFuncaoFuncionarioSessao();
    }

    // RETORNA O DIA DA SEMANA
    public function getDiaSemana($dia){

        return $this->dias[$dia];
    }   
}

class Pedra_Gate_Dia_Controller extends Pedra_Gate_Controller{
    
    private $tabela = "pedra_dia";
    private  $valores = array();

    public function __construct() {
        parent::__construct();
    }
    public function DBAL(){
        return parent::DBAL();
    }
    public function update($idCliente){
        $condicao = "idCliente =".$idCliente;
        $this->DBAL()->Update($this->tabela, $condicao, $this->valores);
    }    
    public function setValores($dados){
        $this->valores["re_d"]       = $dados["re_d"];
        $this->valores["re_dmai"]    = $dados["re_dmai"];
        $this->valores["re_dmaii"]   = $dados["re_dmaii"];
        $this->valores["re_dmaiii"]  = $dados["re_dmaiii"];
    }
    
} 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["acao"])){
                
        $msg = "msg=";
            $dados = unserialize(serialize($_POST));
            //echo "<pre>".print_r($dados,1)."</pre>";

            $pedra = new Pedra_Gate_Controller();
            $pedra->setValores($dados);
            switch ($_POST["acao"]) {            
                case 'edit':                             
                    $pedra->update($_POST["idpedra"]);
                    $pedra_dia = new Pedra_Gate_Dia_Controller();
                    $pedra_dia->setValores($dados);
                    $pedra_dia->update($_POST["idcliente"]);
                    $msg .= base64_encode(1);
                    break;
            } 
        header("Location: ../../view/pedra/pedra_gate.php?t=".$_POST["idterminal"]."&".$msg);


    }
}
