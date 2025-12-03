<div class="container mt-4">
    <a href="index.php?controller=order&action=history" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Quay lại lịch sử
    </a>

    <div class="row">
        <!-- Danh sách sản phẩm -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-bag"></i> Chi tiết đơn hàng #<?php echo $order['id']; ?>
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Size</th>
                                <th>Đơn giá</th>
                                <th>SL</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($order['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="Product" width="60" class="img-thumbnail">
                                    </td>
                                    <td>
                                        <span class="fw-bold"><?php echo htmlspecialchars($item['product_name']); ?></span>
                                    </td>
                                    <td><span class="badge bg-secondary"><?php echo $item['size']; ?></span></td>
                                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                                    <td>x<?php echo $item['quantity']; ?></td>
                                    <td class="fw-bold"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Tổng tiền thanh toán:</td>
                                <td class="text-danger fw-bold fs-5">
                                    <?php echo number_format($order['total_money'], 0, ',', '.'); ?> VNĐ
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Thông tin nhận hàng -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-truck"></i> Thông tin giao hàng
                </div>
                <div class="card-body">
                    <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                    
                    <hr>
                    <h6 class="fw-bold">Người nhận:</h6>
                    <p class="mb-1"><?php echo htmlspecialchars($order['fullname']); ?></p>
                    <p class="mb-1"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($order['phone']); ?></p>
                    <p><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($order['address']); ?></p>
                    
                    <?php if(!empty($order['note'])): ?>
                        <div class="alert alert-warning mt-3">
                            <strong>Ghi chú:</strong> <?php echo htmlspecialchars($order['note']); ?>
                        </div>
                    <?php endif; ?>

                    <hr>
                    <h6 class="fw-bold">Trạng thái đơn hàng:</h6>
                    <?php 
                        $status_label = [
                            'pending' => 'Chờ xác nhận',
                            'confirmed' => 'Đã xác nhận',
                            'shipping' => 'Đang giao hàng',
                            'delivered' => 'Giao thành công',
                            'cancelled' => 'Đã hủy'
                        ];
                        $st = $order['status'];
                    ?>
                    <div class="alert <?php echo ($st == 'cancelled') ? 'alert-danger' : (($st == 'delivered') ? 'alert-success' : 'alert-info'); ?> text-center mb-0">
                        <strong><?php echo $status_label[$st] ?? $st; ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>