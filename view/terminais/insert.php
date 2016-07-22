 <?php
include "../../controller/terminal/terminal_controller.php";

$con = new Terminal_Controller();
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

                <div class="row">                    
                  <div class="col-sm-12">
                    <h3 class="page-header"><i class="fa fa-upload"></i> Adicionar Terminal</h3>                
                    <ol class="breadcrumb">
                      <li><a href="../terminais/">Terminais</a></li>
                      <li class="active">Adicionar Terminal</li>
                    </ol>
                  </div>
                </div>       
                  
                <form class="form-vertical" name="form" method="post" action="../../controller/terminal/terminal_controller.php">
                  <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                      <input type="hidden" name="acao" id="acao" value="insert" required/>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Terminal:</label>  
                        <div class="col-sm-12">
                          <input name="nmterminal" type="text" value="" placeholder="Terminal" class="form-control" required>                          
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Sigla:</label>  
                        <div class="col-sm-12">
                          <input name="sgterminal" type="text" value="" placeholder="Sigla Terminal" class="form-control" required>                     
                        </div>
                      </div>

                    <?php if($con->getIdFuncaoFuncionarioSessao() == 1): ?>
                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="idcorredor">Corredor:</label>
                        <div class="col-sm-12">
                          <select name="idcorredor" class="form-control" required>
                              <option value="">Escolha uma op&ccedil;&atilde;o</option>
                              <?php foreach ($corredores as $corredor) : ?>                                  
                                  <option value="<?= $corredor->getIdCorredor() ?>"><?= $corredor->getNmCorredor() ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    <?php else: ?>
                      <input type="hidden" name="idcorredor" value="<?=$con->getIdCorredorFuncionarioSessao()?>"/>
                    <?php endif;?>                      
                                    
                    </div>
                    <div class="panel-footer">
                       <div class="row">
                          <div class="col-sm-12">
                            <a href="../terminais/" role="button" class="btn btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
                            <button type="submit" id="btn-insert" class="btn btn-default"><span class="glyphicon glyphicon-upload"></span> Adicionar</button>                            
                          </div>
                        </div>
                    </div>
                  </div>
                </form>
                
              </div>
            </div>

            <?php include "../layout/rodape.php"; ?>
        </div>
    </body>
</html>