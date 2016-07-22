<?php
include "../../model/dbal_model.php";
include "sessao_controller.php";

$login = $_POST['login']."@brado.com.br";
$senha = md5($_POST['senha']);

$con = new DBAL_Model();

$atributos = array(
    array('funcao','estatus','corredor'), // TABELAS PARALELAS
    array('idFuncao','idEstatus','idCorredor'), // CAMPOS CHAVES ENTRE A TABELA PRINCIPAL E A TABELA PARALELA
    array('Funcao_Model','Estatus_Model','Corredor_Model'), // MODEL DA TABELA PARALELA
    array('setFuncao','setEstatus','setCorredor') // METODO DE ALIMENTAÇÃO DA CLASSE PRINCIPAL
);        
$criterio = " WHERE emFuncionario = '" . $login . "' AND shFuncionario = '" . $senha . "' AND idEstatus = 1";
$resultado = $con->Select("funcionario", "nmFuncionario", "Funcionario_Model", $atributos, $criterio );

if (count($resultado) == 1) {
    
    if ($resultado[0]->getShFuncionario() === md5("brado") ) {        
        header("location: ../../view/services/nova_senha.php?i=".base64_encode($resultado[0]->getIdFuncionario())."&n=".base64_encode($resultado[0]->getNmFuncionario()));
    }else{
        $sessao = new Sessao_Controller();
        $dados["idFuncionario"] = $resultado[0]->getIdFuncionario();
        $dados["nmFuncionario"] = ucwords($resultado[0]->getNmFuncionario());
        $dados["idFuncao"] = $resultado[0]->getFuncao()->getIdFuncao();
        $dados["idCorredor"] = $resultado[0]->getCorredor()->getIdCorredor();
        $sessao->AbreSessao($dados);

        //echo "é para ir para a home.";
        
        header("location: ../../view/home"); //se verdade vai para home;
    }
    
    //echo "o usuario existe";
} else {
    //echo "não existe usuario";
    /*
    header("location: ../../view/services/login.php?u=not"); //caso contrario login ou senha invalidos
    */
}