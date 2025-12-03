<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-person"></i>Manage User
    </h1>
    <!-- Hiển thị thông báo -->
<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'delete_success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Đã xóa người dùng.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'delete_failed'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed!</strong> Có lỗi xảy ra khi xóa người dùng.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'delete_self_failed'): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Warning!</strong> Bạn không thể tự xóa tài khoản của chính mình.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
<?php endif; ?>
</div>



<table class="table table-striped table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th width="150px">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $num = $stmt->rowCount();
        if ($num > 0): 
        ?>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): extract($row); ?>
                <tr>
                    <td><?php echo $id ?></td>
                    <td><?php echo htmlspecialchars($name); ?></td>
                    <td><?php echo htmlspecialchars($email); ?></td>
                    <td>
                        <?php if ($role === 'admin'): ?>
                            <span class="badge bg-success">Admin</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">User</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($_SESSION['user_id'] != $id): ?>
                        <a href="index.php?area=admin&controller=user&action=delete&id=<?php echo $id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không? Hành động này không thể hoàn tác.');">
                            <i class="bi bi-trash"></i> Delete
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Không có người dùng nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <?php
        $total_pages = ceil($total_rows / $records_per_page);

        if ($total_rows > 0 && $total_pages > 1):
            $query_params = $_GET;
            unset($query_params['status']); 

            // Nút 'Trước'
            if ($page_num > 1):
                $query_params['page_num'] = $page_num - 1;
                $prev_url = 'index.php?' . http_build_query($query_params);
                echo "<li class='page-item'><a class='page-link' href='{$prev_url}'>&laquo; Trước</a></li>";
            endif;

            // Các số trang
            for ($i = 1; $i <= $total_pages; $i++):
                $active = ($i == $page_num) ? 'active' : '';
                $query_params['page_num'] = $i;
                $url = 'index.php?' . http_build_query($query_params);
                echo "<li class='page-item {$active}'><a class='page-link' href='{$url}'>{$i}</a></li>";
            endfor;

            // Nút 'Sau'
            if ($page_num < $total_pages):
                $query_params['page_num'] = $page_num + 1;
                $next_url = 'index.php?' . http_build_query($query_params);
                echo "<li class='page-item'><a class='page-link' href='{$next_url}'>Sau &raquo;</a></li>";
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