<?php
include "../../model/dbal_model.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include "../../controller/services/sessao_controller.php";

}else{
    include "../../controller/services/sessao_controller.php";    
    include "../services/sessao_controller.php";
    include "../services/captcha_controller.php";   
}

class Cameras_Controller extends Sessao_Controller{
   	private $dbal;
    private $terminais;
    private $imagens;

    public function __construct($t,$c) {
    	$this->dbal = new DBAL_Model();
        $this->getAutenticarSessao();


         // dados do servidor
        $servidor   = "10.5.0.17";
        $usuario    = "ftpcameras";
        $senha      = "brd0910";
        // abre a conexao com o servidor
        if(ftp_connect($servidor)){
            $ftp = ftp_connect($servidor);
            
            // faz o login no servidor
            $login = ftp_login($ftp, $usuario, $senha);
            // obtem os arquivos do diretório atual
            
            $this->terminais = ftp_nlist($ftp, "../../");
            if(!is_null($t) && !is_null($c)){
                $this->imagens = ftp_nlist($ftp, $t.".".$c);            
            }

            // exibe estes arquivos
            ftp_close($ftp);
        }
    }
    public function DBAL(){
        return $this->dbal;
    }
    public function getTerminais(){
        $local = array(
            103 => "cambe",
            108 => "guarapuava",
            110 => "tatui",
            115 => "cruz alta",
            131 => "araraquara",
            135 => "ponta grossa",
            138 => "rondonopolis"
        );
        
        return $local;
    }
    public function getCameras(){

        $local = $this->getTerminais();

        $term = array();
        $terminais = array();
        if(count($this->terminais) > 0){
            $terminais = $this->terminais;
        }
        foreach ($terminais as $item) {
            $exp = explode(".", $item);

            if($exp[0] != ""){
                $term[$exp[0]]["local"] = $local[$exp[0]];

                switch($exp[1]){
                    case 1:
                     $term[$exp[0]]["cameras"][$exp[1]] = "CAM1";
                     break;
                    case 2:
                     $term[$exp[0]]["cameras"][$exp[1]] = "CAM2";
                     break;
                    case 3:
                     $term[$exp[0]]["cameras"][$exp[1]] = "CAM3";
                     break;
                }
            }

        }
        return $term;
    }
    public function getImages(){
        return $this->imagens;
    }

}
