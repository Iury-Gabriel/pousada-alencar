<?php
namespace src\models;
use \src\Config;
use PDO;

class Avaliacao {
    private $id;
    private $nota;
    private $comentario;
    private $quarto_id;
    private $cliente_id;

    public function __construct($nota, $comentario, $quarto_id, $cliente_id) {
        $this->nota = $nota;
        $this->comentario = $comentario;
        $this->quarto_id = $quarto_id;
        $this->cliente_id = $cliente_id;
    }

    public static function obterAvaliacoes() {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM avaliacoes");
        $sql->execute();
        $avaliacoes = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $avaliacoes;
    }

    public function inserirAvaliacao() {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("INSERT INTO avaliacoes (nota, comentario, quarto_id, cliente_id) VALUES (:nota, :comentario, :quarto_id, :cliente_id)");
        $sql->bindValue(':nota', $this->nota);
        $sql->bindValue(':comentario', $this->comentario);
        $sql->bindValue(':quarto_id', $this->quarto_id);
        $sql->bindValue(':cliente_id', $this->cliente_id);
        $sql->execute();
    }

    public static function deletarAvaliacao($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("DELETE FROM avaliacoes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function buscarAvaliacao($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM avaliacoes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        $avaliacao = $sql->fetch(PDO::FETCH_ASSOC);
        $this->id = $avaliacao['id'];
        $this->nota = $avaliacao['nota'];
        $this->comentario = $avaliacao['comentario'];
        $this->quarto_id = $avaliacao['quarto_id'];
        $this->cliente_id = $avaliacao['cliente_id'];
    }

    public static function atualizarAvaliacao($id, $nota, $comentario, $quarto_id, $cliente_id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("UPDATE avaliacoes SET nota = :nota, comentario = :comentario, quarto_id = :quarto_id, cliente_id = :cliente_id WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':nota', $nota);
        $sql->bindValue(':comentario', $comentario);
        $sql->bindValue(':quarto_id', $quarto_id);
        $sql->bindValue(':cliente_id', $cliente_id);
        $sql->execute();
    }

    public static function obterAvaliacao($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM avaliacoes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        $avaliacao = $sql->fetch(PDO::FETCH_ASSOC);
        return $avaliacao;
    }

    public function getId() {
        return $this->id;
    }

    public function getNota() {
        return $this->nota;
    }   

    public function getComentario() {
        return $this->comentario;
    }

    public function getQuartoId() {
        return $this->quarto_id;
    }

    public function getClienteId() {
        return $this->cliente_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNota($nota) {
        $this->nota = $nota;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    public function setQuartoId($quarto_id) {
        $this->quarto_id = $quarto_id;
    }

    public function setClienteId($cliente_id) {
        $this->cliente_id = $cliente_id;
    }
}