 <?php
include "../../controller/pedra/pedra_gate_ajustes_controller.php";
$con = new Pedra_Gate_Ajustes_Controller();

$dados = array();


// ATRIBUI AS CHAVE E O VALOR
$chave = "";
$valor = "";

// ATRIBUI A CHAVE E VALOR PARA CLIENTE
if (isset($_GET["cl"]) && $_GET["cl"] !=""){
  $chave = "idCliente";
  $valor = $_GET["cl"];
}else{
  
  // ATRIBUI A CHAVE E VALOR PARA TERMINAL
  if (isset($_GET["te"]) && $_GET["te"] !=""){
    $chave = "idTerminal";
    $valor = $_GET["te"];
  }else{
    
    // ATRIBUI A CHAVE E VALOR PARA CORREDOR
    if (isset($_GET["co"]) && $_GET["co"] !=""){
      $chave = "idCorredor";
      $valor = $_GET["co"];
    }
  }
}

// ATRIBUI AS DATAS PARA AS VARIÁVEIS
$inicio = "";
$fim = "";

if(isset($_GET["di"]) && isset($_GET["df"])){
  $inicio = $_GET["di"];
  $fim = $_GET["df"];
}

if($chave != "" && $valor != "" && $inicio != "" && $fim != "")
  $dados = $con->getExportarPedras($chave,$valor,$inicio,$fim);


$html =
  "<table border='1' style='background-color:transparent;'>
    <thead>
      <tr>
        <th> FLuxo     </th>
        <th> Cliente    </th>
        <th> Terminal     </th>
        <th> Data     </th>
        <th> Prévia       </th>        
        <th> Real </th>        
        <th> Atualizado por </th>        
        <th> Motivo da Perda </th>        
        <th> Descrição Perda </th>        
      </tr>
    </thead>
    <tbody>";

    foreach ($dados as $dado){
      $html .= ""
      ."<tr>"
        ."<td>".$dado['fxCliente']."</td>"
        ."<td>".$dado['nmCliente']."</td>"
        ."<td>".$dado['nmTerminal']."</td>"
        ."<td>".date("d/m/Y",strtotime($dado['dtPedra']))."</td>"
        ."<td>".$dado['pvPedra']."</td>"
        ."<td>".$dado['rePedra']."</td>"
        ."<td>".$dado['nmFuncionario']."</td>"
        ."<td>".$dado['nmPedraMotivo']."</td>"
        ."<td>".$dado['obPedra']."</td>"
        ."<td></td>"
      ."</tr>";
    }

    $html .= "</tbody></table>";


// Determina que o arquivo é uma planilha do Excel
header("Content-type: application/vnd.ms-excel");  

// Força o download do arquivo
header("Content-type: application/force-download"); 

// Seta o nome do arquivo
header("Content-Disposition: attachment; filename=Pedra_Gate_Ajustes-".date("YmdHis").".xls");
header("Pragma: no-cache");

//Convert os caracteres para Excel 
//echo iconv("UTF-8", "", $html);
echo iconv("UTF-8", "ISO-8859-1//TRANSLIT", $html);
//echo($html);



              