<?php
include "../../controller/cameras/cameras_controller.php";


$con = "";
// se houver estes paramentos, realiza a pesquisa
$imagens = "";
if(isset($_GET["term"]) && isset($_GET["cam"])){
  $con = new Cameras_Controller($_GET["term"],$_GET["cam"]);
  $imagens = $con->getImages();
}else{
  $con = new Cameras_Controller(null,null);
}

$terminais = $con->getCameras();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../../bootstrap/js/jquery-2.1.4.min.js"></script>

<!-- atualiza a página -->
<meta http-equiv="refresh" content="600"> 
<title>Cameras</title>
<?php include "../layout/header.php";?>
</head>
<body>

  <div class="container">

    <?php include "../layout/navbar.php";?>

    <div class="row">
      <?php if(count($terminais) > 0){?>
        <div class="col-sm-2">
        <h3> <span class="glyphicon glyphicon-globe"></span> Terminais</h3>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
         <?php 
         asort($terminais);
         foreach($terminais as $k => $terminal){
          if($terminal["local"] != "" ){ ?>

            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$k?>" aria-expanded="true" aria-controls="collapseOne">
                    <?= ucwords($terminal["local"])?>
                  </a>
                </h4>
              </div>
              <div id="collapse<?=$k?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                  <?php 
                  asort($terminal["cameras"]);
                  foreach($terminal["cameras"] as $j => $camera){?>

                    <a href="?term=<?=$k?>&cam=<?=$j?>"> <?= $camera ?></a>
                  <?php } ?>
                </div>
              </div>
            </div>              
          <?php }} ?>
        </div> 
        </div>
      <?php }else{?> 
        <div class="col-sm-12">
          <div class="alert alert-info">
            <p>Essa página só está acessível dentro da rede da BRADO.</p>
          </div>
        </div>
      <?php }?>
      <?php 
        if(isset($_GET["term"]) && isset($_GET["cam"])){?>
          <div class="col sm-10">
            <h3><span class="glyphicon glyphicon-camera"></span> <?= ucwords($terminais[$_GET["term"]]["local"]." - ". $terminais[$_GET["term"]]["cameras"][$_GET["cam"]])?></h3>
           <?php
              sort($imagens); 
              $cont = count($imagens);
              //for($i = ($cont - 10); $i < $cont;$i++) {
                //echo "<p>".$imagens[$i]."</p>";
                echo "<img src='ftp://10.5.0.17/".$imagens[$cont -1]."' width='800px'>";
              //}            
            ?>
          </div>
        <?php }?>
    </div>
        
  </div>
</body>
</html>