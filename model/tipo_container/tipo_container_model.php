<?php

class TipoContainer_Model {

    private $idTipoContainer;
    private $nmTipoContainer;

    public function __construct($dados) {
        $this->setIdTipoContainer($dados["idTipoContainer"]);
        $this->setNmTipoContainer($dados["nmTipoContainer"]);
    }

    // sets da classe
    public function setIdTipoContainer($idTipoContainer) {$this->idTipoContainer = $idTipoContainer;}
    public function setNmTipoContainer($nmTipoContainer) {$this->nmTipoContainer = $nmTipoContainer;}

    // gets da classe
    public function getIdTipoContainer() {return $this->idTipoContainer;}
    public function getNmTipoContainer() {return ucwords($this->nmTipoContainer);}
}
