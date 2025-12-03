<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quản lý Sản phẩm</h1>
    <a href="index.php?area=admin&controller=product&action=create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
    </a>
    <?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'create_success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thành công!</strong> Đã thêm sản phẩm mới.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'create_failed'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Thất bại!</strong> Có lỗi xảy ra khi thêm sản phẩm.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'update_success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Đã cập nhật sản phẩm thành công.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'delete_success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ... Đã xóa sản phẩm thành công.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'delete_failed'): ?>
        <div class="alert alert-danger">... Có lỗi xảy ra khi xóa sản phẩm.</div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<p>Hiển thị <?php echo $num; ?> trên tổng số <?php echo $total_rows; ?> sản phẩm.</p>

<table class="table table-striped table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($num > 0): ?>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): extract($row); ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td>
                    <a href="index.php?area=admin&controller=product&action=show&id=<?php echo $id; ?>">
                        <img src="<?php echo htmlspecialchars($image_url ?? 'https://via.placeholder.com/100'); ?>" alt="<?php echo htmlspecialchars($name); ?>" style="width: 80px; height: 80px; object-fit: contain;">
                    </a>
                    </td>
                    <td><?php echo htmlspecialchars($name); ?></td>
                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($category_name); ?></span></td>
                    <td><?php echo number_format($price, 0, ',', '.'); ?> VNĐ</td>
                    <td class="text-center">
                        <a href="index.php?area=admin&controller=product&action=show&id=<?php echo $id; ?>" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <a href="index.php?area=admin&controller=product&action=edit&id=<?php echo $id; ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Modify
                        </a>
                        <a href="index.php?area=admin&controller=product&action=delete&id=<?php echo $id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            <i class="bi bi-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Không có sản phẩm nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Phân trang cho admin  -->
<!-- <nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <?php
        $total_pages = ceil($total_rows / $records_per_page);

        if ($total_pages >= 1):
            $base_url_params = [
                'area' => 'admin',
                'controller' => 'product',
                'action' => 'manage'
            ];
            if (!empty($category_id)) {
                $base_url_params['category_id'] = $category_id;
            }

            if ($page_num > 1):
                $prev_page_params = array_merge($base_url_params, ['page_num' => $page_num - 1]);
                $prev_page_url = 'index.php?' . http_build_query($prev_page_params);
                echo "<li class='page-item'><a class='page-link' href='{$prev_page_url}'>&laquo; Trước</a></li>";
            endif;

            for ($i = 1; $i <= $total_pages; $i++):
                $active_class = ($i == $page_num) ? 'active' : '';
                $page_params = array_merge($base_url_params, ['page_num' => $i]);
                $page_url = 'index.php?' . http_build_query($page_params);
                echo "<li class='page-item {$active_class}'><a class='page-link' href='{$page_url}'>{$i}</a></li>";
            endfor;

            if ($page_num < $total_pages):
                $next_page_params = array_merge($base_url_params, ['page_num' => $page_num + 1]);
                $next_page_url = 'index.php?' . http_build_query($next_page_params);
                echo "<li class='page-item'><a class='page-link' href='{$next_page_url}'>Sau &raquo;</a></li>";
            endif;
        endif;
        ?>
    </ul>
</nav> -->

<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <?php
        $total_pages = ceil($total_rows / $records_per_page);

        if ($total_rows > 0 && $total_pages > 1):
            $query_params = $_GET;
            unset($query_params['status']); 

            // Nút 'Trang trước'
            if ($page_num > 1):
                $query_params['page_num'] = $page_num - 1;
                $prev_page_url = 'index.php?' . http_build_query($query_params);
                echo "<li class='page-item'><a class='page-link' href='{$prev_page_url}'>&laquo; Trước</a></li>";
            endif;

            // Các nút số trang
            for ($i = 1; $i <= $total_pages; $i++):
                $active_class = ($i == $page_num) ? 'active' : '';
                $query_params['page_num'] = $i;
                $page_url = 'index.php?' . http_build_query($query_params);
                echo "<li class='page-item {$active_class}'><a class='page-link' href='{$page_url}'>{$i}</a></li>";
            endfor;

            // Nút 'Trang sau'
            if ($page_num < $total_pages):
                $query_params['page_num'] = $page_num + 1;
                $next_page_url = 'index.php?' . http_build_query($query_params);
                echo "<li class='page-item'><a class='page-link' href='{$next_page_url}'>Sau &raquo;</a></li>";
            endif;
        endif;
        ?>
    </ul>
</nav>


<script>
    if (window.history.replaceState) {
        const url = new URL(window.location.href);
        
        if (url.searchParams.has('status')) {
            url.searchParams.delete('status');
            
            window.history.replaceState(null, '', url.toString());
        }
    }
    
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000); // 3000ms = 3 giây
</script>