<?php
require_once __DIR__ . '/../models/Order.php';

class OrderController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    // Xem lịch sử đơn hàng của tôi
    public function history() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $orderModel = new Order($this->db);
        $orders = $orderModel->getUserOrders($_SESSION['user_id'])->fetchAll(PDO::FETCH_ASSOC);

        $page_title = "Lịch sử mua hàng - Đơn hàng của tôi";

        require '../resources/views/layouts/header.php';
        require '../resources/views/orders/history.php'; // View này tạo ở bước sau
        require '../resources/views/layouts/footer.php';
    }
    
    // Xem chi tiết 1 đơn hàng
    public function detail() {
         if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
         
         $id = $_GET['id'] ?? 0;
         $orderModel = new Order($this->db);
         $order = $orderModel->getOrderDetail($id);
         
         // Bảo mật: Không cho xem đơn của người khác
         if(!$order || $order['user_id'] != $_SESSION['user_id']) {
             die("Không tìm thấy đơn hàng hoặc bạn không có quyền xem.");
         }

         $page_title = "Chi tiết đơn hàng #" . $order['id'];
         
         require '../resources/views/layouts/header.php';
         require '../resources/views/orders/detail.php'; 
         require '../resources/views/layouts/footer.php';
    }
    public function cancel() {
    if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
    
    $order_id = $_GET['id'] ?? 0;
    $orderModel = new Order($this->db);
    
    // Kiểm tra xem đơn hàng có phải của User này không
    $order = $orderModel->getOrderDetail($order_id);
    if ($order && $order['user_id'] == $_SESSION['user_id']) {
        if ($orderModel->cancelOrder($order_id)) {
            header("Location: index.php?controller=order&action=history&status=cancel_success");
        } else {
            header("Location: index.php?controller=order&action=history&status=cancel_failed");
        }
    } else {
        die("Bạn không có quyền hủy đơn hàng này.");
    }
    }
}
?>