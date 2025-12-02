<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quản lý Đơn hàng</h1>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orders as $order): ?>
            <tr>
                <td>#<?php echo $order['id']; ?></td>
                <td>
                    <strong><?php echo htmlspecialchars($order['fullname']); ?></strong><br>
                    <small><?php echo $order['phone']; ?></small>
                </td>
                <td><?php echo number_format($order['total_money'], 0, ',', '.'); ?> VNĐ</td>
                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                <td>
                    <?php 
                        $status_color = [
                            'pending' => 'bg-warning',
                            'confirmed' => 'bg-info',
                            'shipping' => 'bg-primary',
                            'delivered' => 'bg-success',
                            'cancelled' => 'bg-danger'
                        ];
                        $status_label = [
                            'pending' => 'Chờ xác nhận',
                            'confirmed' => 'Đã xác nhận',
                            'shipping' => 'Đang giao',
                            'delivered' => 'Đã giao',
                            'cancelled' => 'Đã hủy'
                        ];
                    ?>
                    <span class="badge <?php echo $status_color[$order['status']] ?? 'bg-secondary'; ?>">
                        <?php echo $status_label[$order['status']] ?? $order['status']; ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?area=admin&controller=order&action=show&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">Chi tiết</a>
                    <?php if ($order['status'] == 'pending'): ?>
                        <a href="index.php?area=admin&controller=order&action=cancel&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">Hủy đơn</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>