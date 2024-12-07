<?php
namespace src\models;
use \src\Config;
use PDO;

class Quarto {
    private $id;
    private $numero;
    private $tipo;
    private $tipo_quarto;
    private $preco;
    private $status;
    private $descricao;

    public function __construct($numero, $tipo, $tipo_quarto, $preco, $status, $descricao){
        $this->numero = $numero;
        $this->tipo = $tipo;
        $this->tipo_quarto = $tipo_quarto;
        $this->preco = $preco;
        $this->status = $status;
        $this->descricao = $descricao;
    }

    public static function obterQuartos() {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM quartos");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserirQuarto() {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("INSERT INTO quartos (numero, tipo, tipo_quarto, preco, status, descricao) VALUES (:numero, :tipo, :preco, :status, :descricao)");
        $sql->bindValue(':numero', $this->numero);
        $sql->bindValue(':tipo', $this->tipo);
        $sql->bindValue(':tipo_quarto', $this->tipo_quarto);
        $sql->bindValue(':preco', $this->preco);
        $sql->bindValue(':status', $this->status);
        $sql->bindValue(':descricao', $this->descricao);
        $sql->execute();
        $this->setId($pdo->lastInsertId());
    }

    public static function atualizarQuarto($id, $tipo, $tipo_quarto, $preco, $status, $descricao) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("UPDATE quartos SET tipo = :tipo, tipo_quarto = :tipo_quarto, preco = :preco, status = :status, descricao = :descricao WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':tipo', $tipo);
        $sql->bindValue(':tipo_quarto', $tipo_quarto);
        $sql->bindValue(':preco', $preco);
        $sql->bindValue(':status', $status);
        $sql->bindValue(':descricao', $descricao);
        $sql->execute();
    }

    public function buscarQuarto($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM quartos WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        $quarto = $sql->fetch(PDO::FETCH_ASSOC);
        $this->id = $quarto['id'];
        $this->numero = $quarto['numero'];
        $this->tipo = $quarto['tipo'];
        $this->preco = $quarto['preco'];
        $this->status = $quarto['status'];
        $this->descricao = $quarto['descricao'];
    }

    public static function deletarQuarto($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("DELETE FROM quartos WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function getId(){
        return $this->id;
    }

    public function getNumero(){
        return $this->numero;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getPreco(){
        return $this->preco;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setNumero($numero){
        $this->numero = $numero;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function setPreco($preco){
        $this->preco = $preco;
    }


    public function setStatus($status){
        $this->status = $status;
    }

    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }
}

