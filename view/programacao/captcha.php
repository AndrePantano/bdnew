<?php 
include "../../controller/services/captcha_controller.php";
CriaImagem("../../view/programacao/");
?>

<div class="col-sm-12 form-group">
  <label class="col-sm-12 control-label" for="captcha">Digite o código da imagem:</label>
  <div class="col-sm-3">
    <input type="text" maxlength="4" class="form-control" name="captcha" id="captcha" required="required">
  </div>
  <div class="col-sm-3">
    <img src="captcha.jpg" class="thumbnail" />
  </div>
</div>