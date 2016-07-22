<?php
include "../../controller/programacao/programacao_controller.php";
$con = new Programacao_Controller();

$get_prog = "";

if(isset($_GET["prog"])){
  $get_prog = $_GET["prog"];
}else{
  header("Location: ../services/404.php");
}

$programacao = $con->getProgramacao($get_prog);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Programação - Nº <?= $programacao->getIdProgramacao()?></title>
    </head>

    <body>
        <div class="container">
          
          <div class="modal fade" tabindex="-1" role="dialog" id="modal_excluir">
            <div class="modal-dialog">              
              <form name="excluir" method="post" action="../../controller/programacao/programacao_controller.php">
                <div class="modal-content">
                  <div class="modal-header" style="color: #FFF;background-color: #d9534f;border-color: #ebccd1;border-top-left-radius: 3px;border-top-right-radius: 3px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <label class="modal-title">Excluir Registro?</label>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-12">                      
                        <p>Você está prestes a excluir este registro!</p>                    
                        <p>Informe o texto da imagem e clique em <kbd>Excluir</kbd> para confirmar a exclusão, ou clique em <kbd>Cancelar</kbd> para fechar esta mensagem.</p>
                      </div>
                      <div class="col-sm-12">
                        <div class="col-sm-12 well">
                          <?php include "captcha.php" ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <input type="hidden" name="acao" value="deletar"/>                    
                      <input type="hidden" name="programacao" value="<?=$programacao->getIdProgramacao()?>"/>                    
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-danger">Excluir</button>
                  </div>
                </div><!-- /.modal-content -->
              </form>
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

           <!-- nav bar -->
            <?php include "../layout/navbar.php"; ?>           

            <!-- menssagens -->
            <?php include "mensagens.php"; ?>

            <div class="row">
                <div class="col-sm-12 page-header">
                    <h2><span class="glyphicon glyphicon-shopping-cart"></span> Programação</h2>
                    <ol class="breadcrumb success">
                      <li><a href="lista.php">Lista de Programações</a></li>                      
                      <li class="active">Programação Nº. <?= $programacao->getIdProgramacao()?></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                  <div class="panel panel-default">
                    <div class="panel-heading"><h4>Programação Nº. <?= $programacao->getIdProgramacao()?></h4></div>
                    <div class="panel-body">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Data da Solicitação:</label>
                                  <span class="col-sm-8 col-xs-12"><?=date("d/m/Y" , strtotime($programacao->getDsProgramacao()))?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Terminal:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getTerminal()->getNmTerminal()?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Cliente:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getGrupoCliente()->getNmGrupoCliente()?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Booking:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getBkProgramacao()?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Armador:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getArmador()->getNmArmador()?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Produto:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getProduto()->getNmProduto()?></span>
                              </div>
                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Instrução:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getInProgramacao()?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Porto:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getPorto()->getNmPorto()?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Navio:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getNvProgramacao()?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Quantidade:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getQtProgramacao()?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Tipo Container:</label>
                                  <span class="col-sm-8 col-xs-12"><?=$programacao->getTipoContainer()->getNmTipoContainer()?></span>
                              </div>

                              <div class="col-sm-12" style="margin-top:5px;">
                                  <label class="col-sm-4 col-xs-12">Deadline Cliente:</label>
                                  <span class="col-sm-8 col-xs-12"><?=date("d/m/Y H:i", strtotime($programacao->getDlcProgramacao()))?></span>
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                          <div class="col-sm-12">
                            <a href="lista.php" role="button" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Lista</a>
                            <a href="editar.php?prog=<?=$get_prog?>" role="button" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Editar</a>
                            <a href="#modal_excluir" data-toggle="modal" role="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Excluir</a>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>               
            </div>

            <?php include "../layout/rodape.php"; ?>
        </div>
    </body>
</html>