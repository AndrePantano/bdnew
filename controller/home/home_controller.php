<?php
include "../../model/dbal_model.php";
include "../../controller/services/sessao_controller.php";

class Home_Controller extends Sessao_Controller{
   
    public function __construct() {        
        $this->getAutenticarSessao();
    }
    
}
