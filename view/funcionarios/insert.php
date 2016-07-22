 <?php
include "../../controller/funcionario/funcionario_controller.php";

$con = new Funcionario_Controller();
$corredores = $con->getCorredores();
$funcoes = $con->getFuncoes();
$estatus = $con->getEstatus();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Funcionario</title>
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
                    <h3 class="page-header"><i class="fa fa-upload"></i> Adicionar Funcionario</h3>                
                    <ol class="breadcrumb">
                      <li><a href="../funcionarios/">Funcionarios</a></li>
                      <li class="active">Adicionar Funcionario</li>
                    </ol>
                  </div>
                </div>       
                  
                <form class="form-vertical" name="form" method="post" action="../../controller/funcionario/funcionario_controller.php">
                  <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                      
                      <input type="hidden" name="acao" id="acao" value="insert" required/>
                      <input type="hidden" name="idestatus" value="1" required/>
                      
                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Funcionario</label>  
                        <div class="col-sm-12">
                          <input name="nmfuncionario" type="text" value="" placeholder="Funcionario" class="form-control" required>                          
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Email</label>  
                        <div class="col-sm-12">
                          <input name="emfuncionario" type="email" value="" placeholder="Email" class="form-control" required>                          
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="terminal">Funcão</label>
                        <div class="col-sm-12">
                          <select name="idfuncao" class="form-control" required>
                              <option value="">Escolha uma opção</option>
                              <?php foreach ($funcoes as $funcao) : ?>                                  
                                  <option value="<?= $funcao->getIdFuncao() ?>"><?= $funcao->getNmFuncao() ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="terminal">Corredor</label>
                        <div class="col-sm-12">
                          <select name="idcorredor" class="form-control" required>
                              <option value="">Escolha uma opção</option>
                              <?php foreach ($corredores as $corredor) : ?>                                  
                                  <option value="<?= $corredor->getIdCorredor() ?>"><?= $corredor->getNmCorredor() ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                                                          
                    </div>
                    <div class="panel-footer">
                       <div class="row">
                          <div class="col-sm-12">
                            <a href="select.php" role="button" class="btn btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
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