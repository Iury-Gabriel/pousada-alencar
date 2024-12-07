<?php
namespace src;

use PDO;

class Config {
    const BASE_DIR = '/pousada-alencar';

    const DB_DRIVER = 'mysql';
    const DB_HOST = 'localhost';
    const DB_DATABASE = 'pousadaalencar';
    CONST DB_USER = 'root';
    const DB_PASS = '';

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';

    public static function getPDO() {
        return new PDO(self::DB_DRIVER . ":dbname=" . self::DB_DATABASE . ";host=" . self::DB_HOST, self::DB_USER, self::DB_PASS);
    }
}