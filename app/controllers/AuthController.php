<?php

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function showRegisterForm() {
        $page_title = "Đăng ký tài khoản - Basketball4Life";
        $breadcrumbs = [['label' => 'Đăng ký', 'url' => null]];
        require '../resources/views/layouts/header.php';
        require '../resources/views/auth/register.php';
        require '../resources/views/layouts/footer.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showRegisterForm();
            return;
        }

        $errors = [];
        $this->userModel->name = $_POST['name'] ?? '';
        $this->userModel->email = $_POST['email'] ?? '';
        $this->userModel->password = $_POST['password'] ?? '';
        
        if (empty($this->userModel->name)) {
                $errors[] = 'Họ và tên là bắt buộc.';
            }
        if (empty($this->userModel->email) || !filter_var($this->userModel->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        }
        if (empty($this->userModel->password) || strlen($this->userModel->password) < 8) {
            $errors[] = 'Mật khẩu phải có ít nhất 8 ký tự.';
        }

        if (empty($errors)) {
            if ($this->userModel->create()) {
                header('Location: index.php?controller=auth&action=login&register_success=1');
                exit();
            } else {
                $errors[] = 'Email này đã được đăng ký.';
            }
        }
        
        require '../resources/views/layouts/header.php';
        require '../resources/views/auth/register.php';
        require '../resources/views/layouts/footer.php';
    }

    public function showLoginForm() {
        $page_title = "Đăng nhập - Basketball4Life";
        $breadcrumbs = [['label' => 'Đăng nhập', 'url' => null]];
        require '../resources/views/layouts/header.php';
        require '../resources/views/auth/login.php';
        require '../resources/views/layouts/footer.php';
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $breadcrumbs = [['label' => 'Đăng nhập', 'url' => null]];
            require '../resources/views/layouts/header.php';
            require '../resources/views/auth/login.php';
            require '../resources/views/layouts/footer.php';
            return;
        }
        
        $email = $_POST['email'] ?? '';
        $password_from_form = $_POST['password'] ?? '';
            
        if ($this->userModel->findByEmail($email)) {
            if (password_verify($password_from_form, $this->userModel->password)) {
                $_SESSION['user_id'] = $this->userModel->id;
                $_SESSION['user_email'] = $this->userModel->email;
                $_SESSION['user_name'] = $this->userModel->name;
                $_SESSION['user_role'] = $this->userModel->role;

                if ($this->userModel->role === 'admin') {
                    header('Location: index.php?area=admin&controller=product&action=manage');
                    exit();
                } else {
                    header('Location: index.php');
                    exit();
                }
            }
        }
        $error = 'Email hoặc mật khẩu không chính xác.';
        
        $breadcrumbs = [['label' => 'Đăng nhập', 'url' => null]];
        require '../resources/views/layouts/header.php';
        require '../resources/views/auth/login.php';
        require '../resources/views/layouts/footer.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}