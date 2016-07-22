<?php

class Funcionario_Model {

    private $idFuncionario;
    private $nmFuncionario;
    private $shFuncionario;
    private $emFuncionario;
    private $funcao = array();    
    private $corredor = array();    
    private $estatus = array();

    public function __construct($dados) {
        $this->setIdFuncionario($dados["idFuncionario"]);
        $this->setNmFuncionario($dados["nmFuncionario"]);        
        $this->setShFuncionario($dados["shFuncionario"]);
        $this->setEmFuncionario($dados["emFuncionario"]);
    }
    public function setIdFuncionario($idFuncionario) {$this->idFuncionario = $idFuncionario;}
    public function setNmFuncionario($nmFuncionario) {$this->nmFuncionario = $nmFuncionario;}
    public function setShFuncionario($shFuncionario) {$this->shFuncionario = $shFuncionario;}
    public function setEmFuncionario($emFuncionario) {$this->emFuncionario = $emFuncionario;}
    public function setFuncao($funcao) {$this->funcao[] = $funcao;}
    public function setCorredor($corredor) {$this->corredor[] = $corredor;}
    public function setEstatus($estatus) {$this->estatus[] = $estatus;}
    
    public function getIdFuncionario() {return $this->idFuncionario;}
    public function getNmFuncionario() {return ucwords($this->nmFuncionario);}   
    public function getShFuncionario() {return $this->shFuncionario;}
    public function getEmFuncionario() {return $this->emFuncionario;}
    public function getFuncao() {return $this->funcao[0];}
    public function getCorredor() {return $this->corredor[0];}   
    public function getEstatus() {return $this->estatus[0];}
}
