 <?php
include "../../controller/funcionario/funcionario_controller.php";

$con = new Funcionario_Controller();
$funcionarios = $con->getFuncionarios();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Funcionarios</title>
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
                        <a href="insert.php" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Adicionar Funcionario</a>                     
                        <label class="h3 page-header"><i class="fa fa-users"></i> Funcionarios</label>                                            
                        <ol class="breadcrumb">
                          <li class="active">Funcionarios</li>
                        </ol>
                      </div>
                    </div>

                  <div class="panel panel-default">
                    <div class="panel-heading"></div>
                      <div class="panel-body">
                      <?php if(count($funcionarios) > 0 ): ?>
                        <div class="table-responsive">
                          <table class="table table-striped table-condensed table-hover">
                            <thead>
                              <tr>                                                      
                                <th>Funcionário</th>
                                <th>Funcão</th>                                                        
                                <th>Corredor</th>
                                <th>Estatus</th>
                              </tr>
                            </thead>                          
                            <tbody>
                              <?php foreach ($funcionarios as $k => $funcionario):?>                         
                                <tr data-id="<?=$funcionario->getIdFuncionario()?>" class="linha">                                                                  
                                  <td><?= $funcionario->getNmFuncionario()?></td>
                                  <td><?= $funcionario->getFuncao()->getNmFuncao() ?></td>                               
                                  <td><?= $funcionario->getCorredor()->getNmCorredor() ?></td>                               
                                  <td><?= $funcionario->getEstatus()->getNmEstatus() ?></td>                               
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