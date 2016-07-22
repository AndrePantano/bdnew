<?php 
include "../../controller/services/captcha_controller.php";
CriaImagem("../../view/services/");
?>

<div class="col-sm-12"><hr/></div>

<div class="col-sm-12 form-group">
  <label class="col-sm-12 control-label" for="captcha">Digite o código da imagem:</label>
  <div class="col-sm-3">
    <input type="number" maxlength="4" class="form-control" name="captcha" id="captcha" required="required">
  </div>
  <div class="col-sm-3">
    <img src="../services/captcha.jpg" class="thumbnail" />
  </div>
</div>