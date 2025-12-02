<?php
require_once __DIR__ . '/../models/User.php';

class ProfileController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    public function index() {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        // 2. Lấy thông tin user dựa trên ID trong session
        $this->userModel->id = $_SESSION['user_id'];
        
        if ($this->userModel->readOne()) {
            // Lấy dữ liệu thành công
            $user = $this->userModel; // Đối tượng user giờ đã chứa data (name, email, role...)
            
            // Setup SEO
            $page_title = "Hồ sơ cá nhân - " . htmlspecialchars($user->name);
            
            require '../resources/views/layouts/header.php';
            require '../resources/views/profile/index.php';
            require '../resources/views/layouts/footer.php';
        } else {
            // Không tìm thấy user (trường hợp hiếm, ví dụ bị xóa DB khi đang login)
            session_destroy();
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }
}
?>