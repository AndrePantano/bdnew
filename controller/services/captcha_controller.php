<?php

function Chave($t){ 
	$key = "";
    $car = "1234567890";
    for ($i = 0; $i < $t; $i++) {
        $key .= $car{rand(0, strlen($car) - 1)};
    } 
    return $key;
}

function CriaImagem($url){

    $key = Chave(4);
    $img = ImageCreate(100,25);
    $fundo = ImageColorAllocate($img,0,138,105);
    $texto = ImageColorAllocate($img,255,255,255);
    ImageString($img,5,30,4,$key,$texto); 
    ImageJpeg($img,$url."captcha.jpg");
    
    unset($_SESSION["captcha"]);
    $_SESSION["captcha"] = $key;

}

function ValidarCaptcha(){
    if($_POST["captcha"] == $_SESSION['captcha']){
        return true;
    }else{
        return false;
    }
}
