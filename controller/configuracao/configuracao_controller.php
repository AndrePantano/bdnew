<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";
}else{
    include "../services/sessao_controller.php";
    include "../services/captcha_controller.php";
}

class Configuracao_Controller extends Sessao_Controller{

    public function __construct() {
        $this->getAutenticarSessao();
    }
   
}

