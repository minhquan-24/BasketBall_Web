<?php

class Database {
    private static $pdo;

    
    public static function getConnection() {
        if (!isset(self::$pdo)) {
            require_once __DIR__ . '/../../config/database.php';
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die('Không thể kết nối CSDL: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}