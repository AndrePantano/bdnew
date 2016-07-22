<?php
include "../../controller/services/sessao_controller.php";
$con = new Sessao_Controller();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
       <?php include "../layout/header.php"; ?>
        <title>SH - Nova Senha</title>
    </head>
    <body>

     <div class="container">

            <?php include "../layout/navbar.php"; ?>
            <div class="row">
                
                <div class="col-sm-4 col-sm-offset-4">                
                    <div class="well">
                        <h3 class="text-center">Cadastrar Nova Senha</h3>
                        <div class="well">
                            <h3>Olá, <span class=" text-primary" for=""><?= ucwords(base64_decode($_GET["n"])) ?></span></h3>
                            <p class="text-muted"> Sua senha é a padrão, altere-a para usar o sistema.</p>                            
                        </div>

                        <!-- MENSAGENS DO SISTEMA -->            
                        <?php 
                        if(isset($_GET["m"])){ 
                            switch ($_GET["m"]) {
                                case 0: 
                                    ?>
                                    <div class="alert alert-success">
                                        <p><strong>Senha alterada com sucesso.</strong></p>
                                        <p>Clique aqui para <a href="login.php">Fazer Login</a></p>
                                    </div>
                                    <?php
                                    break;
                                case 1:
                                    ?>
                                    <div class="alert alert-danger">
                                        <p><strong>Ops!.</strong></p>
                                        <p>As senhas não conferem, tente outra vez!.</p>                                    
                                    </div>

                                    <?php
                                    break;
                                case 2:
                                    ?>
                                    <div class="alert alert-danger">
                                        <p><strong>Ops!.</strong></p>
                                        <p>As senhas já foram alteradas.</p>                                    
                                    </div>

                                    <?php
                                    break;
                            }
                        }
                        ?>

                        <form name="form_senha" id="form_senha" method="post" action="../../controller/services/nova_senha_controller.php">
                            <input type="hidden" name="idFuncionario" value="<?=base64_decode($_GET["i"])?>"/>
                            <input type="hidden" name="nmFuncionario" value="<?=base64_decode($_GET["n"])?>"/>
                            <fieldset>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <span class="text-info"><label class="">Senha atual:</label> brado (Senha Padrão)</span>
                                    </div>
                
                                    <div class="form-group">
                                        <label class="" for="senha">Nova senha:</label>
                                        <input id="senha" name="senha" type="password" minlength="6" maxlength="30" placeholder="senha" required="" class="form-control">                                        
                                    </div>

                                    <div class="form-group">
                                        <label class="" for="confirma_senha">Confirma senha:</label>
                                        <input id="confirma_senha" name="confirma_senha" type="password" minlength="6" placeholder="confirmar senha" required="" class="form-control">
                                    </div>
                                    <div id="alerta">

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <a href="login.php" role="button" class="btn btn-default btn-block">Cancelar</a>
                                    </div>                                
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default btn-block">Limpar</button>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                    </div>
                </div>
                
            </div>
           
            <?php include "../layout/rodape.php"; ?>

        </div>

    </body>
</html>