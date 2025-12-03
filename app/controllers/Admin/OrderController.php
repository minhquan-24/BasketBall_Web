<?php
require_once __DIR__ . '/../../../app/models/Order.php';

class OrderController {
    private $db;
    private $orderModel;

    public function __construct($db) {
        $this->db = $db;
        $this->orderModel = new Order($db);
    }

    public function index() {
        $stmt = $this->orderModel->getAllOrders();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $breadcrumbs = [
            ['label' => 'Quản lý Đơn hàng', 'url' => null]
        ];

        $page_title = "Quản lý Đơn hàng - Admin";
        require '../resources/views/layouts/header.php';
        require '../resources/views/admin/orders/manage.php';
        require '../resources/views/layouts/footer.php';
    }

    public function show() {
        $id = $_GET['id'];
        $order = $this->orderModel->getOrderDetail($id);

        $page_title = "Xử lý đơn hàng #" . $id;
        require '../resources/views/layouts/header.php';
        require '../resources/views/admin/orders/detail.php';
        require '../resources/views/layouts/footer.php';
    }

    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['status'];
            
            $this->orderModel->updateStatus($id, $status);
            header("Location: index.php?area=admin&controller=order&action=show&id=$id&status=update_success");
        }
    }

    public function cancel() {
    $order_id = $_GET['id'] ?? 0;
    if ($this->orderModel->cancelOrder($order_id)) {
        header("Location: index.php?area=admin&controller=order&action=index&status=cancel_success");
    } else {
        header("Location: index.php?area=admin&controller=order&action=index&status=cancel_failed");
    }
    }
}
?>