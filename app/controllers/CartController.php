<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';

class CartController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

   public function add(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $variant_id = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : null;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            // Lấy thông tin sản phẩm từ DB để lưu vào session (giá, tên, ảnh)
            $productModel = new Product($this->db);
            $product = $productModel->findById($product_id);

            // Tìm size text dựa vào variant_id (nếu cần chi tiết)
            $size_text = "Free Size";
            foreach($product['variants'] as $v) {
                if($v['id'] == $variant_id) $size_text = $v['size'];
            }

            $cart_item = [
                'product_id' => $product_id,
                'variant_id' => $variant_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => isset($product['images'][0]['image_url']) ? $product['images'][0]['image_url'] : '',
                'size' => $size_text,
                'quantity' => $quantity
            ];

            // Logic thêm vào session cart
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            // (Ở đây làm đơn giản: cứ thêm mới, bạn có thể code thêm check trùng ID để cộng dồn số lượng)
            $_SESSION['cart'][] = $cart_item;

            header("Location: index.php?controller=cart&action=index");
        }
    }

    public function index() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        
        // Tính tổng tiền
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $page_title = "Giỏ hàng của bạn (" . count($cart) . " sản phẩm)";

        require '../resources/views/layouts/header.php';
        require '../resources/views/cart/index.php';
        require '../resources/views/layouts/footer.php';
    }

    // Xử lý Checkout (Lưu vào DB)
    public function checkout() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Kiểm tra xem có sản phẩm nào được chọn không
        if (empty($_POST['selected_items'])) {
            // Nếu không chọn gì mà cố tình submit (trường hợp hiếm vì JS đã chặn)
            header("Location: index.php?controller=cart&action=index");
            exit();
        }

        $selected_indices = $_POST['selected_items']; // Mảng chứa index: [0, 2, ...]
        $cart_session = $_SESSION['cart'] ?? [];
        
        $items_to_buy = [];
        
        // Lọc ra các sản phẩm cần mua
        foreach ($selected_indices as $index) {
            if (isset($cart_session[$index])) {
                $items_to_buy[] = $cart_session[$index];
            }
        }

        if (empty($items_to_buy)) {
            die("Lỗi: Không tìm thấy sản phẩm trong giỏ.");
        }

        // Tạo đơn hàng
        $orderModel = new Order($this->db);
        $customer_info = [
            'fullname' => $_POST['fullname'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'note' => $_POST['note']
        ];

        $order_id = $orderModel->create($_SESSION['user_id'], $customer_info, $items_to_buy);

        if ($order_id) {
            // ---- QUAN TRỌNG: CHỈ XÓA NHỮNG MÓN ĐÃ MUA KHỎI SESSION ----
            
            // Duyệt qua danh sách index đã chọn và unset khỏi session gốc
            foreach ($selected_indices as $index) {
                unset($_SESSION['cart'][$index]);
            }
            
            // Sắp xếp lại mảng giỏ hàng để không bị lủng lỗ index
            $_SESSION['cart'] = array_values($_SESSION['cart']);

            // Chuyển hướng thành công
            header("Location: index.php?controller=order&action=history&status=order_success");
            exit();
        } else {
            die("Lỗi tạo đơn hàng. Vui lòng thử lại.");
        }
    }
    }
    
    // Xóa giỏ hàng
    public function clear() {
        unset($_SESSION['cart']);
        header("Location: index.php?controller=cart&action=index");
    }

    public function remove() {
    $index = isset($_GET['index']) ? (int)$_GET['index'] : -1;

    if ($index >= 0 && isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    // Quay lại trang giỏ hàng
    header("Location: index.php?controller=cart&action=index");
    exit();
}
}