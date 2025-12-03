<div class="row">
    <div class="col-md-7">
        <?php 
            $primary_image = 'https://via.placeholder.com/800x600?text=No+Image';
            if (!empty($product['images'])) {
                foreach ($product['images'] as $img) {
                    if ($img['is_primary']) { $primary_image = $img['image_url']; break; }
                }
                if ($primary_image == 'https://via.placeholder.com/800x600?text=No+Image') {
                    $primary_image = $product['images'][0]['image_url'];
                }
            }
        ?>
        <img 
            id="main-product-image" 
            src="<?php echo htmlspecialchars($primary_image); ?>" 
            class="img-fluid rounded mb-3" alt="<?php echo htmlspecialchars($product['name']); ?>"
            style="max-height: 500px; width: 100%; object-fit: contain; background-color: #f8f9fa;"
        >
        <div class="row">
            <?php foreach ($product['images'] as $image): ?>
                <div class="col-3">
                    <img src="<?php echo htmlspecialchars($image['image_url']); ?>" class="img-fluid rounded border cursor-pointer thumbnail" alt="Thumbnail" onclick="changeImage('<?php echo htmlspecialchars($image['image_url']); ?>')">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-md-5">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p class="text-muted">Nhà sản xuất: <strong><?php echo htmlspecialchars($product['manufacturer']); ?></strong></p>
        <p class="fs-3 fw-bold text-danger"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
        
        <p><strong>Loại sân:</strong> <span class="badge bg-info text-dark"><?php echo htmlspecialchars($product['usage_type']); ?></span></p>
        <p><strong>Danh mục:</strong> <span class="badge bg-secondary"><?php echo htmlspecialchars($product['category_name']); ?></span></p>
        
        <hr>
        <h4>Mô tả sản phẩm</h4>
        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <hr>
        
        <div class="p-3 mb-2 bg-light rounded border">
            <h5 class="mb-3"><i class="bi bi-box-seam me-2"></i>Thông tin Kho hàng</h5>
            <?php if (!empty($product['variants'])): ?>
                <table class="table table-sm table-bordered">
                    <thead class="table-dark">
                        <tr><th>Size</th><th>Số lượng còn lại</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($product['variants'] as $variant): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($variant['size']); ?></td>
                                <td><?php echo $variant['quantity']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-danger">Sản phẩm này chưa có thông tin size hoặc đã hết hàng.</p>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="index.php?area=admin&controller=product&action=edit&id=<?php echo $product['id']; ?>" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Sửa
                </a>
                <a href="index.php?area=admin&controller=product&action=delete&id=<?php echo $product['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                    <i class="bi bi-trash"></i> Xóa
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function changeImage(newSrc) {
    document.getElementById('main-product-image').src = newSrc;
}
    document.addEventListener('DOMContentLoaded', function() {
        const sizeSelect = document.getElementById('size-select');
        const quantityInput = document.getElementById('quantity-input');
        const addToCartBtn = document.getElementById('add-to-cart-btn');

        if (sizeSelect && quantityInput && addToCartBtn) {
            sizeSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const maxQuantity = selectedOption.getAttribute('data-quantity');

                if (maxQuantity && parseInt(maxQuantity) > 0) {
                    quantityInput.max = maxQuantity;
                    quantityInput.value = 1;
                    quantityInput.disabled = false;
                    addToCartBtn.disabled = false;
                } else {
                    quantityInput.disabled = true;
                    addToCartBtn.disabled = true;
                    quantityInput.value = 1;
                }
            });
        }
    });
</script>