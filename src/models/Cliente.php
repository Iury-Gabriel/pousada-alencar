<?php
namespace src\models;

use Exception;
use \src\Config;
use \PDO;

class Cliente {
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __construct($nome, $email, $senha) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function obterClientes() {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM clientes");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByEmail($email) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM clientes WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function inserirCliente() {
        $pdo = Config::getPDO();
        
        $sql = $pdo->prepare("SELECT * FROM clientes WHERE email = :email");
        $sql->bindValue(':email', $this->email);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            return 'E-mail já cadastrado.';
        }
    
        $sql = $pdo->prepare("INSERT INTO clientes (nome, email, senha) VALUES (:nome, :email, :senha)");
        $sql->bindValue(':nome', $this->nome);
        $sql->bindValue(':email', $this->email);
        $sql->bindValue(':senha', password_hash($this->senha, PASSWORD_DEFAULT));
        $sql->execute();
        $this->setId($pdo->lastInsertId());
    }
    

    public static function logarCliente($email, $senha) {
        $pdo = Config::getPDO();
    
        $sql = $pdo->prepare("SELECT * FROM clientes WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();
    
        if ($sql->rowCount() === 0) {
            return ['error' => 'E-mail ou senha incorretos.'];
        }
    
        $cliente = $sql->fetch(PDO::FETCH_ASSOC);
    
        if (!password_verify($senha, $cliente['senha'])) {
            return ['error' => 'E-mail ou senha incorretos.'];
        }

        return ['success' => $cliente];
    }
    

    public function atualizarCliente($id, $nome, $email, $senha) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("UPDATE clientes SET nome = :nome, email = :email, senha = :senha WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':senha', $senha);
        $sql->execute();
    }

    public function deletarCliente($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("DELETE FROM clientes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function buscarCliente($id) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        $cliente = $sql->fetch(PDO::FETCH_ASSOC);
        $this->id = $cliente['id'];
        $this->nome = $cliente['nome'];
        $this->email = $cliente['email'];
        $this->senha = $cliente['senha'];
    }

    public static function resetarSenha($password) {
        $pdo = Config::getPDO();
        $sql = $pdo->prepare("UPDATE clientes SET senha = :password");
        $sql->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $sql->execute();

    } 

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }
}