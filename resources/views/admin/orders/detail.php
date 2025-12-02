<div class="container">
    <a href="index.php?area=admin&controller=order&action=index" class="btn btn-secondary mb-3">&laquo; Quay lại</a>
    
    <?php if(isset($_GET['status']) && $_GET['status'] == 'update_success'): ?>
        <div class="alert alert-success">Cập nhật trạng thái thành công!</div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">Chi tiết sản phẩm (Đơn #<?php echo $order['id']; ?>)</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Size</th>
                                <th>Giá mua</th>
                                <th>SL</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($order['items'] as $item): ?>
                                <tr>
                                    <td><img src="<?php echo $item['image_url']; ?>" width="50"></td>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td><?php echo $item['size']; ?></td>
                                    <td><?php echo number_format($item['price'],0,',','.'); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['price'] * $item['quantity'],0,',','.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h4 class="text-end text-danger">Tổng cộng: <?php echo number_format($order['total_money'],0,',','.'); ?> VNĐ</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-white">Thông tin & Trạng thái</div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
                    <p><strong>SĐT:</strong> <?php echo $order['phone']; ?></p>
                    <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                    <p><strong>Ghi chú:</strong> <?php echo htmlspecialchars($order['note']); ?></p>
                    <p><strong>Ngày đặt:</strong> <?php echo $order['created_at']; ?></p>
                    <hr>
                    
                    <form action="index.php?area=admin&controller=order&action=update_status" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <label class="form-label fw-bold">Cập nhật trạng thái:</label>
                        <select name="status" class="form-select mb-3">
                            <option value="pending" <?php echo $order['status']=='pending'?'selected':''; ?>>Chờ xác nhận</option>
                            <option value="confirmed" <?php echo $order['status']=='confirmed'?'selected':''; ?>>Đã xác nhận</option>
                            <option value="shipping" <?php echo $order['status']=='shipping'?'selected':''; ?>>Đang giao hàng</option>
                            <option value="delivered" <?php echo $order['status']=='delivered'?'selected':''; ?>>Giao thành công</option>
                            <option value="cancelled" <?php echo $order['status']=='cancelled'?'selected':''; ?>>Hủy đơn</option>
                        </select>
                        <button type="submit" class="btn btn-success w-100">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>