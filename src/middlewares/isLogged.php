<?php

namespace src\middlewares;

use src\Config;

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