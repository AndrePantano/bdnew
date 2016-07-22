<?php

class Programacao_Model {

    private $idProgramacao;
    private $dsProgramacao; // data da solicitacao do cliente
    private $qtProgramacao; // quantidade
    private $inProgramacao; // instrução do navio
    private $bkProgramacao; // booking
    private $dlcProgramacao; // deadline do cliente
    private $nvProgramacao; // navio
    private $dcProgramacao; // data de criação do registro
    private $grupo_cliente = array();
    private $armador = array();
    private $funcionario = array();
    private $terminal = array();
    private $porto = array();
    private $produto = array();
    private $tipo_container = array();

    public function __construct($dados) {
        $this->setIdProgramacao($dados["idProgramacao"]);
        $this->setDsProgramacao($dados["dsProgramacao"]);
        $this->setQtProgramacao($dados["qtProgramacao"]);
        $this->setInProgramacao($dados["inProgramacao"]);
        $this->setBkProgramacao($dados["bkProgramacao"]);
        $this->setDlcProgramacao($dados["dlcProgramacao"]);
        $this->setNvProgramacao($dados["nvProgramacao"]);
        $this->setDcProgramacao($dados["dcProgramacao"]);
    }

    // sets da classe
    public function setIdProgramacao($idProgramacao) {$this->idProgramacao = $idProgramacao;}   
    public function getIdProgramacao() {return $this->idProgramacao;}

    public function setDsProgramacao($dsProgramacao) {$this->dsProgramacao = $dsProgramacao;}   
    public function getDsProgramacao() {return $this->dsProgramacao;}

    public function setQtProgramacao($qtProgramacao) {$this->qtProgramacao = $qtProgramacao;}   
    public function getQtProgramacao() {return $this->qtProgramacao;}

    public function setInProgramacao($inProgramacao) {$this->inProgramacao = $inProgramacao;}   
    public function getInProgramacao() {return $this->inProgramacao;}

    public function setBkProgramacao($bkProgramacao) {$this->bkProgramacao = $bkProgramacao;}   
    public function getBkProgramacao() {return $this->bkProgramacao;}
   
    public function setDlcProgramacao($dlcProgramacao) {$this->dlcProgramacao = $dlcProgramacao;}   
    public function getDlcProgramacao() {return $this->dlcProgramacao;}

    public function setNvProgramacao($nvProgramacao) {$this->nvProgramacao = $nvProgramacao;}   
    public function getNvProgramacao() {return $this->nvProgramacao;}

    public function setDcProgramacao($dcProgramacao) {$this->dcProgramacao = $dcProgramacao;}   
    public function getDcProgramacao() {return $this->dcProgramacao;}

    public function setGrupoCliente($grupo_cliente) {$this->grupo_cliente[] = $grupo_cliente;}
    public function getGrupoCliente() {return $this->grupo_cliente[0];}

    public function setArmador($armador) {$this->armador[] = $armador;}
    public function getArmador() {return $this->armador[0];}

    public function setFuncionario($funcionario) {$this->funcionario[] = $funcionario;}
    public function getFuncionario() {return $this->funcionario[0];}

    public function setTerminal($terminal) {$this->terminal[] = $terminal;}
    public function getTerminal() {return $this->terminal[0];}

    public function setPorto($porto) {$this->porto[] = $porto;}
    public function getPorto() {return $this->porto[0];}

    public function setProduto($produto) {$this->produto[] = $produto;}
    public function getProduto() {return $this->produto[0];}

    public function setTipoContainer($tipo_container) {$this->tipo_container[] = $tipo_container;}
    public function getTipoContainer() {return $this->tipo_container[0];}
}
