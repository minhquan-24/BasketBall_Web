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

            $productModel = new Product($this->db);
            $product = $productModel->findById($product_id);

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

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $_SESSION['cart'][] = $cart_item;

            header("Location: index.php?controller=cart&action=index");
        }
    }

    public function index() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        
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
        if (empty($_POST['selected_items'])) {
            header("Location: index.php?controller=cart&action=index");
            exit();
        }

        $selected_indices = $_POST['selected_items'];
        $cart_session = $_SESSION['cart'] ?? [];
        
        $items_to_buy = [];
        
        foreach ($selected_indices as $index) {
            if (isset($cart_session[$index])) {
                $items_to_buy[] = $cart_session[$index];
            }
        }

        if (empty($items_to_buy)) {
            die("Lỗi: Không tìm thấy sản phẩm trong giỏ.");
        }

        $orderModel = new Order($this->db);
        $customer_info = [
            'fullname' => $_POST['fullname'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'note' => $_POST['note']
        ];

        $order_id = $orderModel->create($_SESSION['user_id'], $customer_info, $items_to_buy);

        if ($order_id) {
            foreach ($selected_indices as $index) {
                unset($_SESSION['cart'][$index]);
            }
            
            $_SESSION['cart'] = array_values($_SESSION['cart']);

            header("Location: index.php?controller=order&action=history&status=order_success");
            exit();
        } else {
            die("Lỗi tạo đơn hàng. Vui lòng thử lại.");
        }
    }
    }
    
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

    header("Location: index.php?controller=cart&action=index");
    exit();
}
}