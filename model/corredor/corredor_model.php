<?php

class Corredor_Model {

    private $idCorredor;
    private $nmCorredor;

    public function __construct($dados) {
        $this->setIdCorredor($dados["idCorredor"]);
        $this->setNmCorredor($dados["nmCorredor"]);
    }

    // sets da classe
    public function setIdCorredor($idCorredor) {$this->idCorredor = $idCorredor;}
    public function setNmCorredor($Corredor) {$this->nmCorredor = $Corredor;}

    // gets da classe
    public function getIdCorredor() {return $this->idCorredor;}
    public function getNmCorredor() {return ucwords($this->nmCorredor);}
}
