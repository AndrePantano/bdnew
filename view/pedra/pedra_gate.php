<?php
include "../../controller/pedra/pedra_gate_controller.php";
$con = new Pedra_Gate_Controller();

$dados = array();

// SE O USUARIO FOR ADMINISTRADOR, ELE PODE ALTERAR O CORREDOR ATUAL
if($con->getFuncaoUsuarioAtual() == 1 && isset($_GET['c']) && $_GET['c'] != "")
  $con->setCorredorDaPedra($_GET['c']);

if(isset($_GET["t"])){
  $dados = $con->getDadosTerminal($_GET["t"]);
}

$terminais = $con->getTerminaisComPedra();

$motivos = $con->getPedraMotivo();

$corredores = $con->getCorredores();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Pedra Dia</title>
        <script type="text/javascript" src="js/script.js"></script>
        <style type="text/css">
          .titulo_coluna_dias,
          .titulo_coluna_valor,
          .titulo_coluna_delta,        
          .titulo_coluna_real_dmaiii{
            text-align: center;       
           
          }
          .titulo_coluna_dias{
            font-size: 12px;
          }          
          .titulo_coluna_real_dmaiii{
             width: 50px;
          }
          .titulo_coluna_delta{
            width:25px;
          }          
          .titulo_coluna_valor{
            width:35px;
          } 
          .celula_valor{
            text-align: right;
          }
          .titulo_tabela{
            font-size: 12px;
          }
          .border-cells{
            border: 1px solid #DDD;
          }
          .color-zerado{color:#EEE;}
          //.color-previa{color:#ec5605;}
          .color-previa{color:#888;}
          .color-real{color:#4169e1;}
          .color-positivo{color:#018868;}
          .color-negativo{color:#f00;}
        </style>
    </head>

    <body>
      <div class="container">

        <?php foreach ($dados as $key => $dado): ?>

          <div class="modal fade" id="update<?=$dado['idCliente']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">

                <form action="../../controller/pedra/pedra_gate_controller.php" method="post">

                  <input type="hidden" name="acao"  value="edit" class="acao<?=$dado['idCliente']?>" />
                  <input type="hidden" name="idpedra"     value="<?=$dado['idPedra']?>"/>                                        
                  <input type="hidden" name="idterminal"  value="<?=$dado['idTerminal']?>"/>
                  <input type="hidden" name="idcliente"   value="<?=$dado['idCliente']?>"/>

                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Atualizar Pedra</h4>
                  </div>

                  <div class="modal-body">
                    <div class="row">
                      
                      <div class="col-sm-12">
                        <label for="">Cliente:</label>
                        <label for="" class="h4"><?= $dado['nmCliente']?></label>
                        <br/>

                        <div class="table-responsive">
                          <table class="table table-condensed table-hover table-striped">
                          <thead>

                            <tr>
                              <th class="titulo_coluna_dias border-cells"  colspan="3">
                                <span class="text-danger"><?=date("d/m",strtotime("- 1 day"))." - ". $con->getDiaSemana(date("w",strtotime("- 1 day")))?><br/> </span>D-1
                              </th>                                                      
                              <th class="titulo_coluna_dias border-cells"   colspan="2">
                                <span class="text-danger"><?=date("d/m")." - ". $con->getDiaSemana(date("w"))?></span> <br/>D
                              </th>
                              <th class="titulo_coluna_dias border-cells"   colspan="2">
                                <span class="text-danger"><?=date("d/m",strtotime("+ 1 day"))." - ". $con->getDiaSemana(date("w",strtotime("+1 day")))?></span> <br/>D+1
                              </th>
                              <th class="titulo_coluna_dias border-cells"   colspan="2">
                                <span class="text-danger"><?=date("d/m",strtotime("+ 2 day"))." - ". $con->getDiaSemana(date("w",strtotime("+2 day")))?></span> <br/>D+2
                              </th>
                              <th class="titulo_coluna_dias border-cells"  >
                                <span class="text-danger"><?=date("d/m",strtotime("+ 3 day"))." - ". $con->getDiaSemana(date("w",strtotime("+3 day")))?></span> <br/>D+3
                              </th>                            
                            </tr>

                            <tr class="titulo_tabela">
                              <th class="titulo_coluna_valor border-cells" >Pr&eacute;via</th>
                              <th class="titulo_coluna_valor border-cells" >Real</th>
                              <th class="titulo_coluna_delta border-cells" >&Delta;</th>                            
                              <th class="titulo_coluna_valor border-cells" >Pr&eacute;via</th>
                              <th class="titulo_coluna_valor border-cells" >Pedra</th>
                              <th class="titulo_coluna_valor border-cells" >Pr&eacute;via</th>
                              <th class="titulo_coluna_valor border-cells" >Pedra</th>
                              <th class="titulo_coluna_valor border-cells" >Pr&eacute;via</th>
                              <th class="titulo_coluna_valor border-cells" >Pedra</th>
                              <th class="titulo_coluna_real_dmaiii border-cells" >Pedra</th>                            
                            </tr>
                          </thead>
                          <tbody style="font-size:12px;">                          
                                                                          
                                  <tr data-toggle="modal" data-target="#update">                                                                                                              
                                    <td class="celula_valor border-cells"> 
                                      <input type="hidden" class="pvpedra pv-pedra<?=$dado['idCliente']?>" value="<?=$dado['pvPedra']?>"> 
                                      <?= $dado['pvPedra'] ?> 
                                    </td>
                                    <td class="celula_valor border-cells"> 
                                      <input type="number" name="repedra" data-id="<?=$dado['idCliente']?>" class="form-control input-sm repedra re-pedra<?=$dado['idCliente']?>" required value="<?=$dado['rePedra']?>">
                                    </td>
                                    
                                    <td class="celula_valor border-cells"> 
                                      <span class="delta<?=$dado['idCliente']?>"> <?= $dado['rePedra'] - $dado['pvPedra'] ?> </span> 
                                    </td>                                  
                                    <td class="celula_valor border-cells"> <?= $dado['pv_d'] ?> </td>
                                    <td class="celula_valor border-cells"> <input type="number" name="re_d"      class="form-control input-sm" required value="<?=$dado['re_d']?>"/></td>
                                    <td class="celula_valor border-cells"> <?= $dado['pv_dmai'] ?> </td>
                                    <td class="celula_valor border-cells"> <input type="number" name="re_dmai"   class="form-control input-sm" required value="<?=$dado['re_dmai']?>"/></td>
                                    <td class="celula_valor border-cells"> <?= $dado['pv_dmaii'] ?> </td>
                                    <td class="celula_valor border-cells"> <input type="number" name="re_dmaii"  class="form-control input-sm" required value="<?=$dado['re_dmaii']?>"/></td>
                                    <td class="celula_valor border-cells"> <input type="number" name="re_dmaiii" class="form-control input-sm" required value="<?=$dado['re_dmaiii']?>"/></td>                                  
                                  </tr>
                                                    
                          </tbody>
                          <tfoot></tfoot>
                        </table>                  
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="">Respons&aacute;vel da Perda:</label>
                          <select name="idpedramotivo" class="form-control idpedramotivo<?=$dado['idCliente']?>">                                      
                            <option value=""></option>
                            <?php foreach ($motivos as $motivo):?>
                              <option value="<?= $motivo['idPedraMotivo']?>" <?= $motivo['idPedraMotivo'] == $dado['idPedraMotivo']? "selected='selected'":""?> ><?=$motivo['nmPedraMotivo']?></option>  
                            <?php endforeach;?>                                      
                          </select>
                        </div>
                      </div>
                      
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">Descri&ccedil;&atilde;o da Perda:</label>
                          <textarea class="form-control obpedra<?=$dado['idCliente']?>" name="obpedra"><?=$dado['obPedra']?></textarea>
                          <p class="text-muted">N&atilde;o utilize ap&oacute;strofos ou aspas.</p>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <p class="text-muted">Obs. Para os casos onde o &Delta; (delta) for negativo, &eacute; obrigatório o preenchimento do responsável e a descri&ccedil;&atilde;o da perda.</p>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-edit"  data-id="<?=$dado['idCliente']?>" >Salvar Altera&ccedil;&otilde;es</button>
                  </div>

                </form>

              </div>
            </div>
          </div>

        <?php endforeach; ?>

        <?php include "../layout/navbar.php"; ?>
          
        <?php include "../services/mensagens.php"; ?>


            <div class="row">                    
              <!--div class="col-sm-12">
                <span class="text-muted pull-right">&Uacute;ltimo Movimento da Pedra: < ? = d a t e( " d  /m/  Y H:i:s",strt o tim e( $ c   on->g etDataUl  timaMo vimen tacaoPe dr  a() ) ) ? ></span>
              </div -->
                
              <div class="col-sm-12">
                <label class="h3"><i class="fa fa-diamond"></i> Pedra Gate</label>                
              </div>

              <div class="col-sm-6">  
                <?php if($con->getFuncaoUsuarioAtual() == 1):?>
                  <form class="navbar-form navbar-left" method="get" role="search" action="">
                    <div class="form-group">
                      <label for="">Voc&ecirc; est&aacute; no corredor:</label>
                      <select name="c" id="" class="form-control">                        
                        <?php foreach ($corredores as $corredor): ?>
                          <option value="<?=$corredor['idCorredor']?>" <?= isset($_GET["c"])? $_GET["c"] == $corredor["idCorredor"]? "selected='selected'":"": $con->getCorredorDaPedra() == $corredor["idCorredor"]? "selected='selected'":"" ?> ><?=$corredor['nmCorredor']?></option>                       
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>&nbsp;</button>
                  </form>
                <?php endif;?>
              </div>

             </div>
          

            <div class="row">
              <div class="col-sm-12">
                <br/>
                <br/>
                <ul class="nav nav-tabs">
                   <?php foreach($terminais as $terminal):?>     
                     <li role="presentation" class="<?= isset($_GET['t']) && $_GET['t'] == $terminal['idTerminal']?'active':''?>">
                      <a href="pedra_gate.php?<?= isset($_GET['c'])?'c='.$_GET['c'].'&':''?>t=<?=$terminal['idTerminal']?>" >
                        <i class="fa fa-industry"></i> 
                        <?= $terminal['sgTerminal']." - ".ucwords($terminal['nmTerminal']) ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-12">
                <br/>
                <?php 
                if(isset($_GET['t'])){
                  if(count($dados) > 0){ ?>
                 
                    <p class="text-muted"><i>Para realizar a atualiza&ccedil;&atilde;o basta clicar na linha do cliente.</i></p>
                    <div class="table-responsive">

                      <table class="table table-condensed table-hover table-striped">
                        <thead>

                          <tr>                                      
                            <th width="150px">&nbsp;</th>
                            <th class="titulo_coluna_dias border-cells"  colspan="3">
                              <span class="text-danger"><?=date("d/m",strtotime("- 1 day"))." - ". $con->getDiaSemana(date("w",strtotime("- 1 day")))?><br/> </span>D-1
                            </th>                          
                            <th width="100px"></th>
                            <th class="titulo_coluna_dias border-cells"   colspan="2">
                              <span class="text-danger"><?=date("d/m")." - ". $con->getDiaSemana(date("w"))?></span> <br/>D
                            </th>
                            <th class="titulo_coluna_dias border-cells"   colspan="2">
                              <span class="text-danger"><?=date("d/m",strtotime("+ 1 day"))." - ". $con->getDiaSemana(date("w",strtotime("+1 day")))?></span> <br/>D+1
                            </th>
                            <th class="titulo_coluna_dias border-cells"   colspan="2">
                              <span class="text-danger"><?=date("d/m",strtotime("+ 2 day"))." - ". $con->getDiaSemana(date("w",strtotime("+2 day")))?></span> <br/>D+2
                            </th>
                            <th class="titulo_coluna_dias border-cells"  >
                              <span class="text-danger"><?=date("d/m",strtotime("+ 3 day"))." - ". $con->getDiaSemana(date("w",strtotime("+3 day")))?></span> <br/>D+3
                            </th>                            
                          </tr>

                          <tr class="titulo_tabela">
                            <th>Cliente</th>
                            <th class="titulo_coluna_valor border-cells" >Pr&eacute;via</th>
                            <th class="titulo_coluna_valor border-cells" >Real</th>
                            <th class="titulo_coluna_delta border-cells" >&Delta;</th>
                            <th>Responsabilidade</th>
                            <th class="titulo_coluna_valor border-cells" >Pr&eacute;via</th>
                            <th class="titulo_coluna_valor border-cells" >Pedra</th>
                            <th class="titulo_coluna_valor border-cells" >Pr&eacute;via</th>
                            <th class="titulo_coluna_valor border-cells" >Pedra</th>
                            <th class="titulo_coluna_valor border-cells" >Pr&eacute;via</th>
                            <th class="titulo_coluna_valor border-cells" >Pedra</th>
                            <th class="titulo_coluna_real_dmaiii border-cells" >Pedra</th>                            
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_pvpedra = $total_repedra = $total_re_d = $total_re_dmai = $total_re_dmaii = $total_re_dmaiii = $total_pv_d = $total_pv_dmai = $total_pv_dmaii = 0;
                            foreach ($dados as $key => $dado): 
                              $delta = $dado["rePedra"] - $dado["pvPedra"];
                            ?>                             
                                                                        
                                <tr class="abre-modal" data-id="<?=$dado['idCliente']?>" data-tipo="update">                                        
                                  <td> <?= $dado["nmCliente"]?>     </td>
                                  <td class="celula_valor border-cells <?=$dado["pvPedra"] == 0?'color-zerado':'color-previa'?>">                                                                           <?= $dado["pvPedra"]?>                    </td>
                                  <td class="celula_valor border-cells <?=$dado["rePedra"] == 0?'color-zerado':'color-real'?>">                                                                             <?= $dado["rePedra"]?>                    </td>
                                  <td class="celula_valor border-cells <?=$delta > 0 ?'color-positivo': ($delta < 0?'color-negativo':'color-zerado')?>"> <?= $dado["rePedra"] - $dado["pvPedra"]?> </td>
                                  <td> <?= $dado["nmPedraMotivo"]?> </td>
                                  <td class="celula_valor border-cells <?=$dado["pv_d"] == 0?'color-zerado':'color-previa'?>">                                                                              <?= $dado["pv_d"]?>                       </td>
                                  <td class="celula_valor border-cells <?=$dado["re_d"] == 0?'color-zerado':'color-real'?>">                                                                                <?= $dado["re_d"]?>                       </td>
                                  <td class="celula_valor border-cells <?=$dado["pv_dmai"] == 0?'color-zerado':'color-previa'?>">                                                                           <?= $dado["pv_dmai"]?>                    </td>
                                  <td class="celula_valor border-cells <?=$dado["re_dmai"] == 0?'color-zerado':'color-real'?>">                                                                             <?= $dado["re_dmai"]?>                    </td>
                                  <td class="celula_valor border-cells <?=$dado["pv_dmaii"] == 0?'color-zerado':'color-previa'?>">                                                                          <?= $dado["pv_dmaii"]?>                   </td>
                                  <td class="celula_valor border-cells <?=$dado["re_dmaii"] == 0?'color-zerado':'color-real'?>">                                                                            <?= $dado["re_dmaii"]?>                   </td>
                                  <td class="celula_valor border-cells <?=$dado["re_dmaiii"] == 0?'color-zerado':'color-real'?>">                                                                           <?= $dado["re_dmaiii"]?>                  </td>                                  
                                </tr>
                            
                            <?php 

                              $total_pvpedra     += $dado["pvPedra"];
                              $total_repedra     += $dado["rePedra"];
                              $total_pv_d        += $dado["pv_d"];
                              $total_pv_dmai     += $dado["pv_dmai"];
                              $total_pv_dmaii    += $dado["pv_dmaii"];
                              $total_re_d        += $dado["re_d"];
                              $total_re_dmai     += $dado["re_dmai"];
                              $total_re_dmaii    += $dado["re_dmaii"];
                              $total_re_dmaiii   += $dado["re_dmaiii"];

                              endforeach; 
                            ?>
                        </tbody>
                        <tfoot>
                          <tr style="border-top: 2px solid #DDD;">
                            <td><label>Total</label></td>     
                            <td class="celula_valor border-cells <?=$total_pvpedra==0?'color-zerado':'color-previa'?>" ><label><?=$total_pvpedra?></label></td>
                            <td class="celula_valor border-cells <?=$total_repedra==0?'color-zerado':'color-real'?>" ><label><?=$total_repedra?></label></td>
                            <td class="celula_valor border-cells <?= $total_repedra-$total_pvpedra > 0?'color-positivo':($total_repedra-$total_pvpedra < 0 ?'color-negativo':'color-zerado')?>" ><label><?=$total_repedra-$total_pvpedra?></label></td>
                            <td><!-- motivo --></td>
                            <td class="celula_valor border-cells <?=$total_pv_d==0?'color-zerado':'color-previa'?>" ><label><?=$total_pv_d?></label></td>
                            <td class="celula_valor border-cells <?=$total_re_d==0?'color-zerado':'color-real'?>" ><label><?=$total_re_d?></label></td>
                            <td class="celula_valor border-cells <?=$total_pv_dmai==0?'color-zerado':'color-previa'?>" ><label><?=$total_pv_dmai?></label></td>
                            <td class="celula_valor border-cells <?=$total_re_dmai==0?'color-zerado':'color-real'?>" ><label><?=$total_re_dmai?></label></td>
                            <td class="celula_valor border-cells <?=$total_pv_dmaii==0?'color-zerado':'color-previa'?>" ><label><?=$total_pv_dmaii?></label></td>
                            <td class="celula_valor border-cells <?=$total_re_dmaii==0?'color-zerado':'color-real'?>" ><label><?=$total_re_dmaii?></label></td>
                            <td class="celula_valor border-cells <?=$total_re_dmaiii==0?'color-zerado':'color-real'?>" ><label><?=$total_re_dmaiii?></label></td>                            
                          </tr>
                        </tfoot>

                      </table>
                    </div>

                  <?php }else{?>

                    <div class="jumbotron">
                      <h1>Ops!</h1>
                      <p>N&atilde;o foram encontrados registros!</p>
                    </div>

                  <?php }}else{?>

                  <div class="jumbotron">
                    <h1>Ol&aacute;!</h1>
                    <p>Selecione um terminal acima.</p>
                  </div>

                <?php }?>
              </div>
            </div>

            <?php include "../layout/rodape.php"; ?>
        </div>
        
    </body>
</html>