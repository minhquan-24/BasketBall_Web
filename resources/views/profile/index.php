<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                    <!-- Avatar giả định: Lấy chữ cái đầu của tên -->
                    <div class="d-inline-flex align-items-center justify-content-center bg-white text-primary rounded-circle shadow-sm mb-3" 
                         style="width: 80px; height: 80px; font-size: 2.5rem; font-weight: bold;">
                        <?php echo strtoupper(substr($user->name, 0, 1)); ?>
                    </div>
                    <h3 class="mb-0"><?php echo htmlspecialchars($user->name); ?></h3>
                    <p class="mb-0 opacity-75"><?php echo htmlspecialchars($user->email); ?></p>
                </div>
                
                <div class="card-body p-4">
                    <h5 class="mb-3 text-muted"><i class="bi bi-person-vcard"></i> Thông tin tài khoản</h5>
                    
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span><i class="bi bi-person me-2"></i> Họ và tên</span>
                            <span class="fw-bold"><?php echo htmlspecialchars($user->name); ?></span>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span><i class="bi bi-envelope me-2"></i> Email</span>
                            <span class="fw-bold"><?php echo htmlspecialchars($user->email); ?></span>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span><i class="bi bi-shield-lock me-2"></i> Vai trò</span>
                            <?php if ($user->role === 'admin'): ?>
                                <span class="badge bg-danger rounded-pill px-3">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-success rounded-pill px-3">User</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span><i class="bi bi-calendar3 me-2"></i> Ngày tham gia</span>
                            <span class="text-muted">
                                <?php echo date('d/m/Y', strtotime($user->created_at)); ?>
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <?php if ($user->role !== 'admin'): ?>
                            <a href="index.php?controller=order&action=history" class="btn btn-outline-primary">
                                <i class="bi bi-clock-history"></i> Xem lịch sử mua hàng
                            </a>
                        <?php else: ?>
                             <a href="index.php?area=admin&controller=product&action=manage" class="btn btn-outline-primary">
                                <i class="bi bi-speedometer2"></i> Vào trang quản trị
                            </a>
                        <?php endif; ?>
                        
                        <a href="index.php?controller=auth&action=logout" class="btn btn-light text-danger mt-2">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>