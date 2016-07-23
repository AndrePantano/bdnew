<?php

include "../../controller/pedra/pedra_relatorio_controller.php";

$con = new Pedra_Relatorio_Controller();

$dados = $con->getExportarPedra();

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Sao_Paulo');
if (PHP_SAPI == 'cli') die ('This example should only be run from a Web Browser');

require_once '../../phpexcel/PHPExcel.php';

$table = array();

$head = array(
   "Corredor",
   "Origem",
   "Cliente",
   date("d/m"),
   date("d/m",strtotime("+1 Day")),
   date("d/m",strtotime("+2 Day")),
   date("d/m", strtotime("+3 Day"))
);

array_push($table, $head);

foreach ($dados as $dado){
   
   $tr = array( 
         $dado['idCorredor'],
         $dado['sgTerminal'],
         $dado['nmCliente'],
         $dado['re_d'],
         $dado['re_dmai'],
         $dado['re_dmaii'],
         $dado['re_dmaiii']
      );
   
   array_push($table, $tr);        

}

$objPHPExcel = new PHPExcel();
$objWorksheet = $objPHPExcel->getActiveSheet();
$objWorksheet->fromArray($table, null, 'A1', true );

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$cellIterator = $objWorksheet->getRowIterator()->current()->getCellIterator();
$cellIterator->setIterateOnlyExistingCells( true );

//AJUSTA O WITH DAS COLUNAS
foreach( $cellIterator as $cell ) {
        $objWorksheet->getColumnDimension( $cell->getColumn() )->setAutoSize( true );
}

$objWriter->save("Pedra.xls");
header('Location: Pedra.xls');
//unlink('sheet.xls');

exit;