<?php

class Funcao_Model {

    private $idFuncao;
    private $nmFuncao;

    public function __construct($dados) {
        $this->setIdFuncao($dados["idFuncao"]);
        $this->setNmFuncao($dados["nmFuncao"]);
    }

    // sets da classe
    public function setIdFuncao($idFuncao) {$this->idFuncao = $idFuncao;}
    public function setNmFuncao($Funcao) {$this->nmFuncao = $Funcao;}

    // gets da classe
    public function getIdFuncao() {return $this->idFuncao;}
    public function getNmFuncao() {return ucwords($this->nmFuncao);}
}
