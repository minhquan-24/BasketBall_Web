<?php

class PagesController {
    public function home() {
        $page_title = "Trang chủ - Basketball4Life";
        $meta_desc = "Chuyên cung cấp giày bóng rổ Nike, Jordan, Adidas chính hãng tại Việt Nam. Mẫu mới nhất, giá tốt nhất.";
        
        require '../resources/views/layouts/header.php';
        require '../resources/views/home.php';
        require '../resources/views/layouts/footer.php';
    }

    public function error() {
        echo "<h1>404 Not Found</h1>";
    }
}