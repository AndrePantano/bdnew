<?php

class Estatus_Model {

    private $idEstatus;
    private $nmEstatus;

    public function __construct($dados) {
        $this->setIdEstatus($dados["idEstatus"]);
        $this->setNmEstatus($dados["nmEstatus"]);
    }

    // sets da classe
    public function setIdEstatus($idEstatus) {$this->idEstatus = $idEstatus;}
    public function setNmEstatus($Estatus) {$this->nmEstatus = $Estatus;}

    // gets da classe
    public function getIdEstatus() {return $this->idEstatus;}
    public function getNmEstatus() {return ucwords($this->nmEstatus);}
}
