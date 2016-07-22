<?php

class Terminal_Model {

    private $idTerminal;
    private $nmTerminal;
    private $sgTerminal;
    private $corredor = array();

    public function __construct($dados) {
        $this->idTerminal = $dados["idTerminal"];
        $this->nmTerminal = ucwords($dados["nmTerminal"]);
        $this->sgTerminal = ucwords($dados["sgTerminal"]);
    }

    // sets da classe
    public function setIdTerminal($idTerminal) {$this->idTerminal = $idTerminal;}
    public function setNmTerminal($nmTerminal) {$this->nmTerminal = $nmTerminal;}
    public function setSgTerminal($sgTerminal) {$this->sgTerminal = $sgTerminal;}
    public function setCorredor($corredor) {$this->corredor[] = $corredor;}
    // gets da classe
    public function getIdTerminal() {return $this->idTerminal;}
    public function getNmTerminal() {return $this->nmTerminal;}
    public function getSgTerminal() {return $this->sgTerminal;}
    public function getCorredor() {return $this->corredor[0];}
}
