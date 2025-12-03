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
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $this->userModel->id = $_SESSION['user_id'];
        
        if ($this->userModel->readOne()) {
            $user = $this->userModel;
            
            $page_title = "Hồ sơ cá nhân - " . htmlspecialchars($user->name);
            
            require '../resources/views/layouts/header.php';
            require '../resources/views/profile/index.php';
            require '../resources/views/layouts/footer.php';
        } else {
            session_destroy();
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }
}
?>