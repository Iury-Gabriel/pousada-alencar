<?php
namespace src\models;
use \src\Config;
use PDO;

class Pagamento {
    private $id;
    private $reservas_id;
    private $cliente_id;
    private $status_pagamento;
    private $data_pagamento;
    private $valor_pago;
    private $metodo_pagamento;

    public function __construct($id, $reservas_id, $cliente_id, $status_pagamento, $data_pagamento, $valor_pago, $metodo_pagamento) {
        $this->id = $id;
        $this->reservas_id = $reservas_id;
        $this->cliente_id = $cliente_id;
        $this->status_pagamento = $status_pagamento;
        $this->data_pagamento = $data_pagamento;
        $this->valor_pago = $valor_pago;
        $this->metodo_pagamento = $metodo_pagamento;
    } 

    public function inserirPagamento() {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("INSERT INTO pagamentos (reservas_id, cliente_id, status_pagamento, data_pagamento, valor_pago, metodo_pagamento) VALUES (:reservas_id, :cliente_id, :status_pagamento, :data_pagamento, :valor_pago, :metodo_pagamento)");
        $sql->bindValue(':reservas_id', $this->reservas_id);
        $sql->bindValue(':cliente_id', $this->cliente_id);
        $sql->bindValue(':status_pagamento', $this->status_pagamento);
        $sql->bindValue(':data_pagamento', $this->data_pagamento);
        $sql->bindValue(':valor_pago', $this->valor_pago);
        $sql->bindValue(':metodo_pagamento', $this->metodo_pagamento);
        $sql->execute();
    }

    public function obterPagamento($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM pagamentos WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function obterPagamentos() {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM pagamentos");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletarPagamento($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("DELETE FROM pagamentos WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function atualizarPagamento($id, $reservas_id, $cliente_id, $status_pagamento, $data_pagamento, $valor_pago, $metodo_pagamento) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("UPDATE pagamentos SET (reservas_id, cliente_id, status_pagamento, data_pagamento, valor_pago, metodo_pagamento) VALUES (:reservas_id, :cliente_id, :status_pagamento, :data_pagamento, :valor_pago, :metodo_pagamento) WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':reservas_id', $reservas_id);
        $sql->bindValue(':cliente_id', $cliente_id);
        $sql->bindValue(':status_pagamento', $status_pagamento);    
        $sql->bindValue(':data_pagamento', $data_pagamento);
        $sql->bindValue(':valor_pago', $valor_pago);
        $sql->bindValue(':metodo_pagamento', $metodo_pagamento);
        $sql->execute();
    }

    public function atualizarStatusPagamento($id, $status_pagamento) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("UPDATE pagamentos SET status_pagamento = :status_pagamento WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':status_pagamento', $status_pagamento);
        $sql->execute();
    }

    

    public function getId() {
        return $this->id;
    }

    public function getReservasId() {
        return $this->reservas_id;
    }

    public function getClienteId() {
        return $this->cliente_id;
    }

    public function getStatusPagamento() {
        return $this->status_pagamento;
    }

    public function getDataPagamento() {
        return $this->data_pagamento;
    }

    public function getValorPago() {
        return $this->valor_pago;
    }

    public function getMetodoPagamento() {
        return $this->metodo_pagamento;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setReservasId($reservas_id) {
        $this->reservas_id = $reservas_id;
    }

    public function setClienteId($cliente_id) {
        $this->cliente_id = $cliente_id;
    }

    public function setStatusPagamento($status_pagamento) {
        $this->status_pagamento = $status_pagamento;
    }

    public function setDataPagamento($data_pagamento) {
        $this->data_pagamento = $data_pagamento;
    }

    public function setValorPago($valor_pago) {
        $this->valor_pago = $valor_pago;
    }

    public function setMetodoPagamento($metodo_pagamento) {
        $this->metodo_pagamento = $metodo_pagamento;
    }

    
}