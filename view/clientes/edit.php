 <?php
include "../../controller/cliente/cliente_controller.php";

$con = new Cliente_Controller();
$cliente = $con->getCliente($_GET["cliente"]);
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

                <?php if(count($cliente) > 0 ): ?>

                   <div class="row">                    
                      <div class="col-sm-12">
                        <h3 class="page-header"><i class="fa fa-edit"></i> Editar Cliente</h3>                
                        <ol class="breadcrumb">
                          <li><a href="../clientes/">Clientes</a></li>
                          <li class="active">Editar Cliente</li>
                        </ol>
                      </div>
                    </div>
                  
                <form class="form-horizontal" name="form" method="post" action="../../controller/cliente/cliente_controller.php">
                  <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                      <input type="hidden" name="acao" id="acao" value="edit" required/>
                      <input type="hidden" name="idcliente" value="<?=$cliente->getIdCliente()?>"required>                          
                     
                       <div class="col-sm-12 form-group">
                        <label class="col-sm-3 control-label" for="booking">Código:</label>  
                        <div class="col-sm-6">
                          <span><?=$cliente->getIdCliente()?></span>
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-3 control-label" for="booking">Cliente:</label>  
                        <div class="col-sm-6">
                          <input name="nmcliente" type="text" value="<?=$cliente->getNmCliente()?>" placeholder="Cliente" class="form-control" required>                          
                        </div>
                      </div>


                      <div class="col-sm-12 form-group">
                        <label class="col-sm-3 control-label" for="booking">Fluxo de Referência</label>  
                        <div class="col-sm-6">
                          <input name="fxcliente" type="text" value="<?=$cliente->getFxCliente()?>" placeholder="Fluxo" class="form-control" required>                          
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-3 control-label" for="terminal">Terminal:</label>
                        <div class="col-sm-6">
                          <select name="idterminal" class="form-control" required>
                              <option value="">Escolha uma opção</option>
                              <?php foreach ($terminais as $terminal) : ?>
                                  <option value="<?= $terminal->getIdTerminal() ?>" <?= $terminal->getIdTerminal() == $cliente->getTerminal()->getIdTerminal()?"selected='selected'":"" ?>><?= $terminal->getNmTerminal() ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-3 control-label" for="pecliente">Pedra:</label>
                        <div class="col-sm-4">
                          <div class="radio">
                            <label for="radios-0">
                              <input type="radio" name="pecliente" id="radios-0" value="1" <?= $cliente->getPeCliente()?"checked='checked'":""?> >
                              Ativa
                            </label>
                          </div>
                          <div class="radio">
                            <label for="radios-1">
                              <input type="radio" name="pecliente" id="radios-1" value="0" <?= !$cliente->getPeCliente()?"checked='checked'":""?>>
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