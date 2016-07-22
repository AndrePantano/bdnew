<?php session_start(); ?>

<?php
/*
if (isset($_SESSION["idFuncionario"])) {
    session_start();
}
*/

if (session_id() == "") {
    session_start();
}


if (isset($_GET['logout'])) {
    $_SESSION[] = array();
    session_destroy();
    header("location: ../../index.php");
}

class Sessao_Controller{
  
    public function AbreSessao($dados) {
        $_SESSION["idFuncionario"] = $dados["idFuncionario"];
        $_SESSION["nmFuncionario"] = $dados["nmFuncionario"];        
        $_SESSION["idFuncao"] = $dados["idFuncao"];
        $_SESSION["idCorredor"] = $dados["idCorredor"];
    }

    public function getIdFuncionarioSessao() {return  $_SESSION["idFuncionario"];}
    public function getNomeFuncionarioSessao() {return  $_SESSION["nmFuncionario"];}
    public function getIdFuncaoFuncionarioSessao() {return  $_SESSION["idFuncao"];}
    public function getIdCorredorFuncionarioSessao() {return  $_SESSION["idCorredor"];}
    public function getAutenticarSessao() {
        if (!isset($_SESSION['idFuncionario'])) {
            header("location: ../../index.php");
        }
    }
    public function getSessaoIniciada(){
        if(count($_SESSION) > 0){
            return true;
        }else{
            return false;
        }
    }

}
