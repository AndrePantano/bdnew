 <?php
include "../../controller/terminal/terminal_controller.php";

$con = new Terminal_Controller();
$terminal = $con->getTerminal($_GET["terminal"]);
$corredores = $con->getCorredores();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Terminal</title>
        <script type="text/javascript" src="js/script.js"></script>
    </head>

    <body>
        <div class="container">        

            <?php include "../layout/navbar.php"; ?>
            
            <?php include "../services/mensagens.php"; ?>

            <div class="row">

              <?php include "../layout/sidebar_config.php"; ?>

              <div class="col-sm-6">

                <?php if(count($terminal) > 0 ): ?>

                   <div class="row">                    
                      <div class="col-sm-12">
                        <h3 class="page-header"><i class="fa fa-edit"></i> Editar Terminal</h3>                
                        <ol class="breadcrumb">
                          <li><a href="../terminais/">Terminais</a></li>
                          <li class="active">Editar Terminal</li>
                        </ol>
                      </div>
                    </div>
                  
                <form class="form-vertical" name="form" method="post" action="../../controller/terminal/terminal_controller.php">
                  <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                      <input type="hidden" name="acao" id="acao" value="edit" required/>
                      <input type="hidden" name="idterminal" value="<?=$terminal->getIdTerminal()?>"required>                          
                      
                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Terminal:</label>  
                        <div class="col-sm-12">
                          <input name="nmterminal" type="text" value="<?=$terminal->getNmTerminal()?>" placeholder="Terminal" class="form-control" required>                          
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Sigla:</label>  
                        <div class="col-sm-12">
                          <input name="sgterminal" type="text" value="<?=$terminal->getSgTerminal()?>" placeholder="Sigla Terminal" class="form-control" required>                     
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="terminal">Corredor:</label>
                        <div class="col-sm-12">
                          <select name="idcorredor" class="form-control" required>
                               <option value="">Escolha uma op&ccedil;&atilde;o</option>
                              <?php foreach ($corredores as $corredor) : ?>
                                  <option value="<?= $corredor->getIdCorredor() ?>" <?= $corredor->getIdCorredor() == $terminal->getCorredor()->getIdCorredor()?"selected='selected'":"" ?>><?= $corredor->getNmCorredor() ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                    </div>
                    <div class="panel-footer">
                       <div class="row">
                          <div class="col-sm-12">
                            <a href="../terminais/" role="button" class="btn btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
                            <button type="submit" id="btn-edit" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                            <button type="submit" id="btn-delete" class="btn btn-default pull-right"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                          </div>
                        </div>
                    </div>
                  </div>
                </form>

                <?php endif; ?>
              </div>
            </div>

            <?php include "../layout/rodape.php"; ?>
        </div>
    </body>
</html>