 <?php
include "../../controller/configuracao/configuracao_controller.php";

$con = new Configuracao_Controller();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "../layout/header.php"; ?>
        <title>Configuração</title>
        <script type="text/javascript" src="js/script.js"></script>
    </head>

    <body>
        <div class="container">        

            <?php include "../layout/navbar.php"; ?>

            <div class="row">

              <?php include "../layout/sidebar_config.php"; ?>

               <div class="col-sm-6">
                

                  <div class="row">                    
                      <div class="col-sm-12">
                        
                      </div>
                    </div>                 

              </div>
            </div>

            <?php include "../layout/rodape.php"; ?>
        </div>
    </body>
</html>