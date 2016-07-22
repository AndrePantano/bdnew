<?php

include "funcionario/funcionario_model.php";
include "estatus/estatus_model.php";
include "funcao/funcao_model.php";
include "armador/armador_model.php";
include "terminal/terminal_model.php";
include "cliente/cliente_model.php";
include "tipo_container/tipo_container_model.php";
include "porto/porto_model.php";
include "programacao/programacao_model.php";
include "produto/produto_model.php";
include "corredor/corredor_model.php";

class DBAL_Model {

    private $host;
    private $user;
    private $password;
    private $database;
    private $conexao;

    public function __construct() {

        //$this->host = "brdintermodal.mysql.dbaas.com.br";
        //$this->user = "brdintermodal";
        //$this->password = "br@do197";
        $this->database = "brdintermodal";

        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        //$this->database = "brado";
        
        $this->conexao = NULL;

        $this->conexao = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->user, $this->password, array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));
    }
    public function Delete($tabela, $coluna, $valor) {
        $consulta = "DELETE FROM " . $tabela . " WHERE " . $coluna . " = ".$valor;
        $this->conexao->query($consulta);
    }
    public function Update($tabela, $idCampo, $valores) {
        $str = "";

        foreach ($valores as $coluna => $valor) {
            $str .= " " . $coluna . " = '" . $valor . "',";
        }

        $string_query = rtrim($str, ',');
        $consulta = "UPDATE " . $tabela . " SET " . $string_query . " WHERE " . $idCampo;        
        
        echo $consulta ."<br/><br/>";

        $this->conexao->query($consulta);
    }
    public function Insert($tabela, $valores) {
        $str1 = "";
        $str2 = "";
        foreach ($valores as $coluna => $valor) {
            $str1 .= $coluna . ",";
            $str2 .= "'" . $valor . "',";
        }
        $string1 = rtrim($str1, ",");
        $string2 = rtrim($str2, ",");
        $consulta = " INSERT INTO " . $tabela . "(" . $string1 . ")VALUES(" . $string2 . ")";        
        $this->conexao->query($consulta);
        return $this->conexao->lastInsertId();
    }    
    public function Select($table, $order, $modelMain, $atributo,$where) {
        $consulta = "SELECT * FROM $table $where ORDER BY $order ASC";        
        $itens = $this->conexao->query($consulta);
        $rows = array();

        if(!is_null($atributo)){
            // incrementa um array de models main
            foreach ($itens as $indice => $item) {
                $rows[$indice] = new $modelMain($item);

                // para cada join, incrementa um array de model na model main
                for ($j = 0; $j < count($atributo[0]); $j++) {
                    $consulta = " SELECT * FROM ". $atributo[0][$j] . " WHERE ". $atributo[1][$j]." = " . $item[$atributo[1][$j]].";";
                    $subItens = $this->conexao->query($consulta);

                    foreach ($subItens as $subItem) {
                        $rows[$indice]->$atributo[3][$j](new $atributo[2][$j]($subItem));
                    }
                }
            }
        }else{
            // incrementa um array de models main
            foreach ($itens as $indice => $item) {
                $rows[$indice] = new $modelMain($item);                
            }
        }
        return $rows;
    }
    public function Query($query) { 
    // echo $query;       
        $resultado = $this->conexao->query($query);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function QueryNoReturn($query) {     
        $this->conexao->query($query);        
    }

}
