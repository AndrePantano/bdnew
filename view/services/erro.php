<?php
include "../../controller/services/sessao_controller.php";
$con = new Sessao_Controller();
$con->getAutenticarSessao();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Erro</title>        
    </head>

    <body>

        <div class="container">
            <!-- inicio modal -->

            <?php include "../layout/navbar.php"; ?>
            <?php include "../services/mensagens.php"; ?>
            <div class="row page-header" id="conteudo">
                <div class="col-sm-12">
                    <div class="well well-sm jumbotron">
                        <h1>Alguma coisa está errada!</h1>
                        <p>Verifique se os dados informados estão corretos e tente novamente.</p>
                    </div>
                </div>
            </div>

             <?php include "../layout/rodape.php"; ?>
        </div>

    </body>
</html>