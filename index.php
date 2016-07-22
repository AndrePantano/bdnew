<?php
include "controller/services/sessao_controller.php";
$con = new Sessao_Controller();

    if($con->getSessaoIniciada()){
        header("Location: view/home");
    }else{
        header("Location: view/services/login.php");
    }
?>
