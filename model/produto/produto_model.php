<?php

class Produto_Model {

    private $idProduto;
    private $nmProduto;

    public function __construct($dados) {
        $this->setIdProduto($dados["idProduto"]);
        $this->setNmProduto($dados["nmProduto"]);
    }

    // sets da classe
    public function setIdProduto($idProduto) {$this->idProduto = $idProduto;}
    public function setNmProduto($Produto) {$this->nmProduto = $Produto;}

    // gets da classe
    public function getIdProduto() {return $this->idProduto;}
    public function getNmProduto() {return ucwords($this->nmProduto);}
}
