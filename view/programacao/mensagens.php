<?php if(isset($_GET["msg"])):?>
  
      <?php 
        switch (base64_decode($_GET["msg"])) {            
            case 0:                    
              echo "<div class='alert alert-success'><p>Registro gravado com sucesso.</p></div>";
              break;
            case 1:                    
              echo "<div class='alert alert-success'><p>Registro editado com sucesso.</p></div>";
              break;
            case 2:                    
              echo "<div class='alert alert-success'><p>Registro excluído com sucesso.</p></div>";
              break;
            case 3:                    
              echo "<div class='alert alert-danger'><p>O texto da imagem não corresponde ao informado! Tente novamente.</p></div>";
              break;
            default:
              echo "<div class='alert alert-success'><p>Nenhum registro foi alterado.</p></div>";
              break;
        }
      ?>                  
    
<?php endif;?>