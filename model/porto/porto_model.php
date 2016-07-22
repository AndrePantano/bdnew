<?php

class Porto_Model {

    private $idPorto;
    private $nmPorto;

    public function __construct($dados) {
        $this->setIdPorto($dados["idPorto"]);
        $this->setNmPorto($dados["nmPorto"]);
    }

    // sets da classe
    public function setIdPorto($idPorto) {$this->idPorto = $idPorto;}
    public function setNmPorto($Porto) {$this->nmPorto = $Porto;}

    // gets da classe
    public function getIdPorto() {return $this->idPorto;}
    public function getNmPorto() {return ucwords($this->nmPorto);}
}
