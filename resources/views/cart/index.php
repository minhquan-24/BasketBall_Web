<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-cart3"></i> Giỏ hàng của bạn</h2>
    
    <?php if(empty($cart)): ?>
        <div class="text-center py-5 bg-light rounded">
            <i class="bi bi-bag-x fs-1 text-muted"></i>
            <p class="mt-3 fs-5">Giỏ hàng của bạn đang trống.</p>
            <a href="index.php?controller=products&action=index" class="btn btn-primary">Mua sắm ngay</a>
        </div>
    <?php else: ?>
        <!-- MỞ FORM BAO QUANH CẢ 2 CỘT -->
        <form action="index.php?controller=cart&action=checkout" method="POST" id="cart-form">
            <div class="row">
                <!-- Danh sách sản phẩm -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select-all">
                                <label class="form-check-label fw-bold" for="select-all">
                                    Chọn tất cả (<?php echo count($cart); ?> sản phẩm)
                                </label>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>SL</th>
                                        <th>Thành tiền</th>
                                        <th class="text-center">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($cart as $index => $item): 
                                        $item_total = $item['price'] * $item['quantity'];
                                    ?>
                                    <tr>
                                        <td>
                                            <input class="form-check-input item-checkbox" type="checkbox" 
                                                   name="selected_items[]" 
                                                   value="<?php echo $index; ?>"
                                                   data-price="<?php echo $item_total; ?>">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                                     class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                                    <small class="text-muted">Size: <?php echo htmlspecialchars($item['size']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo $item['quantity']; ?></span>
                                        </td>
                                        <td class="fw-bold text-dark">
                                            <?php echo number_format($item_total, 0, ',', '.'); ?>đ
                                        </td>
                                        <td class="text-center">
                                            <a href="index.php?controller=cart&action=remove&index=<?php echo $index; ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Bạn muốn bỏ sản phẩm này?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Form thanh toán -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-credit-card"></i> Thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                <span>Đã chọn:</span>
                                <span class="fw-bold" id="selected-count">0 sản phẩm</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                <span class="fw-bold fs-5">Tổng tiền:</span>
                                <span class="fs-4 text-danger fw-bold" id="total-price">0 VNĐ</span>
                            </div>
                            <hr>
                            
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Họ tên người nhận</label>
                                    <input type="text" name="fullname" class="form-control" 
                                           value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control" required placeholder="Nhập số điện thoại">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <textarea name="address" class="form-control" rows="2" required placeholder="Địa chỉ giao hàng..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú</label>
                                    <textarea name="note" class="form-control" rows="1"></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-success w-100 py-2" id="btn-checkout" disabled>
                                    XÁC NHẬN THANH TOÁN
                                </button>
                                <small class="text-muted d-block text-center mt-2">* Vui lòng chọn sản phẩm để thanh toán</small>
                            <?php else: ?>
                                <div class="alert alert-warning text-center">
                                    <a href="index.php?controller=auth&action=login">Đăng nhập</a> để thanh toán.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<!-- JAVASCRIPT XỬ LÝ CHECKBOX VÀ TỔNG TIỀN -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const totalPriceEl = document.getElementById('total-price');
    const selectedCountEl = document.getElementById('selected-count');
    const btnCheckout = document.getElementById('btn-checkout');

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
    }

    function updateTotal() {
        let total = 0;
        let count = 0;

        itemCheckboxes.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.getAttribute('data-price'));
                count++;
            }
        });

        totalPriceEl.textContent = formatCurrency(total);
        selectedCountEl.textContent = count + ' sản phẩm';

        if (btnCheckout) {
            btnCheckout.disabled = (count === 0);
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            itemCheckboxes.forEach(cb => {
                cb.checked = this.checked;
            });
            updateTotal();
        });
    }

    itemCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if (!this.checked && selectAll) {
                selectAll.checked = false;
            }
            if (selectAll && document.querySelectorAll('.item-checkbox:checked').length === itemCheckboxes.length) {
                selectAll.checked = true;
            }
            updateTotal();
        });
    });
});
</script>