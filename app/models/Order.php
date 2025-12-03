<?php

class Order {
    private $conn;
    private $table_name = "orders";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create ($user_id, $customer_info, $cart_items){
        try {
            $this->conn->beginTransaction();
            $query = "INSERT INTO " . $this->table_name . " 
                      (user_id, total_money, fullname, phone, address, note, status)
                      VALUES (:user_id, :total, :name, :phone, :addr, :note, 'pending')";

            $stmt = $this->conn->prepare($query);
            $total_money = 0;
            foreach($cart_items as $item) {
                $total_money += $item['price'] * $item['quantity'];
            }

            $stmt->execute([
                ':user_id' => $user_id,
                ':total' => $total_money,
                ':name' => $customer_info['fullname'],
                ':phone' => $customer_info['phone'],
                ':addr' => $customer_info['address'],
                ':note' => $customer_info['note'] ?? ''
            ]);

            $order_id = $this->conn->lastInsertId();

            $query_item = "INSERT INTO order_items (order_id, product_id, variant_id, quantity, price) 
                           VALUES (?, ?, ?, ?, ?)";
            $stmt_item = $this->conn->prepare($query_item);

            $query_update_stock = "UPDATE product_variants SET quantity = quantity - ? WHERE id = ?";
            $stmt_stock = $this->conn->prepare($query_update_stock);

            foreach ($cart_items as $item) {
                $stmt_item->execute([
                    $order_id, 
                    $item['product_id'], 
                    $item['variant_id'], 
                    $item['quantity'], 
                    $item['price']
                ]);

                if(!empty($item['variant_id'])){
                     $stmt_stock->execute([$item['quantity'], $item['variant_id']]);
                }
            }

            $this->conn->commit();
            return $order_id;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getAllOrders() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getUserOrders($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt;
    }

    public function getOrderDetail($order_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) return null;

        $query_items = "
            SELECT oi.*, p.name as product_name, p.image_url, v.size 
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            LEFT JOIN product_variants v ON oi.variant_id = v.id
            WHERE oi.order_id = ?
        ";
        $stmt_items = $this->conn->prepare($query_items);
        $stmt_items->execute([$order_id]);
        $order['items'] = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

        return $order;
    }
    
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $id]);
    }
    
    public function cancelOrder($order_id) {
    $query_check = "SELECT status FROM " . $this->table_name . " WHERE id = ?";
    $stmt_check = $this->conn->prepare($query_check);
    $stmt_check->execute([$order_id]);
    $row = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($row && $row['status'] === 'pending') {
        $query = "UPDATE " . $this->table_name . " SET status = 'cancelled' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$order_id]);
    }
    return false;
    }
}
?>