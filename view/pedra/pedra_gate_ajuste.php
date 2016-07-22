<?php
include "../../controller/pedra/pedra_gate_ajustes_controller.php";
$con = new Pedra_Gate_Ajustes_Controller();

$dados = array();

// ATRIBUI AS CHAVE E O VALOR
$chave = "";
$valor = "";

// ATRIBUI A CHAVE E VALOR PARA CLIENTE
if (isset($_GET["cl"]) && $_GET["cl"] !=""){
  $chave = "idCliente";
  $valor = $_GET["cl"];
}else{
  
  // ATRIBUI A CHAVE E VALOR PARA TERMINAL
  if (isset($_GET["te"]) && $_GET["te"] !=""){
    $chave = "idTerminal";
    $valor = $_GET["te"];
  }else{
    
    // ATRIBUI A CHAVE E VALOR PARA CORREDOR
    if (isset($_GET["co"]) && $_GET["co"] !=""){
      $chave = "idCorredor";
      $valor = $_GET["co"];
    }
  }
}

// ATRIBUI AS DATAS PARA AS VARIÁVEIS
$inicio = "";
$fim = "";

if(isset($_GET["di"]) && isset($_GET["df"])){
  $inicio = $_GET["di"];
  $fim = $_GET["df"];
}

// VERIFICA A EXISTENCIA DE PÁGINA
$pagina = 1;

if(isset($_GET["pg"]))
  $pagina = $_GET["pg"];


if($chave != "" && $valor != "" && $inicio != "" && $fim != ""){
  $dados = $con->getRelatorioAjustes($chave,$valor,$inicio,$fim,$pagina);
}

$corredores = $con->getCorredores();

$terminais = array();
if(isset($_GET['co']) && $_GET['co'] != "")
$terminais = $con->getTerminais($_GET['co']);


$clientes = array();
if(isset($_GET['te']) && $_GET['te'] != "")
$clientes = $con->getClientes($_GET['te']);

