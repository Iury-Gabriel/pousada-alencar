<?php

namespace src\controllers;

use \core\Controller;
use \src\models\Cliente;

use Resend;

class UserController extends Controller
{

    public function index()
    {
        $this->render('login');
    }

    public function register()
    {
        $this->render('register');
    }

    public function registerAction()
    {
        $nome = filter_input(INPUT_POST, 'nome');
        $email = filter_input(INPUT_POST, 'email');
        $senha = filter_input(INPUT_POST, 'senha');

        if ($nome && $email && $senha) {
            $cliente = new Cliente($nome, $email, $senha);
            $cliente->inserirCliente();

            $this->redirect('/login');
        }
    }

    public function loginAction()
    {
        $email = filter_input(INPUT_POST, 'email');
        $senha = filter_input(INPUT_POST, 'senha');

        if ($email && $senha) {
            $cliente = Cliente::logarCliente($email, $senha);
            if ($cliente['error']) {
                $_SESSION['error'] = $cliente['error'];
                $this->redirect('/login');
            }
            $this->redirect('/');
        }
    }

    public function forgotPassword()
    {
        $this->render('forgot-password');
    }

    // Enviar o código de verificação para o e-mail
    public function sendVerificationCode()
    {
        $email = filter_input(INPUT_POST, 'email');

        if ($email) {
            $existsEmail = Cliente::getByEmail($email);
            if (!$existsEmail) {
                $_SESSION['error_message'] = 'E-mail nao cadastrado.';
                $this->redirect('/forgot-password');
                exit;
            }

            $verificationCode = rand(100000, 999999);
            $_SESSION['verification_code'] = $verificationCode;
            $_SESSION['verification_email'] = $email;

            try {
                $resend = Resend::client('re_G9KoWiUP_H739CNitB9Pyhtw1QBKYkBbf');
                $resend->emails->send([
                    'from' => 'Acme <onboarding@resend.dev>',
                    'to' => [$email],
                    'subject' => 'Código de Verificação',
                    'html' => 'Seu código de verificação é: ' . $verificationCode,
                ]);

                $_SESSION['email_sent'] = true;
                $_SESSION['error_message'] = '';
                $this->redirect('/forgot-password');
                exit;
            } catch (\Exception $e) {
                $_SESSION['error_message'] = 'Erro ao enviar o e-mail.';
                $this->redirect('/forgot-password');
                exit;
            }
        } else {
            $_SESSION['error_message'] = 'E-mail não fornecido.';
            $this->redirect('/forgot-password');
            exit;
        }
    }

    public function verifyCode() {
        $code = filter_input(INPUT_POST, 'code');
    
        if ($code && isset($_SESSION['verification_code']) && isset($_SESSION['verification_email'])) {
            if ($code == $_SESSION['verification_code']) {
                $_SESSION['code_verified'] = true;
                unset($_SESSION['verification_code']);
                $this->redirect('/forgot-password');
                exit;
            } else {
                $_SESSION['error_message'] = 'Código de verificação inválido.';
                $this->redirect('/forgot-password');
                exit;
            }
        } else {
            $_SESSION['error_message'] = 'Código não fornecido ou sessão expirada.';
            $this->redirect('/forgot-password');
            exit;
        }
    }

    public function resetPassword() {
        $newPassword = filter_input(INPUT_POST, 'new-password');
        $confirmPassword = filter_input(INPUT_POST, 'confirm-password');
    
        if ($newPassword && $confirmPassword) {
            if ($newPassword === $confirmPassword) {
                Cliente::resetarSenha($newPassword);
    
                session_unset();
                $_SESSION['success_message'] = 'Senha redefinida com sucesso!';
                $this->redirect('/login');
                exit;
            } else {
                $_SESSION['error_message'] = 'As senhas não coincidem.';
                $this->redirect('/forgot-password');
                exit;
            }
        } else {
            $_SESSION['error_message'] = 'Senha não fornecida.';
            $this->redirect('/forgot-password');
            exit;
        }
    }
    
    
}
