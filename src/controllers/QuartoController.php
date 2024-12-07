<?php
namespace src\controllers;

use \core\Controller;
use src\Config;
use src\models\Quarto;

function isLogged() {
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


class QuartoController extends Controller {

    public function index() {
        $isLogged = isLogged();

        if($isLogged) {
            $quartos = Quarto::obterQuartos();
            $this->render('quartos', ['quartos' => $quartos]);
        } else {
            $this->redirect('/login');
        }
    }

    public function criarQuarto() {
        $isLogged = isLogged();

        if($isLogged) {
            $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
            $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
            $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);

            $quarto = new Quarto($numero, $tipo, $preco, $status, $descricao);
            $quarto->inserirQuarto();

            $this->redirect('/quartos');
        } else {
            $this->redirect('/login');
        }
    }

    public function atualizarQuarto() {
        $isLogged = isLogged();

        if($isLogged) {
            $quartoId = filter_input(INPUT_POST, 'quartoId', FILTER_SANITIZE_NUMBER_INT);
            $tipo = filter_input(INPUT_POST, 'tipo');
            $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $status = filter_input(INPUT_POST, 'status');
            $descricao = filter_input(INPUT_POST, 'descricao');

            Quarto::atualizarQuarto($quartoId, $tipo, $preco, $status, $descricao);
            $this->redirect('/quartos');
        } else {
            $this->redirect('/login');
        }
    }

    public function quartos() {
        $this->render('quartos');
    }

    public function deletarQuarto() {
        $isLogged = isLogged();

        if($isLogged) {
            $quartoId = filter_input(INPUT_POST, 'quartoId', FILTER_SANITIZE_NUMBER_INT);
            Quarto::deletarQuarto($quartoId);
            $this->redirect('/quartos');
        } else {
            $this->redirect('/login');
        }
    }
}
