<?php

session_start();

require_once '../app/core/Database.php';
require_once '../app/models/User.php';
require_once '../app/models/Product.php';
require_once '../app/models/Category.php';

$database = new Database();
$db = $database->getConnection();

// --- ROUTER THỐNG NHẤT ---
$area = $_GET['area'] ?? 'user';

if ($area === 'admin') {
    // ---- XỬ LÝ KHU VỰC ADMIN ----
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }
    
    $controller_name = $_GET['controller'] ?? 'product';
    $action_name = $_GET['action'] ?? 'manage';

    $controller_file = __DIR__ . '/../app/controllers/Admin/' . ucfirst($controller_name) . 'Controller.php';
    
} else {
    // ---- XỬ LÝ KHU VỰC USER ----
    $controller_name = $_GET['controller'] ?? 'pages';
    $action_name = $_GET['action'] ?? 'home';
    $controller_file = __DIR__ . '/../app/controllers/' . ucfirst($controller_name) . 'Controller.php';
}

// --- THỰC THI CONTROLLER ---
if (file_exists($controller_file)) {
    require_once $controller_file;
    $controller_class = ucfirst($controller_name) . 'Controller';

    if (class_exists($controller_class)) {
        $controller_instance = new $controller_class($db);
        if (method_exists($controller_instance, $action_name)) {
            $controller_instance->$action_name();
        } else { 
            die("Error: Action '{$action_name}' not found."); 
        }
    } else { 
        die("Error: Class '{$controller_class}' not found."); 
    }
} else { 
    die("Error: Controller file '{$controller_file}' not found."); 
}

?>