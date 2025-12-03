<?php

class ContactController {
    public function index() {
        $page_title = "Liên hệ - Basketball4Life";
        $meta_desc = "Liên hệ với Basketball4Life. Địa chỉ: 20 Lý Tự Trọng, Quận 1, TPHCM. Hotline: 0908234567.";

        $breadcrumbs = [
            ['label' => 'Liên hệ', 'url' => null]
        ];

        require '../resources/views/layouts/header.php';
        require '../resources/views/contact/index.php';
        require '../resources/views/layouts/footer.php';
    }
}
?>