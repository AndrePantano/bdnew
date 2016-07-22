<?php
include "../../controller/services/sessao_controller.php";
$con = new Sessao_Controller();

if($con->getSessaoIniciada()){
    header("Location: view/home/home.php");    
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php include "../layout/header.php"; ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $(window).load(function(){
                $("#login").focus();
            });
        });
    </script> 
    <title>new</title>
</head>
<body>

    <div class="container">
       
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4">
             

                <?php if(isset($_GET["u"])): ?>
                    <div class="alert alert-danger">
                        <p><strong>Ops!</strong></p>
                        <p>Login ou senha inv&aacute;lidos.</p>
                    </div>
                <?php endif ?>

                <form class="form-horizontal" role="form" name="form" method="post" action="../../controller/services/login_controller.php">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="text-center">&Aacute;rea de Acesso</h4>
                        </div>
                        <div class="panel-body" >
                            <div class="form-group">
                                <div class="col-sm-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login" name="login" type="text" placeholder="usuario" required class="form-control">                                        
                                    </div>                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="senha" name="senha" type="password" placeholder="Senha" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="form-group">
                                <div class="col-sm-6 col-xs-6">
                                    <button type="submit" class="btn btn-success btn-block">Entrar </button>
                                </div>
                            </div>
                        </div>  
                    </div>
                </form>                    
            </div>                
        </div>  
</div>
</body>
</html>