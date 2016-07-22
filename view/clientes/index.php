 <?php
include "../../controller/cliente/cliente_controller.php";

$con = new Cliente_Controller();
$clientes = $con->getClientes();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Clientes</title>
        <script type="text/javascript" src="js/script.js"></script>
    </head>

    <body>
        <div class="container">        

            <?php include "../layout/navbar.php"; ?>
            
            <?php include "../services/mensagens.php"; ?>

            <div class="row">

              <?php include "../layout/sidebar_config.php"; ?>

               <div class="col-sm-8">
                

                  <div class="row">                    
                      <div class="col-sm-12">
                        <a href="insert.php" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Adicionar Cliente</a>                     
                        <label class="h3 page-header"><i class="fa fa-users"></i> Clientes</label>                                            
                        <ol class="breadcrumb">
                          <li class="active">Clientes</li>
                        </ol>
                      </div>
                    </div>

                  <div class="panel panel-default">
                    <div class="panel-heading"></div>
                      <div class="panel-body">
                      <?php if(count($clientes) > 0 ): ?>
                        <div class="table-responsive">
                          <table class="table table-striped table-condensed table-hover">
                            <thead>
                              <tr>
                                <th>C&oacute;d.</th>                   
                                <th>Cliente</th>
                                <th>Fluxo</th>
                                <th>Terminal</th>
                                <th>Pedra</th>                                                       
                              </tr>
                            </thead>                          
                            <tbody>
                              <?php foreach ($clientes as $k => $cliente):?>                         
                                <tr data-id="<?=$cliente->getIdCliente()?>" class="linha">
                                  <td class="text-muted"><?= $cliente->getIdCliente() < 100 ? $cliente->getIdCliente() < 10? "00". $cliente->getIdCliente() : "0". $cliente->getIdCliente() : $cliente->getIdCliente() ?></td>                             
                                  <td><?= $cliente->getNmCliente()?></td>
                                  <td><?= $cliente->getFxCliente()?></td>
                                  <td><?= $cliente->getTerminal()->getNmTerminal() ?></td>                               
                                  <td><?= $cliente->getPeCliente()?"Ativa":"Inativa" ?></td>                               
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