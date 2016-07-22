 <?php
include "../../controller/funcionario/funcionario_controller.php";

$con = new Funcionario_Controller();
$funcionario = $con->getFuncionario($_GET["funcionario"]);

if(isset($_GET["sp"]) && $_GET["sp"] == 1)
  $con->AtribuirSenhaPadrao($_GET["funcionario"]);

$corredores = $con->getCorredores();
$funcoes = $con->getFuncoes();
$estatus = $con->getEstatus();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Funcionário</title>
        <script type="text/javascript" src="js/script.js"></script>
    </head>

    <body>
        <div class="container">        

            <?php include "../layout/navbar.php"; ?>
            
            <?php include "../services/mensagens.php"; ?>

            <div class="row">

              <?php include "../layout/sidebar_config.php"; ?>

              <div class="col-sm-6">

                <?php if(count($funcionario) > 0 ): ?>

                   <div class="row">                    
                      <div class="col-sm-12">
                        <h3 class="page-header"><i class="fa fa-edit"></i> Editar Funcionário</h3>                
                        <ol class="breadcrumb">
                          <li><a href="../funcionarios/">Funcionários</a></li>
                          <li class="active">Editar Funcionário</li>
                        </ol>
                      </div>
                    </div>
                  
                 <form class="form-vertical" name="form" method="post" action="../../controller/funcionario/funcionario_controller.php">
                  <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                      <input type="hidden" name="acao" id="acao" value="edit" required/>
                      <input type="hidden" name="idfuncionario" value="<?=$funcionario->getIdFuncionario()?>" required/>
                                            
                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Funcionario</label>  
                        <div class="col-sm-12">
                          <input name="nmfuncionario" type="text" value="<?=$funcionario->getNmFuncionario()?>" placeholder="Funcionario" class="form-control" required>                          
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="booking">Email</label>  
                        <div class="col-sm-12">
                          <input name="emfuncionario" type="email" value="<?=$funcionario->getEmFuncionario()?>" placeholder="Email" class="form-control" required>                          
                        </div>
                      </div>

                      <div class="col-sm-12 form-group">
                        <label class="col-sm-12 control-label" for="terminal">Funcão</label>
                        <div class="col-sm-12">
                          <select name="idfuncao" class="form-control" required>
                              <option value="">Escolha uma opção</option>
                              <?php foreach ($funcoes as $funcao) : ?>                                  
                                  <option value="<?= $funcao->getIdFuncao() ?>" <?= $funcao->getIdFuncao() == $funcionario->getFuncao()->getIdFuncao()?"selected='selected'":""?>><?= $funcao->getNmFuncao() ?></option>
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
                                  <option value="<?= $corredor->getIdCorredor() ?>" <?= $corredor->getIdCorredor() == $funcionario->getCorredor()->getIdCorredor()?"selected='selected'":""?>><?= $corredor->getNmCorredor() ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      
                      <div class="col-sm-12 form-group">
                        <label class="col-sm-2 control-label" for="idestatus">Estatus:</label>
                        <div class="col-sm-4">
                          <div class="radio">
                            <label for="radios-0">
                              <input type="radio" name="idestatus" id="radios-0" value="1" <?= $funcionario->getEstatus()->getIdEstatus() == 1 ?"checked='checked'":""?>>
                              Ativo
                            </label>
                          </div>
                          <div class="radio">
                            <label for="radios-1">
                              <input type="radio" name="idestatus" id="radios-1" value="2" <?= $funcionario->getEstatus()->getIdEstatus() == 2?"checked='checked'":""?>>
                              Inativo
                            </label>
                          </div>
                        </div>
                      </div>                       
                                    
                    </div>
                    <div class="panel-footer">
                       <div class="row">
                          <div class="col-sm-12">
                            <a href="../funcionarios/" role="button" class="btn btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
                            <button type="submit" id="btn-edit" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                            <button type="submit" id="btn-senha" class="btn btn-default"><i class="fa fa-key"></i> Senha Padrão (brado)</button>                                                        
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