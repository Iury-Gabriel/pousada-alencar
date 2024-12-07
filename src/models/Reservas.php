<?php
namespace src\models;

use \src\Config;
use PDO;

class Reservas {
    private $id;
    private $cliente_id;
    private $quarto_id;
    private $data_checkin;
    private $status_reserva;
    private $valortotal;
    private $data_reserva;
    private $data_final;


    public function __construct($cliente_id, $quarto_id, $data_checkin, $status_reserva, $valortotal, $data_reserva, $data_final) {
        $this->cliente_id = $cliente_id;
        $this->quarto_id = $quarto_id;
        $this->data_checkin = $data_checkin;
        $this->status_reserva = $status_reserva;
        $this->valortotal = $valortotal;
        $this->data_reserva = $data_reserva;
        $this->data_final = $data_final;
    }

    public static function pegarReservas(){
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM reservas");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function atualizarReserva($id, $quarto_id, $data_checkin, $data_reserva){
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("UPDATE reservas SET quarto_id = :quarto_id, data_checkin = :data_checkin, data_reserva = :data_reserva WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':quarto_id',$quarto_id);
        $sql->bindValue(':data_checkin',$data_checkin);
        $sql->bindValue(':data_reserva',$data_reserva);
        $sql->execute();
    }

    public function inserirReserva(){
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("INSERT INTO reservas (cliente_id, quarto_id, data_checkin, status_reserva, valortotal, data_reserva, data_final) VALUES (:cliente_id, :quarto_id, :data_checkin, :status_reserva, :valortotal, :data_reserva, :data_final)");
        $sql->bindValue(':cliente_id', $this->cliente_id);
        $sql->bindValue(':quarto_id', $this->quarto_id);
        $sql->bindValue(':data_checkin', $this->data_checkin);
        $sql->bindValue(':status_reserva', $this->status_reserva);
        $sql->bindValue(':valortotal', $this->valortotal);
        $sql->bindValue(':data_reserva', $this->data_reserva);
        $sql->bindValue(':data_final', $this->data_final);
        $sql->execute();
        $this->id = $pdo->lastInsertId();
    }

    public static function deletarReserva ($id){
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("DELETE FROM reservas WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function buscarReserva($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM reservas WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        $reserva = $sql->fetch(PDO::FETCH_ASSOC);
        $this->id = $reserva['id'];
        $this->setClienteId($reserva['cliente_id']);
        $this->setQuartoId($reserva['quarto_id']);
        $this->setDataCheckin($reserva['data_checkin']);
        $this->setStatusReserva($reserva['status_reserva']);
        $this->setValorTotal($reserva['valortotal']);
        $this->setDataReserva($reserva['data_reserva']);
    }

    public static function pegarReservasPorCliente($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM reservas WHERE cliente_id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function verificarDisponibilidadePorTipo($tipo_quarto, $tipo, $data_reserva, $data_final) {
        $pdo = Config::getPDO();
    
        // Query base para buscar todos os quartos disponíveis do tipo selecionado
        if ($tipo_quarto === 'premium' || $tipo_quarto === 'premiumfamilia') {
            // Se for "suite premium" ou "premium familia", não filtramos pelo tipo (individual, duplo, etc.)
            $sql = $pdo->prepare("SELECT id FROM quartos WHERE tipo_quarto = :tipo_quarto");
        } else if ($tipo_quarto === 'executiva') {
            // Se for "suite executiva", só permite "individual" e "duplo"
            $sql = $pdo->prepare("SELECT id FROM quartos WHERE tipo_quarto = :tipo_quarto AND tipo IN ('individual', 'duplo')");
        } else {
            // Para "standard" e outros tipos, filtramos conforme o tipo fornecido
            $sql = $pdo->prepare("SELECT id FROM quartos WHERE tipo_quarto = :tipo_quarto AND tipo = :tipo");
            $sql->bindValue(':tipo', $tipo);
        }
    
        $sql->bindValue(':tipo_quarto', $tipo_quarto);
        $sql->execute();
    
        $quartos = $sql->fetchAll(PDO::FETCH_ASSOC);
    
        // Percorra cada quarto e verifique a disponibilidade
        foreach ($quartos as $quarto) {
            $quartoId = $quarto['id'];
    
            // Verificar se o quarto está disponível no intervalo de datas
            $sqlCheck = $pdo->prepare("
                SELECT COUNT(*) as total 
                FROM reservas 
                WHERE quarto_id = :quarto_id 
                AND (
                    (:data_reserva BETWEEN data_reserva AND data_final) 
                    OR (:data_final BETWEEN data_reserva AND data_final) 
                    OR (data_reserva BETWEEN :data_reserva AND :data_final)
                )
                AND (status_reserva = 'pendente' OR status_reserva = 'reservada' OR status_reserva = 'confirmada')
            ");
    
            $sqlCheck->bindValue(':quarto_id', $quartoId);
            $sqlCheck->bindValue(':data_reserva', $data_reserva);
            $sqlCheck->bindValue(':data_final', $data_final);
            $sqlCheck->execute();
    
            $result = $sqlCheck->fetch(PDO::FETCH_ASSOC);
    
            // Se o total for 0, significa que o quarto está disponível
            if ($result['total'] == 0) {
                return $quartoId; // Retorne o ID do quarto disponível
            }
        }
    
        // Se nenhum quarto estiver disponível, retorne null
        return null;
    }
    
    
    

    public function getId() {
        return $this->id;
    }

    public function getClienteId() {
        return $this->cliente_id;
    }

    public function getQuartoId() {
        return $this->quarto_id;
    }

    public function getDataCheckin() {
        return $this->data_checkin;
    }

    public function getStatusReserva() {
        return $this->status_reserva;
    }   

    public function getValortotal() {
        return $this->valortotal;
    }

    public function getDataReserva() {
        return $this->data_reserva;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setClienteId($cliente_id) {
        $this->cliente_id = $cliente_id;
    }

    public function setQuartoId($quarto_id) {
        $this->quarto_id = $quarto_id;
    }

    public function setDataCheckin($data_checkin) {
        $this->data_checkin = $data_checkin;
    }

    public function setStatusReserva($status_reserva) {
        $this->status_reserva = $status_reserva;
    }

    public function setValortotal($valortotal) {
        $this->valortotal = $valortotal;
    }

    public function setDataReserva($data_reserva) {
        $this->data_reserva = $data_reserva;
    }
}
