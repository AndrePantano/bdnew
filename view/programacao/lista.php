 <?php
include "../../controller/programacao/programacao_controller.php";

$con = new Programacao_Controller();
$programacoes = $con->Lista();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Programação - Lista</title>
        <script type="text/javascript" src="js/script.js"></script>

        <!-- atualiza a página -->
        <!-- meta http-equiv="refresh" content="60" -->

        <!-- data table CSS -->
        <link rel="stylesheet" type="text/css" href="../../dataTable/datatable.css">
        
        <!-- data javaScript -->
        <script type="text/javascript" charset="utf8" src="../../dataTable/datatable.js"></script>

    </head>

    <body>
        <div class="container">
            <?php include "../layout/navbar.php"; ?>
            
            <?php include "../services/mensagens.php"; ?>

            <div class="row">
                <div class="col-sm-12">
                    <h2><span class="glyphicon glyphicon-th"></span> Lista de Programações</h2>                    
                </div>
            </div>
           
            <div class="row">
               <div class="col-sm-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <?php if(count($programacoes) > 0 ): ?>
          
                      <!-- Brand and toggle get grouped for better mobile display -->
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle" style="background-color:transparent;border: 1px solid #008a69;" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">        
                          <span class="sr-only">Toggle navigation</span>
                                  <span class="icon-bar" style="background-color:#008a69;"></span>
                                  <span class="icon-bar" style="background-color:#008a69;"></span>
                                  <span class="icon-bar" style="background-color:#008a69;"></span>                
                        </button>
                        <a class="navbar-brand sub-nav" href="#bs-example-navbar-collapse-2" data-toggle="collapse" style="color:#008a69;">Opções</a>
                      </div>

                      <!-- Collect the nav links, forms, and other content for toggling -->
                      <!-- div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">                        
                        <ul class="nav navbar-nav navbar-right">        
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Exportar <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="../services/exportar_xls.php" target="_blank"><span class="glyphicon glyphicon-list-alt"></span> MS-Excel</a></li>
                            </ul>
                          </li>
                        </ul>
                      </div --><!-- /.navbar-collapse -->
                      
                    <?php endif; ?>
                  </div>
                  <div class="panel-body">
                    <?php if(count($programacoes) > 0 ): ?>
                      <div class="table-responsive">
                        <table class="table table-striped table-hover table-condensed lista-programacoes" id="lista" style="font-size:10px;">
                          <thead>
                            <tr>                              
                              <th>Criação</th>
                              <th>Solicitação</th>
                              <th>Terminal</th>
                              <th>Cliente</th>
                              <th>Booking</th>
                              <th>Armador</th>
                              <th>Produto</th>
                              <!-- th>Instrução</th -->
                              <th>Porto</th>
                              <!-- th>Navio</th -->
                              <th>Qtde</th>
                              <th>Cntr</th>
                              <th>DL Cliente</th>
                              <th>Programador</th>
                              <th style="background-color:#336600;color:#FFF">Ocorrência</th>
                              <th style="background-color:#336600;color:#FFF">Qtd</th>
                            </tr>
                          </thead>                          
                          <tbody style="font-size:10px;">
                            <?php foreach ($programacoes as $k => $programacao):?>                         
                              <tr data-id="<?=$programacao['idProgramacao']?>">                                
                                <td><?= $programacao["dcProgramacao"] == ""?"":date("d/m/Y" , strtotime($programacao["dcProgramacao"]))?></td>
                                <td><?= $programacao["dsProgramacao"] == ""?"":date("d/m/Y" , strtotime($programacao["dsProgramacao"]))?></td>
                                <td><?= $programacao["sgTerminal"]?></td>
                                <td><?= $programacao["nmGrupoCliente"]?></td>
                                <td><?= $programacao["bkProgramacao"]?></td>
                                <td><?= $programacao["sgArmador"]?></td>
                                <td><?= $programacao["nmProduto"]?></td>
                                <!-- td>< ? = $programacao["inProgramacao"] ? ></td -->
                                <td><?= $programacao["nmPorto"]?></td>
                                <!-- td>< ? = $programacao["nvProgramacao"] ? ></td -->
                                <td><?= $programacao["qtProgramacao"]?></td>
                                <td><?= $programacao["nmTipoContainer"]?></td>
                                <td><?= date("d/m/Y H:i", strtotime($programacao["dlcProgramacao"]))?></td>
                                <td><?= ucwords($programacao["nmFuncionario"])?></td>
                                <td style="background-color:#99FF99"><?= $programacao["oc"] == "" ? "":$programacao["oc"]?></td>
                                <td style="background-color:#99FF99"><?= $programacao["qt"]==0?"":$programacao["qt"]?></td>
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