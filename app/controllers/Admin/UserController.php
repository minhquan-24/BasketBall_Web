<?php

class UserController{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }

    public function index(){
        $page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
        $records_per_page = 10; // Số user mỗi trang
        $from_record_num = ($records_per_page * $page_num) - $records_per_page;

        $userModel = new User($this->db);
    
    // Lấy dữ liệu phân trang thay vì readAll()
        $stmt = $userModel->readPaging($from_record_num, $records_per_page);
        $total_rows = $userModel->count();
        $breadcrumbs = [['label' => 'Quản lý người dùng', 'url' => null]];
    
        $page_title = "Quản lý Người dùng / Khách hàng";
        
        require '../resources/views/layouts/header.php';
        require '../resources/views/users/manage.php';
        require '../resources/views/layouts/footer.php';
    }
    public function delete(){
        $userModel = new User($this->db);
        $userModel->id = isset($_GET['id']) ? $_GET['id'] : die('Error: missing the ID');

        if (isset($_SESSION['user_id']) && $userModel->id == $_SESSION['user_id']) {
            header("Location: index.php?area=admin&controller=user&action=index&status=delete_self_failed");
            exit();
        }
        if($userModel->delete()){
            header("Location: index.php?area=admin&controller=user&action=index&status=delete_success");
            exit();
        }else{
            header("Location: index.php?area=admin&controller=user&action=index&status=delete_failed");
            exit();
        }
    }
}
