<?php

class Database {
    // Biến static để lưu trữ kết nối duy nhất
    private static $pdo;

    /**
     * Phương thức này tạo và trả về một đối tượng kết nối PDO.
     * Nó đảm bảo rằng chỉ có một kết nối được tạo ra trong suốt quá trình chạy.
     * @return PDO Đối tượng kết nối database.
     */
    public static function getConnection() {
        if (!isset(self::$pdo)) {
            // Nạp thông tin cấu hình từ file database.php
            require_once __DIR__ . '/../../config/database.php';
            try {
                // Chuỗi DSN (Data Source Name) để kết nối
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
                // Tạo đối tượng PDO mới
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS);
                // Cài đặt các thuộc tính cho PDO để tăng cường bảo mật và báo lỗi
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die('Không thể kết nối CSDL: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}