<?php
namespace src\controllers;

use \core\Controller;
use DateTime;
use src\Config;
use \src\models\Reservas;

class ReservaController extends Controller {

    public function isLogged() {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM clientes WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();
    
            if ($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function index() {
        $isLogged = $this->isLogged();

        if($isLogged) {
            $reservas = Reservas::pegarReservasPorCliente($_SESSION['id']);
            $this->render('reservas2', ['reservas' => $reservas]);
        } else {
            $this->redirect('/login');
        }
    }

    public function reservas() {
        $isLogged = $this->isLogged();

        if(!$isLogged) {
            $reservas = Reservas::pegarReservas();
            $this->render('reservas', ['reservas' => $reservas]);
        } else {
            $this->redirect('/login');
        }
    }

    public function reservar() {
        $this->render('reservar');
    }

    public function reservarQuarto() {
        $isLogged = $this->isLogged();
    
        if (!$isLogged) {
            $tipoQuarto = filter_input(INPUT_POST, 'tipoQuarto');
            $tipo = filter_input(INPUT_POST, 'tipo');
            $dataReserva = filter_input(INPUT_POST, 'dataReserva');
            $dataCheckin = filter_input(INPUT_POST, 'dataCheckin');
            $dataFinal = filter_input(INPUT_POST, 'dataFinal');

            if(!$tipoQuarto || !$dataReserva || !$dataCheckin || !$dataFinal) {
                $this->redirect('/reservar');
            }
    
            // Calcular a quantidade de dias entre dataReserva e dataFinal
            $dataReservaDate = new DateTime($dataReserva);
            $dataFinalDate = new DateTime($dataFinal);
            $dias = $dataReservaDate->diff($dataFinalDate)->days; // Número de dias
    
            // Preços das diárias
            $precosDiarias = [
                'standard' => [
                    'individual' => 100.00,
                    'duplo' => 130.00,
                    'triplo' => 195.00,
                    'quadruplo' => 250.00,
                ],
                'executiva' => [
                    'individual' => 120.00,
                    'duplo' => 140.00,
                ],
                'premium' => [
                    'default' => 195.00,
                ],
                'premiumfamilia' => [
                    'default' => 250.00,
                ],
            ];
    
            // Determinar o preço por diária com base no tipo de quarto e configuração
            if (isset($precosDiarias[$tipoQuarto][$tipo])) {
                $valorDiaria = $precosDiarias[$tipoQuarto][$tipo];
            } else if (isset($precosDiarias[$tipoQuarto]['default'])) {
                $valorDiaria = $precosDiarias[$tipoQuarto]['default'];
            } else {
                // Se o tipo de quarto não for encontrado
                $this->render('erro', ['mensagem' => "Tipo de quarto ou configuração inválida."]);
                exit;
            }
    
            // Calcular o valor total
            $valorTotal = $valorDiaria * $dias;
    
            // Verifique a disponibilidade para o tipo de quarto e tipo de configuração
            $quartoId = Reservas::verificarDisponibilidadePorTipo($tipoQuarto, $tipo, $dataReserva, $dataFinal);
    
            if ($quartoId === null) {
                // Se nenhum quarto estiver disponível, redirecione ou exiba uma mensagem
                echo "Quarto indisponível";
                $this->render('erro', ['mensagem' => "Nenhum quarto do tipo $tipoQuarto com a configuração $tipo está disponível para as datas selecionadas."]);
                exit;
            }
    
            // Se um quarto estiver disponível, continue com a reserva
            $reservas = new Reservas(1, $quartoId, $dataCheckin, 'pendente', $valorTotal, $dataReserva, $dataFinal);
            $reservas->inserirReserva();
            $this->redirect('/minhasreservas');
        } else {
            $this->redirect('/login');
        }
    }    

    public function minhasReservas() {
        $isLogged = $this->isLogged();
        $id = 1;

        if(!$isLogged) {
            $minhasReservas = Reservas::pegarReservasPorCliente($id);
            $this->render('minhasreservas', ['minhasReservas' => $minhasReservas]);
        } else {
            $this->redirect('/login');
        }
    }
    

    public function atualizarReserva() {
        $isLogged = $this->isLogged();
        $userId = $_SESSION['id'];

        if($isLogged) {
            $reservaId = filter_input(INPUT_POST, 'reservaId');
            $quartoId = filter_input(INPUT_POST, 'quartoId');
            $dataCheckin = filter_input(INPUT_POST, 'dataCheckin');
            $dataReserva = filter_input(INPUT_POST, 'dataReserva');

            Reservas::atualizarReserva($reservaId, $quartoId, $dataCheckin, $dataReserva);
            $this->redirect('/reservas');
        } else {
            $this->redirect('/login');
        }
    }

    public function deletarReserva() {
        $isLogged = $this->isLogged();
        $userId = $_SESSION['id'];

        if($isLogged) {
            $reservaId = filter_input(INPUT_POST, 'reservaId');
            Reservas::deletarReserva($reservaId);
            $this->redirect('/reservas');
        } else {
            $this->redirect('/login');
        }
    }
}