$motivos = $con->getPedraMotivos();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Pedra Gate - Ajustes</title>
        <style type="text/css">
          
          .titulo_coluna_valor{
            text-align: center;       
          }        
          .titulo_coluna_motivo{
             width: 150px;
          }
          .titulo_coluna_data{
            width:50px;
          }          
          .titulo_coluna_valor{
            width:35px;
          } 
          .celula_valor{
            text-align: right;            
          }
        </style>

        <script type="text/javascript" src="js/script.js"></script>       
    </head>

    <body>
      <div class="container"> 
        
        <?php if($con->getIdFuncaoFuncionarioSessao() == 1): ?>

          <?php foreach ($dados as $dado): ?>

            <div class="modal fade" id="update<?=$dado['idPedra']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">

                  <form action="../../controller/pedra/pedra_gate_ajustes_controller.php" method="post" class="form-horizontal">               

                    <input type="hidden" name="acao"      value="edit" class="acao<?=$dado['idPedra']?>" />
                    <input type="hidden" name="corredor"  value="<?=$dado['idCorredor']?>"/>
                    <input type="hidden" name="terminal"  value="<?=$dado['idTerminal']?>"/>
                    <input type="hidden" name="cliente"   value="<?=$dado['idCliente']?>"/>
                    <input type="hidden" name="pedra"     value="<?=$dado['idPedra']?>"/>                                        
                    <input type="hidden" name="pagina"    value="<?= isset($_POST["pg"])?$_POST["pg"]:'1'?>" />
                    <input type="hidden" name="inicio"    value="<?= isset($_GET['di'])?$_GET['di']:date('Y-m-').'01'?>" />
                    <input type="hidden" name="fim"       value="<?=date('Y-m-d')?>"/>

                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Ajustar Pedra</h4>
                    </div>

                    <div class="modal-body">
                      <div class="row">
                          <div class="col-sm-12">
                      
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="previa">Cliente:</label>                              
                                <span class="col-md-4 "><?= $dado['nmCliente']?></span>
                              </div>

                              <div class="form-group">
                                <label class="col-md-4 control-label" for="previa">Data da Pedra:</label>                              
                                <span class="col-md-4 "><?=date("d/m/Y", strtotime($dado['dtPedra']))?></span>
                              </div>

                              <div class="form-group">
                                <label class="col-md-4 control-label" for="previa">Pr&eacute;via:</label>
                                <div class="col-md-3">
                                  <input id="previa" name="previa" type="number" placeholder="0" class="form-control input-md pvpedra pv-pedra<?=$dado['idPedra']?>"  data-id="<?=$dado['idPedra']?>" value="<?=$dado['pvPedra']?>" required>
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-md-4 control-label" for="real">Real:</label>
                                <div class="col-md-3">
                                  <input id="real" name="real" type="number" placeholder="0" class="form-control input-md repedra re-pedra<?=$dado['idPedra']?>" data-id="<?=$dado['idPedra']?>" required value="<?=$dado['rePedra']?>">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-md-4 control-label" for="real">Delta: (&Delta;)</label>
                                <div class="col-md-3">
                                  <span class="delta<?=$dado['idPedra']?>"> <?= $dado['rePedra'] - $dado['pvPedra'] ?> </span>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="previa">Atualizador por:</label>
                                <span class="col-md-8"><?=$dado['nmFuncionario']?></span>            
                              </div>

                              <div class="form-group">
                                <label class="col-md-4 control-label" for="motivo">Respons&aacute;vel Perda:</label>
                                <div class="col-md-4">
                                  <select id="motivo" name="motivo" class="form-control idpedramotivo<?=$dado['idPedra']?>">
                                    <option value="">Selecione um item</option>
                                    <?php foreach ($motivos as $motivo):?>
                                      <option value="<?= $motivo['idPedraMotivo']?>" <?= $motivo['idPedraMotivo'] == $dado['idPedraMotivo']? "selected='selected'":""?> ><?=$motivo['nmPedraMotivo']?></option>  
                                    <?php endforeach;?>                     
                                  </select>
                                </div>
                              </div>

                          
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="obsevacao">Descri&ccedil;&atilde;o da Perda:</label>
                                <div class="col-md-8">                     
                                  <textarea class="form-control obpedra<?=$dado['idPedra']?>" id="obsevacao" name="observacao"><?=$dado['obPedra']?></textarea>
                                </div>
                              </div>

                          </div>
                          <div class="col-sm-12">
                            <p class="text-muted">Obs. Para os casos onde o &Delta; (delta) for negativo, &eacute; obrigat&oacute;rio o preenchimento do respons&aacute;vel e a descri&ccedil;&atilde;o da perda.</p>
                          </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                        <div class="row">
                          <div class="col-sm-12">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
                            <button type="submit" class="btn btn-primary btn-edit pull-left" data-id="<?=$dado['idPedra']?>" >               <span class="glyphicon glyphicon-edit"></span> Salvar Altera&ccedil;&otilde;es</button>
                            <button type="submit" class="btn btn-default pull-right btn-delete" data-id="<?=$dado['idPedra']?>" >  <span class="glyphicon glyphicon-trash"></span> Excluir Pedra</button>
                          </div>
                        </div>
                    </div>

                  </form>

                </div>
              </div>
            </div>

          <?php endforeach; ?>

          <!-- MODAL PARA INSERIR NOVA PEDRA -->                
          <div class="modal fade" id="insert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-md" role="document">
                  <div class="modal-content">

                    <form action="../../controller/pedra/pedra_gate_ajustes_controller.php" method="post" class="form-horizontal">               

                      <input type="hidden" name="acao" value="insert" />
                      <input type="hidden" name="corredor"  value="<?= isset($_GET["co"])?$_GET["co"]:''?>"/>
                      <input type="hidden" name="terminal"  value="<?= isset($_GET["te"])?$_GET["te"]:''?>"/>
                      <input type="hidden" name="cliente"   value="<?= isset($_GET["cl"])?$_GET["cl"]:''?>"/>
                      <input type="hidden" name="pagina"    value="<?= isset($_GET["pg"])?$_GET["pg"]:''?>" />
                      <input type="hidden" name="inicio"    value="<?= isset($_GET['di'])?$_GET['di']:''?>" />
                      <input type="hidden" name="fim"       value="<?= isset($_GET['df'])?$_GET['df']:''?>" />

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Adicionar Pedra</h4>
                      </div>

                      <div class="modal-body">
                        <div class="row">
                                               
                            <div class="col-sm-12">

                              <div class="form-group">
                                <label for="corredor" class="control-label col-sm-3">Corredor:</label>
                                 <div class="col-sm-6">
                                   <select name="corredor" class="form-control input-sm corredor" data-id="i">
                                    <option value="">Selecione uma op&ccedil;&atilde;o</option>                                                 
                                    <?php foreach ($corredores as $corredor):?>
                                      <option value="<?= $corredor['idCorredor']?>"><?=mb_strtoupper($corredor['nmCorredor'],'UTF-8')?></option>  
                                    <?php endforeach;?>                                      
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="terminal" class="control-label col-sm-3">Terminal:</label>
                                <div class="col-sm-6">
                                  <select name="terminal" id="terminali" class="form-control input-sm terminal" data-id="i">
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="" class="control-label col-sm-3">Cliente:</label>
                                <div class="col-sm-6">
                                  <select name="cliente" id="clientei" class="form-control input-sm">                                  
                                  </select>
                                </div>
                              </div>
                                  
                              <div class="form-group">
                                <label for="data" class="control-label col-sm-3">Data:</label> 
                                <div class="col-sm-4">                               
                                  <input type="date" name="data" class="form-control input-sm" required />
                                </div>                                 
                              </div>
                                
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="previa">Pr&eacute;via:</label>
                                <div class="col-sm-4">
                                  <input id="previa" name="previa" type="number" placeholder="0" class="form-control input-md pvpedra pv-pedra0"  data-id="0" required value="0">
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="real">Real:</label>
                                <div class="col-sm-4">
                                  <input id="real" name="real" type="number" placeholder="0" class="form-control input-md repedra re-pedra0" data-id="0" required value="0">
                                </div>
                              </div>
                         
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="real">Delta: (&Delta;)</label>
                                <div class="col-sm-8">
                                  <span class="delta0"> 0 </span>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="motivo">Respons&aacute;vel Perda:</label>
                                <div class="col-sm-6">
                                  <select id="motivo" name="motivo" class="form-control idpedramotivo0">
                                    <option value="">Selecione um item</option>
                                    <?php foreach ($motivos as $motivo):?>
                                      <option value="<?= $motivo['idPedraMotivo']?>"><?=$motivo['nmPedraMotivo']?></option>  
                                    <?php endforeach;?>                     
                                  </select>
                                </div>
                              </div>
                          
                              <div class="form-group">
                                <label class="control-label col-sm-3" for="obsevacao">Descri&ccedil;&atilde;o da Perda:</label>
                                <div class="col-sm-9">                     
                                  <textarea class="form-control obpedra0" name="observacao" placeholder="..."></textarea>
                                </div>
                              </div>

                            </div>

                            <div class="col-sm-12">
                              <p class="text-muted">Obs. Para os casos onde o &Delta; (delta) for negativo, &eacute; obrigat&oacute;rio o preenchimento do respons&aacute;vel e a descri&ccedil;&atilde;o da perda.</p>
                            </div>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                      </div>

                    </form>

                  </div>
                </div>
          </div>
        <?php endif; ?>

        <?php include "../layout/navbar.php"; ?>
          
        <?php include "../services/mensagens.php"; ?>

        <div class="row">
          <div class="col-sm-12">              
            <h3 class="page-header"><i class="fa fa-diamond"></i> Pedra Gate - Ajustes</h3>
          </div>
        </div>

        <div class="row">

          <!-- FILTROS DE PESQUISA -->
          <div class="col-sm-2">
            <h4>Filtros</h4>            
            <form class="form-vertical" role="search" action="../../controller/pedra/pedra_gate_ajustes_controller.php" method="post">
              <input type="hidden" name="ajustes" />
              <input type="hidden" name="pg" value="<?= isset($_POST["pg"])?$_POST["pg"]:'1'?>" />
              <div class="form-group">
                <label for="">Corredor:</label>
                 <select name="co" data-id="p" class="form-control input-sm corredor corredorp ">
                  <option value="">Todos</option>                                                     
                  <?php foreach ($corredores as $corredor):?>
                    <option value="<?= $corredor['idCorredor']?>" <?=isset($_GET['co']) && $_GET['co']==$corredor['idCorredor']?"selected='selected'":""?>><?=mb_strtoupper($corredor['nmCorredor'],'UTF-8')?></option>  
                  <?php endforeach;?>                                      
                </select>
              </div>
              <div class="form-group">
                <label for="">Terminal:</label>
                 <select name="te" id="terminalp" class="form-control input-sm terminal" data-id="p">

                  <?php if(isset($_GET['co']) && $_GET['co'] != ""):?>
                    <option value="">Todos</option>
                  <?php endif; ?>

                  <?php foreach ($terminais as $terminal):?>
                    <option value="<?= $terminal['idTerminal']?>" <?=isset($_GET['te']) && $_GET['te']==$terminal['idTerminal']?"selected='selected'":""?> ><?=mb_strtoupper($terminal['nmTerminal'],'UTF-8')?></option>  
                    <?php endforeach;?> 
                </select>
              </div>
              <div class="form-group">
                <label for="">Cliente:</label>
                <select name="cl" id="clientep" class="form-control input-sm">                                                        
                  <?php foreach ($clientes as $cliente):?>
                    <option value="<?= $cliente['idCliente']?>" <?=isset($_GET['cl']) && $_GET['cl']==$cliente['idCliente']?"selected='selected'":""?> ><?=mb_strtoupper($cliente['nmCliente'],'UTF-8')?></option>  
                    <?php endforeach;?> 
                </select>
              </div>
              <label for="">Per&iacute;odo:</label>
              <div class="form-group">
                <span>De:</span>
                 <input type="date" name="di" class="form-control input-sm" value="<?= isset($_GET['di'])?$_GET['di']:date('Y-m-').'01'?>" />
              </div>
              <div class="form-group">
                <span>At&eacute;</span>
                 <input type="date" name="df" class="form-control input-sm" value="<?= isset($_GET['df'])?$_GET['df']:date('Y-m-d')?>"/>
              </div>
              <button type="submit" class="btn btn-default">OK</button>
            </form>            
          </div>
          
          <!-- CABECALHO DO CORPO DA PÁGINA -->
          <?php if($con->getIdFuncaoFuncionarioSessao() == 1 ):?>          
          <div class="col-sm-10">
            <button class="btn btn-primary pull-right abre-modal" data-tipo="insert" data-id="0"><i class="fa fa-plus"></i> Adicionar Pedra</button>
            <label class="h4">&nbsp;</label>
          </div>
          <?php endif; ?>

          <!-- CORPO DA PÁGINA -->
          <div class="col-sm-10">
            <?php if(isset($_GET["co"]) && isset($_GET["te"]) && isset($_GET["cl"]) && isset($_GET["di"]) && isset($_GET["df"])){
              
              if(count($dados) > 0){ ?>
             
                <div class="panel panel-default">
                  <div class="panel-heading">

                    <div class="form-group">                   
                      <label>Total de Pedras Encontradas:  <span class="badge"><?=$con->getTotalRegistrosEncontrados()?></span></label>

                      <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" title="Exportar Relat&oacute;rio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-download"></i> Exportar <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="exportar_pedra_gate_ajustes.php?co=<?=$_GET['co']?>&te=<?=$_GET['te']?>&cl=<?=$_GET['cl']?>&di=<?=$_GET['di']?>&df=<?=$_GET['df']?>" target="_blank"><i class="fa fa-file-excel-o"></i> Para CSV</a></li>                            
                        </ul>
                      </div>
                    
                    </div>

                  </div>
                  <div class="panel-body">

                    <div class="table-responsive">
                      
                      <?php if($con->getIdFuncaoFuncionarioSessao() == 1): ?>
                        <p class="text-muted"><i>Para realizar a atualiza&ccedil;&atilde;o, basta clicar na linha do cliente.</i></p>
                      <?php endif; ?>

                      <table class="table table-condensed table-hover table-striped">
                        <thead>
                          <tr>                            
                            <th class="titulo_coluna_motivo">Cliente</th>
                            <th class="titulo_coluna_data">Terminal</th>
                            <th class="titulo_coluna_data">Data</th>
                            <th class="titulo_coluna_valor">Pr&eacute;via</th>
                            <th class="titulo_coluna_valor">Real</th>
                            <th class="titulo_coluna_motivo">Atualizado por</th>
                            <th class="titulo_coluna_motivo">Motivo</th>
                            <th>Observa&ccedil;&atilde;o</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dados as $dado): ?>                             
                                                                        
                                <tr class="abre-modal" data-id="<?=$dado['idPedra']?>" data-tipo="update">                                        
                                  <td><span class="text-muted"><?=$dado['nmCliente']?></span></td>
                                  <td><span class="text-muted"><?=$dado['sgTerminal']?></span></td>
                                  <td><span class="text-muted"><?=date("d/m/Y",strtotime($dado['dtPedra']))?></span></td>
                                  <td class="celula_valor"><?=$dado['pvPedra']?></td>
                                  <td class="celula_valor"><?=$dado['rePedra']?></td>
                                  <td><span class="text-muted"><?=$dado['nmFuncionario']?></span></td>
                                  <td><?=$dado['nmPedraMotivo']?></td>
                                  <td><?=$dado['obPedra']?></td>
                                </tr>
                            
                            <?php endforeach;?>
                        </tbody>                  

                      </table>

                    </div>
                  </div>
                  <div class="panel-footer">
                     
                        <nav>
                          <ul class="pagination">
                            
                            <!-- ANTERIOR DA PAGINAÇÃO -->
                            <?php if( ($_GET['pg'] - 1) == 0){ ?>
                              <li class="disabled"><span aria-hidden="true">&laquo;</span></li>
                            <?php }else{ ?>
                              <li>
                                <a href="?co=<?=$_GET['co']?>&te=<?=$_GET['te']?>&cl=<?=$_GET['cl']?>&di=<?=$_GET['di']?>&df=<?=$_GET['df']?>&pg=<?= ($_GET['pg'] - 1) ?>" aria-label="Previous">
                                  <span aria-hidden="true">&laquo;</span>
                                </a>
                              </li>
                            <?php } ?>

                            <!-- PÁGINAS DA PAGINAÇÃO -->
                            <?php for($i = 1; $i < $con->getTotalPaginas() + 1; $i++){?>
                              <li class="<?= $i==$_GET['pg']?'active':''?>"><a href="?co=<?=$_GET['co']?>&te=<?=$_GET['te']?>&cl=<?=$_GET['cl']?>&di=<?=$_GET['di']?>&df=<?=$_GET['df']?>&pg=<?= $i?>"><?= $i?></a></li>                          
                            <?php } ?>

                             <!-- PROXIMO DA PAGINAÇÃO -->
                            <?php if( $_GET['pg']  == $con->getTotalPaginas()){ ?>
                              <li class="disabled"><span aria-hidden="true">&raquo;</span></li>
                            <?php }else{ ?>
                              <li>
                                <a href="?co=<?=$_GET['co']?>&te=<?=$_GET['te']?>&cl=<?=$_GET['cl']?>&di=<?=$_GET['di']?>&df=<?=$_GET['df']?>&pg=<?= ($_GET['pg'] + 1) ?>" aria-label="Previous">
                                  <span aria-hidden="true">&raquo;</span>
                                </a>
                              </li>
                            <?php } ?>

                          </ul>
                        </nav>
                  </div>

                </div>
              <?php }else{?>

                <div class="jumbotron">
                  <h1>Ops!</h1>
                  <p>N&atilde;o foram encontrados registros!</p>
                </div>

              <?php }}else{?>

              <div class="jumbotron">
                <h1>Ol&aacute;!</h1>
                <p>Selecione os crit&eacute;rios da pesquisa.</p>
              </div>

            <?php }?>
          </div>

        </div>

          <?php include "../layout/rodape.php"; ?>
      </div>
        
    </body>
</html>