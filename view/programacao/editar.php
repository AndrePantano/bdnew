<?php
include "../../controller/programacao/programacao_controller.php";

$get_prog = "";

if(isset($_GET["prog"])){
  $get_prog = $_GET["prog"];
}else{
  header("Location: ../services/404.php");
}

$con = new Programacao_Controller();

$programacao = $con->getProgramacao($get_prog);

$armadores = $con->getArmadores();
$terminais = $con->getTerminais();
$grupos_clientes = $con->getGrupoSClientes();
$tipos_containeres = $con->getTiposContaineres();
$portos = $con->getPortos();
$produtos = $con->getProdutos();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Programação - Editar</title>
    </head>

    <body>
        <div class="container">
            <!-- nav bar -->
            <?php include "../layout/navbar.php"; ?>           

            <!-- menssagens -->
            <?php include "mensagens.php"; ?>

            <div class="row">
                <div class="col-sm-12 page-header">
                    <h2><span class="glyphicon glyphicon-shopping-cart"></span> Programação</h2>
                    <ol class="breadcrumb success">
                      <li><a href="lista.php">Lista de Programações</a></li>                      
                      <li><a href="programacao.php?prog=<?=$programacao->getIdProgramacao()?>">Programação Nº. <?= $programacao->getIdProgramacao()?></a></li>
                      <li class="active">Editar</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                  <form class="form-vertical" name="form" method="post" action="../../controller/programacao/programacao_controller.php">
                    <input type="hidden" name="acao" value="editar"/>
                    <input type="hidden" name="programacao" value="<?=$programacao->getIdProgramacao()?>"/>

                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4><span class="glyphicon glyphicon-edit"></span> Editar</h4>
                      </div>
                      <div class="panel-body">
                          
                        <div class="col-sm-12 form-group">
                            <label class="col-sm-12 control-label" for="solicitacao">Data da Solicitação</label>  
                            <div class="col-sm-5">
                              <input id="solicitacao" name="solicitacao" type="date" class="form-control" value="<?=$programacao->getDsProgramacao()?>" required>
                            </div>
                        </div>
              
                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="terminal">Terminal</label>
                          <div class="col-sm-12">
                            <select id="terminal" name="terminal" class="form-control" required>                                      
                                <?php foreach ($terminais as $terminal) : ?>
                                    <option value="<?= $terminal->getIdTerminal() ?>" <?=$programacao->getTerminal()->getIdTerminal() == $terminal->getIdTerminal()? "selected='selected'":""?> ><?= $terminal->getNmTerminal() ?></option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                    
                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="cliente">Cliente</label>
                          <div class="col-sm-12">
                            <select id="cliente" name="cliente" class="form-control" required>
                                <?php foreach ($grupos_clientes as $grupo_cliente) : ?>
                                    <option value="<?= $grupo_cliente->getIdGrupoCliente() ?>" <?=$programacao->getGrupoCliente()->getIdGrupoCliente() == $grupo_cliente->getIdGrupoCliente()? "selected='selected'":""?> ><?= $grupo_cliente->getNmGrupoCliente() ?></option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                    
                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="booking">Booking</label>  
                          <div class="col-sm-12">
                            <input id="booking" name="booking" type="text" placeholder="Booking" class="form-control" value="<?=$programacao->getBkProgramacao()?>" required>                          
                          </div>
                        </div>
                                    
                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="armador">Armador</label>
                          <div class="col-sm-12">
                            <select id="armador" name="armador" class="form-control" required>                                      
                                <?php foreach ($armadores as $armador) : ?>
                                    <option value="<?= $armador->getIdArmador() ?>" <?=$programacao->getArmador()->getIdArmador() == $armador->getIdArmador()? "selected='selected'":""?> ><?= $armador->getNmArmador() ?></option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                    
                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="produto">Produto</label>  
                          <div class="col-sm-12">
                            <select id="produto" name="produto" class="form-control" required>                                                              
                              <?php foreach ($produtos as $produto) : ?>
                                  <option value="<?= $produto->getIdProduto() ?>" <?=$programacao->getProduto()->getIdProduto() == $produto->getIdProduto()? "selected='selected'":""?> ><?= $produto->getNmProduto() ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                    
                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="instrucao">Instrução</label>  
                          <div class="col-sm-12">
                            <input id="instrucao" name="instrucao" type="text" placeholder="Instrução" value="<?=$programacao->getInProgramacao()?>" class="form-control">                          
                          </div>
                        </div>
                    
                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="porto">Porto</label>  
                          <div class="col-sm-12">
                            <select id="porto" name="porto" class="form-control" required>                                    
                                <?php foreach ($portos as $porto) : ?>
                                    <option value="<?= $porto->getIdPorto() ?>" <?=$programacao->getPorto()->getIdPorto() == $porto->getIdPorto()? "selected='selected'":""?> ><?= $porto->getNmPorto() ?></option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      
                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="navio">Navio</label>
                          <div class="col-sm-12">
                            <input type="text" id="navio" name="navio" placeholder="Navio" class="form-control" value="<?=$programacao->getNvProgramacao()?>" required>                                    
                          </div>
                        </div>

                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="quantidade">Quantidade</label>  
                          <div class="col-sm-12">
                            <input id="quantidade" name="quantidade" type="number" placeholder="0" min="1" class="form-control" value="<?=$programacao->getQtProgramacao()?>" required/>                          
                          </div>
                        </div>
                     
                        <div class="col-sm-6 form-group">
                          <label class="col-sm-12 control-label" for="tipo_container">Tipo Container</label>  
                          <div class="col-sm-12">
                            <select id="tipo_container" name="tipo_container" class="form-control" required>                                    
                                <?php foreach ($tipos_containeres as $tipo_container) : ?>
                                    <option value="<?= $tipo_container->getIdTipoContainer() ?>" <?=$programacao->getTipoContainer()->getIdTipoContainer() == $tipo_container->getIdTipoContainer()? "selected='selected'":""?> ><?= $tipo_container->getNmTipoContainer() ?></option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                     
                        <div class="col-sm-12 form-group">
                            <label class="col-sm-12 control-label" for="deadline_cliente_data">Deadline Cliente</label>  
                            <div class="col-sm-5">
                                <small class="text-muted"><i>Data</i></small>
                                <input id="deadline_cliente_data" name="deadline_cliente_data" type="date" class="form-control" value="<?=date("Y-m-d",strtotime($programacao->getDlcProgramacao()))?>" required>
                            </div>
                            <div class="col-sm-3">
                                <small class="text-muted"><i>Hora</i></small>
                                <input id="deadline_cliente_hora" name="deadline_cliente_hora" type="time" class="form-control" value="<?=date("H:i",strtotime($programacao->getDlcProgramacao()))?>" required>                          
                            </div>  
                        </div>

                        <?php include "captcha.php";?>

                      </div>
                      <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-12">
                              <a href="programacao.php?prog=<?=$programacao->getIdProgramacao()?>" role="button" class="btn btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
                              <button type="submit" id="btn_enviar" name="btn_enviar" class="btn btn-primary"><span class="glyphicon glyphicon-record"></span> Gravar</button>
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