<?php
include "../../controller/importar/importar_controller.php";

$con = new Importar_Controller();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <?php include "../layout/header.php"; ?>

    <!-- atualiza a página -->
    <meta http-equiv="refresh" content="600"> 

    <title>Importar</title>

    <script type="text/javascript">
        $("document").ready(function(){

            // CADA VEZ QUE O TIPO DE RELATÓRIO MUDAR
            // ALTERA O "data-target" DO BOTAO DE BAIXAR MACRO
            $("#tipo").change(function(){
                $("#btn_macro").data("target", $(this).val());
            });

            // AO CLICAR NO BOTAO DE BAIXAR MACRO
            $("#btn_macro").click(function(){               
                if($(this).data("target") != ""){
                    window.open("macros/"+$(this).data("target")+".xlsm");
                }else{
                    $("#modal_atencao").modal("show");
                }
            });
        });
    </script>
    </head>

    <body>
        <div class="container">

            <div class="modal fade" tabindex="-1" role="dialog" id="modal_atencao">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Atenção</h4>
                  </div>
                  <div class="modal-body">
                    <p>Selecione um tipo de relat&oacute;rio&hellip;</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>                    
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- nav bar -->
            <?php include "../layout/navbar.php"; ?>
            <?php include "../services/mensagens.php"; ?>            
           
            <div class="row">
                <div class="col-sm-12 page-header">
                    <h2><span class="glyphicon glyphicon-upload"></span> Importar</h2>
                    <span class="h4"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <form class="form-vertical" action="../../controller/importar/importar_controller.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
                        <div class="panel panel-default">
                            <div class="panel-heading"><h4><span class="glyphicon glyphicon-upload"></span> Importar Relat&oacute;rio</h4></div>
                            <div class="panel-body">

                                <!-- div class="col-sm-12 form-group">
                                    <label>Tipo de Relatório:</label>
                                    <select name="tipo" id="tipo" class="form-control" required>
                                        <option value="">Escolha uma opção</option>
                                        <option value="fpt_macro">Fretes Por Transportadora</option>
                                    </select>                                    
                                </div -->

                                <div class="col-sm-12 form-group">
                                    
                                    
                                </div>
                                <div class="col-sm-12 form-group">
                                  <label class="col-sm-12 control-label" for="captcha">Escolha seu arquivo:</label>
                                  <div class="col-sm-12">
                                    <input name="csv" type="file" id="csv" class="" required/>
                                  </div>
                                </div>

                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-upload"></span> Importar Relat&oacute;rio
                                        </button>
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