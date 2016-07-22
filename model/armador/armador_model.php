<?php

class Armador_Model {

    private $idArmador;
    private $nmArmador;
    private $sgArmador;

    public function __construct($dados) {
        $this->idArmador = $dados["idArmador"];
        $this->nmArmador = ucwords($dados["nmArmador"]);
        $this->sgArmador = ucwords($dados["sgArmador"]);
    }

    // sets da classe
    public function setIdArmador($idArmador) {$this->idArmador = $idArmador;}
    public function setNmArmador($nmArmador) {$this->nmArmador = $nmArmador;}
    public function setSgArmador($sgArmador) {$this->sgArmador = $sgArmador;}
    // gets da classe
    public function getIdArmador() {return $this->idArmador;}
    public function getNmArmador() {return $this->nmArmador;}
    public function getSgArmador() {return $this->sgArmador;}
}
