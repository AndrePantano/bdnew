<?php

class Cliente_Model {

    private $idCliente;
    private $nmCliente;
    private $peCliente;
    private $fxCliente;
    private $terminal = array();

    public function __construct($dados) {
        $this->setIdCliente($dados["idCliente"]);
        $this->setNmCliente(ucwords($dados["nmCliente"]));
        $this->setPeCliente($dados["peCliente"]);
        $this->setFxCliente($dados["fxCliente"]);
    }

    // sets da classe
    public function setIdCliente($idCliente) {$this->idCliente = $idCliente;}
    public function setNmCliente($nmCliente) {$this->nmCliente = $nmCliente;}
    public function setPeCliente($peCliente) {$this->peCliente = $peCliente;}
    public function setFxCliente($fxCliente) {$this->fxCliente = $fxCliente;}
    public function setTerminal($terminal) {$this->terminal[] = $terminal;}
    // gets da classe
    public function getIdCliente() {return $this->idCliente;}
    public function getNmCliente() {return $this->nmCliente;}
    public function getPeCliente() {return $this->peCliente;}
    public function getFxCliente() {return $this->fxCliente;}
    public function getTerminal() {return $this->terminal[0];}
}
