<?php
// session_start();

// require_once '../app/core/Database.php';
// require_once '../app/models/User.php';
// require_once '../app/models/Product.php';
// require_once '../app/models/Category.php';

// $database = new Database();
// $db = $database->getConnection();

// // 2. Khởi tạo các đối tượng model, "tiêm" kết nối DB vào
// $product = new Product($db);
// $user = new User($db);
// $category = new Category($db);

// $page = $_GET['page'] ?? 'home';

// switch ($page) {
//     case 'products':
//         $page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
//         $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
//         $sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at_desc';
//         $records_per_page = 10;
//         $from_record_num = ($records_per_page * $page_num) - $records_per_page;
//         $stmt = $product->readPaging($from_record_num, $records_per_page, $category_id, $sort);
//         $num = $stmt->rowCount();
//         $total_rows = $product->count($category_id);
//         break;

//     case 'register':
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $user->name = $_POST['name'] ?? '';
//             $user->email = $_POST['email'] ?? '';
//             $user->password = $_POST['password'] ?? '';

//             if (empty($user->name)) {
//                 $errors[] = 'Họ và tên là bắt buộc.';
//             }
//             if (empty($user->email) || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
//                 $errors[] = 'Email không hợp lệ.';
//             }
//             if (empty($user->password) || strlen($user->password) < 8) {
//                 $errors[] = 'Mật khẩu phải có ít nhất 8 ký tự.';
//             }

//             if (empty($errors)) {
//                 if ($user->create()) {
//                     // LỆNH HEADER() ĐƯỢC GỌI Ở ĐÂY, TRƯỚC KHI CÓ BẤT KỲ HTML NÀO
//                     header('Location: index.php?page=login&register_success=1');
//                     exit(); // Luôn exit() sau khi chuyển hướng
//                 } else {
//                     $errors[] = 'Email này đã được đăng ký.';
//                 }
//             }
//         }
//         break;

//     case 'login':
//         if (isset($_SESSION['user_id'])) {
//             header('Location: index.php');
//             exit();
//         }
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $email = $_POST['email'] ?? '';
//             $password_from_form = $_POST['password'] ?? '';
            
//             if ($user->findByEmail($email)) {
//                 if (password_verify($password_from_form, $user->password)) {
//                     $_SESSION['user_id'] = $user->id;
//                     $_SESSION['user_email'] = $user->email;
//                     $_SESSION['user_name'] = $user->name; // Lấy name từ đối tượng user
//                     $_SESSION['user_role'] = $user->role;
//                     header('Location: index.php');
//                     exit();
//                 }
//             }
//             $error = 'Email hoặc mật khẩu không chính xác.';
//         }
//         break;
    
//     case 'logout':
//         session_unset();
//         session_destroy();
//         header("Location: index.php");
//         exit();
//         break;
// }

// // --- PHẦN 2: HIỂN THỊ GIAO DIỆN (VIEW) ---

// require '../resources/views/layouts/header.php';

// switch ($page) {
//     case 'products':
//         require '../resources/views/products/index.php';
//         break;
//     case 'register':
//         require '../resources/views/auth/register.php';
//         break;
//     case 'login':
//         require '../resources/views/auth/login.php';
//         break;

//     default:
//         require '../resources/views/home.php';
//         break;
// }

// require '../resources/views/layouts/footer.php';

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