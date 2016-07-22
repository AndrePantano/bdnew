<?php 

if(isset($_GET["msg"])){

        $config = array(
            "type" => array("success","info","warning","danger"),
            "title" => array("Parab&eacute;ns","Aten&ccedil;&atilde;o")
        );

        switch (base64_decode($_GET["msg"])) {            
            case 0: 
              $type = $config["type"][0];
              $title = $config["title"][0];
              $message = "Registro gravado com sucesso";
              break;
            case 1:
              $type = $config["type"][0];
              $title = $config["title"][0];                  
              $message = "Registro editado com sucesso.";
              break;
            case 2:
              $type = $config["type"][0];
              $title = $config["title"][0];                 
              $message = "Registro exclu&iacute;do com sucesso.";
              break;
            case 3: 
              $type = $config["type"][3];
              $title = $config["title"][1];                    
              $message = "O texto da imagem n&atilde;o corresponde ao informado! Tente novamente.";
              break;
            case 4:
              $type = $config["type"][0];
              $title = $config["title"][0];                 
              $message = "Importa&ccedil;&atilde;o conclu&iacute;da com sucesso.";
              break;
            case 5:
              $type = $config["type"][3];
              $title = $config["title"][1];                    
              $message = "O arquivo n&atilde;o atende o formato desejado!";
              break;
            case 6:
              $type = $config["type"][1];
              $title = $config["title"][1];                    
              $message = "Nenhum arquivo foi recebido! <br/> Ou arquivo n&atilde;o atende o formato desejado!";
              break;
            case 7:
              $type = $config["type"][3];
              $title = $config["title"][1];                    
              $message = "O registro n&atilde;o existe na base de dados.";
              break;
            case 8: 
              $type = $config["type"][3];
              $title = $config["title"][1];                    
              $message = "J&aacute; existe um registro para essa data informada.";
              break;                  
            default:
              $type = $config["type"][1];
              $title = $config["title"][1];                    
              $message = "Nenhum registro foi alterado.";
              break;
        }

      echo "<div class='alert alert-".$type." alert-dismissible' role='alert'>";
      echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
      echo "<strong>".$title."!</strong> <br/>".$message;
      echo "</div>";
}
