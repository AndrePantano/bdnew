 <?php
include "../../controller/terminal/terminal_controller.php";

$con = new Terminal_Controller();
$terminais = $con->getTerminais();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Terminais</title>
        <script type="text/javascript" src="js/script.js"></script>
    </head>

    <body>
        <div class="container">        

            <?php include "../layout/navbar.php"; ?>
            
            <?php include "../services/mensagens.php"; ?>

            <div class="row">

              <?php include "../layout/sidebar_config.php"; ?>

               <div class="col-sm-6">
                

                  <div class="row">                    
                      <div class="col-sm-12">
                        <a href="insert.php" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Adicionar Terminal</a>                     
                        <label class="h3 page-header"><i class="fa fa-industry"></i> Terminais</label>                                            
                        <ol class="breadcrumb">
                          <li class="active">Terminais</li>
                        </ol>
                      </div>
                    </div>

                  <div class="panel panel-default">
                    <div class="panel-heading"></div>
                      <div class="panel-body">
                      <?php if(count($terminais) > 0 ): ?>
                        <div class="table-responsive">
                          <table class="table table-striped table-condensed table-hover">
                            <thead>
                              <tr>                      
                                <th>Terminal</th>
                                <th>Sigla</th>
                                <th>Corredor</th>
                              </tr>
                            </thead>                          
                            <tbody>
                              <?php foreach ($terminais as $k => $terminal):?>                         
                                <tr data-id="<?=$terminal->getIdTerminal()?>" class="linha">                                
                                  <td><?= $terminal->getNmTerminal()?></td>
                                  <td><?= $terminal->getSgTerminal()?></td>
                                  <td><?= $terminal->getCorredor()->getNmCorredor() ?></td>                               
                                </tr>                              
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      <?php else: ?>
                        <div class="jumbotron">
                          <h1>Ops!</h1>
                          <p>Não foram encontrados registros!</p>
                        </div>
                      <?php endif; ?>
                      </div>                      
                    <div class="panel-footer"></div>
                  </div>

              </div>
            </div>

            <?php include "../layout/rodape.php"; ?>
        </div>
    </body>
</html>