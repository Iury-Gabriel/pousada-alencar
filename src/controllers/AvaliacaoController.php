<?php
namespace src\controllers;

use \core\Controller;
use src\Config;
use src\models\Avaliacao;

use function src\middlewares\isLogged;

class AvaliacaoController extends Controller {

    public function index() {
        $isLogged = isLogged();

        if ($isLogged) {
            $avaliacoes = Avaliacao::obterAvaliacoes();
            $this->render('avaliacoes', ['avaliacoes' => $avaliacoes]);
        } else {
            $this->redirect('/login');
        }
    }

    public function criarAvaliacao() {
        $isLogged = isLogged();

        if ($isLogged) {
            $nota = filter_input(INPUT_POST, 'nota', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $comentario = filter_input(INPUT_POST, 'comentario');
            $quarto_id = filter_input(INPUT_POST, 'quarto_id', FILTER_SANITIZE_NUMBER_INT);
            $cliente_id = filter_input(INPUT_POST, 'cliente_id', FILTER_SANITIZE_NUMBER_INT);

            $avaliacao = new Avaliacao(null, $nota, $comentario, $quarto_id, $cliente_id);
            $avaliacao->inserirAvaliacao();

            $this->redirect('/avaliacoes');
        } else {
            $this->redirect('/login');
        }
    }

    public function atualizarAvaliacao() {
        $isLogged = isLogged();

        if ($isLogged) {
            $avaliacaoId = filter_input(INPUT_POST, 'avaliacaoId', FILTER_SANITIZE_NUMBER_INT);
            $nota = filter_input(INPUT_POST, 'nota', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $comentario = filter_input(INPUT_POST, 'comentario');
            $quarto_id = filter_input(INPUT_POST, 'quarto_id', FILTER_SANITIZE_NUMBER_INT);
            $cliente_id = filter_input(INPUT_POST, 'cliente_id', FILTER_SANITIZE_NUMBER_INT);

            Avaliacao::atualizarAvaliacao($avaliacaoId, $nota, $comentario, $quarto_id, $cliente_id);
            $this->redirect('/avaliacoes');
        } else {
            $this->redirect('/login');
        }
    }

    public function deletarAvaliacao() {
        $isLogged = isLogged();

        if ($isLogged) {
            $avaliacaoId = filter_input(INPUT_POST, 'avaliacaoId', FILTER_SANITIZE_NUMBER_INT);
            Avaliacao::deletarAvaliacao($avaliacaoId);
            $this->redirect('/avaliacoes');
        } else {
            $this->redirect('/login');
        }
    }

    public function obterAvaliacao() {
        $isLogged = isLogged();

        if ($isLogged) {
            $avaliacaoId = filter_input(INPUT_GET, 'avaliacaoId', FILTER_SANITIZE_NUMBER_INT);
            $avaliacao = Avaliacao::obterAvaliacao($avaliacaoId);
            $this->render('avaliacao', ['avaliacao' => $avaliacao]);
        } else {
            $this->redirect('/login');
        }
    }
}
