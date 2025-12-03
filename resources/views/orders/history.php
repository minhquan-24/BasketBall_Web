<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-clock-history"></i> Lịch sử mua hàng</h2>
        <a href="index.php?controller=products&action=index" class="btn btn-primary">
            <i class="bi bi-cart-plus"></i> Tiếp tục mua sắm
        </a>
    </div>

    <!-- Thông báo vừa đặt hàng xong -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'order_success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i> Đặt hàng thành công!</strong> 
            Cảm ơn bạn đã ủng hộ cửa hàng. Chúng tôi sẽ sớm liên hệ để xác nhận.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-bag-x fs-1"></i>
            <p class="mt-3">Bạn chưa có đơn hàng nào.</p>
            <a href="index.php" class="btn btn-outline-primary">Khám phá sản phẩm ngay</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Thông tin người nhận</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong>#<?php echo $order['id']; ?></strong></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($order['fullname']); ?></strong><br>
                                <small class="text-muted"><?php echo $order['phone']; ?></small><br>
                                <small class="text-muted d-inline-block text-truncate" style="max-width: 200px;">
                                    <?php echo htmlspecialchars($order['address']); ?>
                                </small>
                            </td>
                            <td class="fw-bold text-danger">
                                <?php echo number_format($order['total_money'], 0, ',', '.'); ?> VNĐ
                            </td>
                            <td>
                                <?php 
                                    $status_color = [
                                        'pending' => 'bg-warning text-dark',
                                        'confirmed' => 'bg-info text-dark',
                                        'shipping' => 'bg-primary',
                                        'delivered' => 'bg-success',
                                        'cancelled' => 'bg-danger'
                                    ];
                                    $status_label = [
                                        'pending' => 'Chờ xác nhận',
                                        'confirmed' => 'Đã xác nhận',
                                        'shipping' => 'Đang giao hàng',
                                        'delivered' => 'Giao thành công',
                                        'cancelled' => 'Đã hủy'
                                    ];
                                ?>
                                <span class="badge <?php echo $status_color[$order['status']] ?? 'bg-secondary'; ?> rounded-pill">
                                    <?php echo $status_label[$order['status']] ?? $order['status']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="index.php?controller=order&action=detail&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                                <?php if ($order['status'] == 'pending'): ?>
                                    <a href="index.php?controller=order&action=cancel&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                        <i class="bi bi-x-circle"></i> Hủy đơn
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Script xóa param status trên URL để không hiện lại thông báo khi F5 -->
<script>
    if (window.history.replaceState) {
        const url = new URL(window.location.href);
        if (url.searchParams.has('status')) {
            url.searchParams.delete('status');
            window.history.replaceState(null, '', url.toString());
        }
    }
</script>