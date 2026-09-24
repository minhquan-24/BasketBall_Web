<?php

class PagesController {
    private $db;
    private $productModel;

    public function __construct($db = null) {
        $this->db = $db;
        if ($this->db) {
            require_once __DIR__ . '/../models/Product.php';
            $this->productModel = new Product($this->db);
        }
    }

    public function home() {
        $page_title = "Trang chủ - Basketball4Life | Chinh Phục Mọi Sân Đấu";
        $meta_desc = "Chuyên cung cấp giày bóng rổ Nike, Jordan, Adidas chính hãng tại Việt Nam. Mẫu mới nhất, giá tốt nhất.";
        
        $featured_products = [];
        if ($this->productModel) {
            try {
                $stmt = $this->productModel->readPaging(0, 8, null, 'created_at_desc');
                $featured_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                $featured_products = [];
            }
        }

        require '../resources/views/layouts/header.php';
        require '../resources/views/home.php';
        require '../resources/views/layouts/footer.php';
    }

    public function error() {
        echo "<h1>404 Not Found</h1>";
    }
}