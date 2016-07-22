<?php
include "../../controller/pedra/pedra_relatorio_controller.php";
$con = new Pedra_Relatorio_Controller();

$data_inicio = date("Y-m")."-01";
$data_fim = date("Y-m-d");

if(isset($_GET["i"]) && isset($_GET["f"])){
  $data_inicio = base64_decode($_GET["i"]);
  $data_fim = base64_decode($_GET["f"]);
}

$con->getGerarRelatorio($data_inicio,$data_fim);

$clientes = $con->getResumoClientes();
$origens = $con->getResumoOrigens();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Pedra Dia</title>
        <script type="text/javascript" src="js/script.js"></script>
        <style type="text/css">
          .titulo_coluna{
            text-align: center;       
          }
          .titulo_coluna, .table_body{
            //font-size: 12px;
          }
          .celula_valor{
            text-align: right; 
            padding-right: 30px;           
          }         
          .border-cells{
            border: 1px solid #DDD;
          }
          .celula_total{
            font-weight: bold;
          }
        </style>
    </head>

    <body>
        <div class="container">

          <?php include "../layout/navbar.php"; ?>
            
          <?php include "../services/mensagens.php"; ?>

            <div class="row">
              <div class="col-sm-12">                
                <h3 class="page-header"><i class="fa fa-legal fa-rotate-90"></i> Rel. Perdas e Responsabilidades</h3>             
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">  
               <form class="navbar-form" role="search" method="POST" action="../../controller/pedra/pedra_relatorio_controller.php">
                    <label>Período:</label>
                    <div class="input-group">
                      <span class="input-group-addon">De:</span>
                      <input type="date" class="form-control input-sm" name="data_inicio" value="<?= isset($_GET["i"])?base64_decode($_GET["i"]): date("Y-m")."-01"?>">
                    </div>
                    <div class="input-group">
                      <span class="input-group-addon">Até:</span>
                      <input type="date" class="form-control input-sm" name="data_fim" value="<?= isset($_GET["f"])?base64_decode($_GET["f"]): date("Y-m-d")?>">
                    </div>
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>                    
                </form>           
                <br/>
                <br/>
              </div>
            </div>
            
            <div class="row">

                <?php                 
                  if(count($clientes) > 0){ ?>


                    <div class="col-sm-6 col-sm-offset-3">
                        <span>Rel. Perdas e Responsabilidade de <strong> <?= isset($_GET["i"])?date("d/m/Y", strtotime(base64_decode($_GET["i"]))): date("d/m/Y", strtotime($data_inicio))?></strong> até <strong> <?= isset($_GET["f"])?date("d/m/Y", strtotime(base64_decode($_GET["f"]))): date("d/m/Y", strtotime($data_fim))?></strong></span>
                        <div class="btn-group pull-right">
                          <button type="button" class="btn btn-default btn-sm dropdown-toggle" title="Exportar Relatório" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download"></i> Exportar <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a href="exportar.php?i=<?= isset($_GET['i'])?$_GET['i']: base64_encode($data_inicio)?>&f=<?= isset($_GET['f'])? $_GET['f'] : base64_encode($data_fim)?>" target="_blank"><i class="fa fa-file-excel-o"></i> Para CSV</a></li>                            
                          </ul>
                        </div>
                    </div>
                    
                    <br/><br/>

                    <div class="col-sm-6 col-sm-offset-3">
                     
                     <div class="panel panel-default">
                       <div class="panel-heading">
                        <div class="row">
                          <div class="col-sm-6"><h5>Resumo por Origem</h5></div>                          
                        </div>
                       </div>
                       
                        <div class="table-responsive">
                          <table class="table table-condensed table-hover table-striped table-bordered">
                            <thead>
                            <tr>
                              <th class="titulo_coluna">Origem</th>
                              <th class="titulo_coluna">(&Sigma;) Terminal</th>
                              <th class="titulo_coluna">(&Sigma;) Operacional</th>
                              <th class="titulo_coluna">(&Sigma;) Comercial</th>
                              <th class="titulo_coluna">Total</th>
                            </tr>
                            </thead>
                            <tbody class="table_body">
                              <?php 
                              $total_terminal = $total_comercial = $total_operacional = $total_total = 0;
                              foreach ($origens as $origem): ?>
                                <tr>
                                  <td><?= $origem["unidade"] ?></td>
                                  <td class="celula_valor"><?= $origem["Terminal"] ?></td>
                                  <td class="celula_valor"><?= $origem["Operacional"] ?></td>
                                  <td class="celula_valor"><?= $origem["Comercial"] ?></td>
                                  <td class="celula_valor celula_total"><?= $origem["Total"] ?></td>
                                </tr>
                              <?php 
                                $total_terminal    += $origem["Terminal"];
                                $total_comercial   += $origem["Comercial"];
                                $total_operacional += $origem["Operacional"];
                                $total_total += $origem["Total"];
                              endforeach;?>           
                            </tbody>
                            <tfoot class="table_body">
                              <tr>
                                <td><label>Total</label></td>
                                <td class="celula_valor"><label><?= $total_terminal?></label></td>
                                <td class="celula_valor"><label><?= $total_operacional?></label></td>
                                <td class="celula_valor"><label><?= $total_comercial?></label></td>
                                <td class="celula_valor"><label><?= $total_total?></label></td>
                              </tr>                                                    
                            </tfoot>
                          </table>
                        </div>
                        <div class="panel-footer"></div>
                     </div>
               
                     <div class="panel panel-default">
                       <div class="panel-heading">
                        <div class="row">
                          <div class="col-sm-6"><h5>Resumo por Cliente</h5></div>                         
                        </div>
                       </div>
                       
                        <div class="table-responsive">
                          <table class="table table-condensed table-hover table-striped table-bordered">
                            <thead>
                            <tr>
                              <th class="titulo_coluna">Origem</th>
                              <th class="titulo_coluna">Cliente</th>
                              <th class="titulo_coluna">(&Sigma;) Terminal</th>
                              <th class="titulo_coluna">(&Sigma;) Operacional</th>
                              <th class="titulo_coluna">(&Sigma;) Comercial</th>
                              <th class="titulo_coluna">Total</th>
                            </tr>
                            </thead>
                            <tbody class="table_body">
                              <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                  <td><?= $cliente["unidade"] ?></td>
                                  <td><?= $cliente["cliente"] ?></td>
                                  <td class="celula_valor"><?= $cliente["Terminal"] ?></td>
                                  <td class="celula_valor"><?= $cliente["Operacional"] ?></td>
                                  <td class="celula_valor"><?= $cliente["Comercial"] ?></td>
                                  <td class="celula_valor celula_total"><?= $cliente["Total"] ?></td>
                                </tr>
                              <?php endforeach;?>           
                            </tbody>
                            <tfoot>                          
                            </tfoot>
                          </table>
                        </div>
                        <div class="panel-footer"></div>
                     </div>
                    </div>

                  <?php }else{?>
                    <div class="col-sm-6 col-sm-offset-3">
                      <div class="jumbotron">
                        <h1>Ops!</h1>
                        <p>Não foram encontrados registros!</p>
                      </div>
                    </div>
                  <?php }?>
            </div>

            <?php include "../layout/rodape.php"; ?>
        </div>
    </body>
</html>