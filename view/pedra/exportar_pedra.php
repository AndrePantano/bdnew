 <?php
include "../../controller/pedra/pedra_relatorio_controller.php";

require_once '../../phpexcel/PHPExcel.php';

$con = new Pedra_Relatorio_Controller();

$dados = $con->getExportarPedra();

$html = "<html><head></head><body>"
 ."<table border='1'>
    <thead>
      <tr>
        <th> Corredor   </th>
        <th> Origem     </th>
        <th> Cliente    </th>
        <th> ".date("d/m")." </th>
        <th> ".date("d/m", strtotime("+1 Day"))." </th>
        <th> ".date("d/m", strtotime("+2 Day"))." </th>
        <th> ".date("d/m", strtotime("+3 Day"))." </th>
      </tr>
    </thead>
    <tbody>";

    foreach ($dados as $dado){
      $html .= ""
      ."<tr>"
        ."<td>".$dado['idCorredor']."</td>"
        ."<td>".$dado['sgTerminal']."</td>"
        ."<td>".(mb_detect_encoding($dado['nmCliente'])== "UTF-8"? utf8_decode($dado['nmCliente']):$dado['nmCliente'])."</td>"
       // ."<td>".$dado['nmCliente']."</td>"
        ."<td>".$dado['re_d']."</td>"
        ."<td>".$dado['re_dmai']."</td>"
        ."<td>".$dado['re_dmaii']."</td>"
        ."<td>".$dado['re_dmaiii']."</td>"
      ."</tr>";
    }
    $html .= "</tbody></table></body></html> ";

$filename = "DownloadReport";
$table    = $html;

// save $table inside temporary file that will be deleted later
$tmpfile = tempnam(sys_get_temp_dir(), 'html');
file_put_contents($tmpfile, $table);

// insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
$objPHPExcel     = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('any name you want'); // Change sheet's title if you want

unlink($tmpfile); // delete temporary file because it isn't needed anymore

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
header('Content-Disposition: attachment;filename='.$filename); // specify the download file name
header('Cache-Control: max-age=0');

// Creates a writer to output the $objPHPExcel's content
$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$writer->save('php://output');
exit;

//echo $html;
