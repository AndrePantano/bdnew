<?php
include "../../controller/home/home_controller.php";

$con = new Home_Controller();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Home</title>
    </head>

    <body>
        <div class="container">
            <?php include "../layout/navbar.php"; ?>
            
            <div class="row page-header" id="conteudo">
                
                    <div class="col-sm-8">
                        <div class="jumbotron">
                            <h2>Bem vindo <?=$con->getNomeFuncionarioSessao()?>!</h2>
                            <p>Estamos construindo um novo jeito de trabalhar.<br/>
                            Em breve as planilhas e relat&oacute;rios  estar&atilde;o mais simples e f&aacute;ceis de manipular.</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <p class="text-muted">Voc&ecirc; est&aacute; no </p>
                        <img src="../layout/bdnew.png">
                    </div>
                
            </div>

            <?php include "../layout/rodape.php"; ?>
        </div>
    </body>
</html>