 <?php
include "../../controller/pedra/pedra_relatorio_controller.php";
$con = new Pedra_Relatorio_Controller();

$dados = $con->getExportarMotivos($_GET["i"],$_GET["f"]);

$html =
  "<table border='1' style='background-color:transparent;'>
    <thead>
      <tr>
        <th> Origem     </th>
        <th> Cliente    </th>
        <th> Delta      </th>
        <th> Motivo     </th>
        <th> Data       </th>        
        <th> Observação </th>        
      </tr>
    </thead>
    <tbody>";

    foreach ($dados as $dado){
      $html .= ""
      ."<tr>"
        ."<td>".$dado['origem']."</td>"
        ."<td>".$dado['cliente']."</td>"
        ."<td>".$dado['delta']."</td>"
        ."<td>".$dado['motivo']."</td>"
        ."<td>".date("d/m/Y",strtotime($dado['data']))."</td>"
        ."<td></td>"
      ."</tr>";
    }
    $html .= "</tbody></table>";


// Determina que o arquivo é uma planilha do Excel
header("Content-type: application/vnd.ms-excel");  

// Força o download do arquivo
header("Content-type: application/force-download"); 

// Seta o nome do arquivo
header("Content-Disposition: attachment; filename=Perdas_Motivos.xls");
header("Pragma: no-cache");

//Convert os caracteres para Excel 
//echo iconv("UTF-8", "", $html);
echo iconv("UTF-8", "ISO-8859-1//TRANSLIT", $html);
//echo($html);
