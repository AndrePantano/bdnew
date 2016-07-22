<?php

include "../../model/dbal_model.php";

if(isset($_POST["idFuncionario"])){

	$msg = "m=";

	if($_POST["senha"] == $_POST["confirma_senha"]){

	    $tabela = " funcionario ";
	    $idCampo = " idFuncionario = ".$_POST["idFuncionario"];
	    $valores = array(
	        " shFuncionario " => md5($_POST["senha"])
	    );

	    $con = new DBAL_Model();
	    //Select($table, $order, $modelMain, $atributo,$where)
	    $usuario = $con->Select("funcionario","nmFuncionario","Funcionario_Model",null,"Where idFuncionario = ".$_POST["idFuncionario"]);		
	    
	    if($usuario[0]->getShFuncionario() == md5("brado")){
		    $con->Update($tabela, $idCampo, $valores);
		    $msg .= 0;
	    }else{
	    	$msg .= 2;
		}
	}else{
		$msg .= 1;
	}

    header("location: ../../view/services/nova_senha.php?i=".base64_encode($_POST["idFuncionario"])."&n=".base64_encode($_POST["nmFuncionario"])."&".$msg);
}

