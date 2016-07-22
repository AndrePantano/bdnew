<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";

}else{
    include "../../controller/services/sessao_controller.php";    
    //include "../services/sessao_controller.php";
    include "../services/captcha_controller.php";   
}

class Importar_Controller extends Sessao_Controller{
   	private $dbal;

    public function __construct() {
    	$this->dbal = new DBAL_Model();
        $this->getAutenticarSessao();
    }
    public function DBAL(){
        return $this->dbal;
    }
    
}

/*
function GravaDados($data){

    $con = new Importar_Controller();

    $tabela = "relatorio_ordem_transporte";
    $valores = array(
        "Ordem_Transporte" => addslashes($data[0]),
        "Conteiner" => addslashes($data[1]),
        "Armador" => addslashes($data[2]),
        "Fluxo" => addslashes($data[3]),
        "Descricao" => addslashes($data[4]),
        "Cliente" => addslashes($data[5]),
        "Companhia_Abertura" => addslashes($data[6]),
        "Data_Abertura" => addslashes($data[7]),
        "Data_Hora_Gate" =>  addslashes($data[8]),
        "Situacao" => addslashes($data[9]),
        "Status" => addslashes($data[10]),
        "Cia_Faturamento" => addslashes($data[11]),
        "Nota_Fiscal" => addslashes($data[12]),
        "Serie_NF" => addslashes($data[13]),
        "Data_Emissao" => addslashes($data[14]),
        "Valor_Total" => addslashes($data[15]),
        "Peso_Bruto" => addslashes($data[16]),
        "Chave_de_Acesso" => addslashes($data[17]),
        "Referencia_NF" => addslashes($data[18]),
        "SGLog" => addslashes($data[19]),
        "Logix" => addslashes($data[20]),
        "Data_Faturamento" => addslashes($data[21]),
        "Referencia" => addslashes($data[22]),
        "Lacre_Entrada" => addslashes($data[23]),
        "Lacre_Saida" => addslashes($data[24]),
        "Lacre_Agencia" => addslashes($data[25]),
        "Lacre_SIF" => addslashes($data[26]),
        "Lacre_Receita" => addslashes($data[27]),
        "Lacre_Armador" => addslashes($data[28]),
        "Lacre_Interno" => addslashes($data[29]),
        "Lacre_Inspetora" => addslashes($data[30]),
        "Navio" => addslashes($data[31]),
        "Codigo_Navio" => addslashes($data[32]),
        "Booking" => addslashes($data[33]),
        "Deadline" => addslashes($data[34]),
        "Deadline_Calculado" => addslashes($data[35]),
        "Deadline_Cliente" => addslashes($data[36]),
        "Deadline_Extendido" => addslashes($data[37]),
        "Leadtime" => addslashes($data[38]),
        "Temperatura" => addslashes($data[39]),
        "Set_Point" => addslashes($data[40]),
        "Supply" => addslashes($data[41]),
        "Porto_Origem" => addslashes($data[42]),
        "Porto_Destino" => addslashes($data[43]),
        "Encerramento_OT" => addslashes($data[44]),
        "Carta_Porte" => addslashes($data[45]),
        "Instrucao_de_Embarque" => addslashes($data[46]),
        "Fatura_Comercial" => addslashes($data[47]),
        "Fluxo_de_Transporte" => addslashes($data[48]),
        "Programacao_Intermodal" => addslashes($data[49]),
        "Tipo_conteiner" => addslashes($data[50])
    );

    return $con->DBAL()->Insert($tabela, $valores);

}

function MoverArquivo($arquivo){
            
    if($_FILES['csv']["size"] > 2000000){
        $target_path = "../../view/importar/";
        $target_path = $target_path . basename( $_FILES['csv']['name']); 
        $msg .= "O arquivo excede a capacidade de envio!";
    }else{
        if(move_uploaded_file($_FILES['csv']['tmp_name'], $target_path)) {
            $msg .= "O arquivo ".  basename( $_FILES['csv']['name'])." foi enviado.";
        } else{
            $msg .= "Houve um erro no enviou do arquivo, tente outra vez!";
        }
    }  

}
*/
/*
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $msg = "";
        
    if (isset($_FILES["csv"]) && ($_FILES["csv"]["type"] == "application/vnd.ms-excel")) { 
        set_time_limit(240);            
        
        $file = $_FILES['csv']['tmp_name']; 
        $handle = fopen($file,"r"); 
        
        $con = new Importar_Controller();
        $i = 0;
        $tabela = "fpt";
                
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE){

            if($data > 0){

                //VERIFICA SE HÁ BOOKING CADASTRADADOS NA TABELA PROGRAMAÇÃO
                if(count($con->DBAL()->Query("SELECT * FROM programacao WHERE bkProgramacao = '".addslashes($data[3])."';")) > 0){

                    // VERIFICA SE HÁ BOOKING CADASTRADO NA TABELA FPT
                    // SE SIM, ATUALIZA, SE NÃO, CRIA O REGISTRO
                    if(count($con->DBAL()->Query("SELECT * FROM fpt WHERE ot =".addslashes($data[2]))) == 0){
                        $valores = array(
                            "ot" => addslashes($data[2]),
                            "booking" => addslashes($data[3]),
                            "ocorrencia" => addslashes($data[0]),
                        );
                        $con->DBAL()->Insert($tabela, $valores);
                    }else{
                        $valores = array(
                            "booking" => addslashes($data[3]),
                            "ocorrencia" => addslashes($data[0]),
                        );
                        $con->DBAL()->Update($tabela, "ot =".addslashes($data[2]), $valores) ;   
                    }
                }
           }
        } 

        $msg = 4;       
    }else{
         $msg = 6;
    }
        
    header('Location: ../../view/importar/importar.php?msg='.base64_encode($msg)."&t=".base64_encode($time)."&qtd=".$msg);
}
*/

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $msg = "";
         
    $file = $_FILES['csv']['tmp_name']; 
    $handle = fopen($file,"r"); 
    
    $con = new Importar_Controller();
    $i = true;
    $tabela = "ritmo";
         
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){

        if($data > 0){                
                         
            if($i){
                $con->DBAL()->QueryNoReturn("DELETE FROM ritmo WHERE idCorredor = ".addslashes($data[0]) ); 
            }

            $valores = array(                       
                "idCorredor"    => addslashes($data[0]),
                "terminal"      => addslashes($data[1]),
                "cliente"       => addslashes($data[2]),
                "orcamento"     => addslashes($data[3]),
                "programa"      => addslashes($data[4]),
                "ritmo"         => addslashes($data[5]),
                "acumulado"     => addslashes($data[6]),
                "atualizado_em" => addslashes($data[7])
            );
            $con->DBAL()->Insert($tabela, $valores);
            $i = false;
       }
    } 

    $msg = 4;       

    header('Location: ../../view/importar/importar.php?msg='.base64_encode($msg));
}