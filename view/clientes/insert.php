 <?php
include "../../controller/cliente/cliente_controller.php";

$con = new Cliente_Controller();
$terminais = $con->getTerminais();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Cliente</title>
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
                    <h3 class="page-header"><i class="fa fa-upload"></i> Adicionar Cliente</h3>                
                    <ol class="breadcrumb">
                      <li><a href="../clientes/">Clientes</a></li>
                      <li class="active">Adicionar Cliente</li>
                    </ol>
                  </div>
                </div>       
                  
                <form class="form-vertical" name="form" method="post" action="../../controller/cliente/cliente_controller.php">
                  <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                      <input type="hidden" name="acao" id="acao" value="insert" required/>                                            
                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Cliente</label>  
                        <div class="col-sm-12">
                          <input name="nmcliente" type="text" value="" placeholder="Cliente" class="form-control" required>                          
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Fluxo de Referência</label>  
                        <div class="col-sm-12">
                          <input name="fxcliente" type="text" value="" placeholder="Fluxo" class="form-control" required>                          
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="terminal">Terminal</label>
                        <div class="col-sm-12">
                          <select name="idterminal" class="form-control" required>
                              <option value="">Escolha uma opção</option>
                              <?php if($con->getIdFuncaoFuncionarioSessao() == 1):?>
                                <?php foreach ($terminais as $terminal) : ?> 
                                    <option value="<?= $terminal->getIdTerminal() ?>"><?= $terminal->getNmTerminal()." - ". $terminal->getSgTerminal()." - ".$terminal->getCorredor()->getNmCorredor() ?></option>
                                <?php endforeach; ?>
                              <?php else: ?>
                                <?php foreach ($terminais as $terminal) : ?> 
                                    <option value="<?= $terminal->getIdTerminal() ?>"><?= $terminal->getNmTerminal() ?></option>
                                <?php endforeach; ?>
                              <?php endif; ?>
                          </select>
                        </div>
                      </div>
                      
                      <div class="col-sm-12 form-group">
                        <label class="col-sm-2 control-label" for="pecliente">Pedra:</label>
                        <div class="col-sm-4">
                          <div class="radio">
                            <label for="radios-0">
                              <input type="radio" name="pecliente" id="radios-0" value="1" checked="checked">
                              Ativa
                            </label>
                          </div>
                          <div class="radio">
                            <label for="radios-1">
                              <input type="radio" name="pecliente" id="radios-1" value="0">
                              Inativa
                            </label>
                          </div>
                        </div>
                      </div> 

                      <!-- ?php include "../services/captcha.php";? -->
                                    
                    </div>
                    <div class="panel-footer">
                       <div class="row">
                          <div class="col-sm-12">
                            <a href="../clientes/" role="button" class="btn btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
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