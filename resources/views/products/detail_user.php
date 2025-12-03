<div class="row">
    <div class="col-md-7">
        <?php 
            $primary_image = 'https://via.placeholder.com/800x600?text=No+Image';
            if (!empty($product['images'])) {
                foreach ($product['images'] as $img) {
                    if ($img['is_primary']) {
                        $primary_image = $img['image_url'];
                        break;
                    }
                }
                if ($primary_image == 'https://via.placeholder.com/800x600?text=No+Image') {
                    $primary_image = $product['images'][0]['image_url'];
                }
            }
        ?>
        <img id="main-product-image" 
            src="<?php echo htmlspecialchars($primary_image); ?>" 
            class="img-fluid rounded mb-3" 
            alt="<?php echo htmlspecialchars($product['name']); ?>"      
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

    <!-- Cột bên phải: Thông tin chung (Giữ nguyên không đổi) -->
    <div class="col-md-5">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="text-muted">Nhà sản xuất: <strong><?php echo htmlspecialchars($product['manufacturer']); ?></strong></p>
        <p class="fs-3 fw-bold text-danger"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
        
        <span class="badge bg-info text-dark">Sân phù hợp: <?php echo htmlspecialchars($product['usage_type']); ?></span>
        <span class="badge bg-secondary"><?php echo htmlspecialchars($product['category_name']); ?></span>
        
        <p class="mt-3"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <hr>

        <!-- **** BẮT ĐẦU LOGIC PHÂN TÁCH GIAO DIỆN THEO VAI TRÒ **** -->
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): // ---- NẾU LÀ ADMIN ---- ?>
            
            <div class="p-3 mb-2 bg-light rounded border">
                <h5 class="mb-3"><i class="bi bi-box-seam me-2"></i>Thông tin Kho hàng</h5>
                <?php if (!empty($product['variants'])): ?>
                    <table class="table table-sm table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Size</th>
                                <th>Số lượng còn lại</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($product['variants'] as $variant): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($variant['size']); ?></td>
                                    <td><?php echo $variant['quantity']; ?> đôi</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-danger">Sản phẩm này chưa có thông tin size hoặc đã hết hàng.</p>
                <?php endif; ?>
                
                <hr>
                <h5 class="mb-3">Thao tác Admin</h5>
                <a href="index.php?area=admin&controller=product&action=edit&id=<?php echo $product['id']; ?>" class="btn btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Sửa sản phẩm
                </a>
                <a href="index.php?area=admin&controller=product&action=delete&id=<?php echo $product['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                    <i class="bi bi-trash"></i> Xóa sản phẩm
                </a>
            </div>

        <?php else: // ---- NẾU LÀ USER HOẶC GUEST ---- ?>
            
            <form action="index.php?controller=cart&action=add" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                
                <?php if (!empty($product['variants'])): ?>
                    <div class="mb-3">
                        <label for="size-select" class="form-label"><strong>Chọn Size:</strong></label>
                        <select class="form-select" id="size-select" name="variant_id" required>
                            <option value="" data-quantity="0" disabled selected>-- Vui lòng chọn size --</option>
                            <?php foreach($product['variants'] as $variant): ?>
                                <option value="<?php echo $variant['id']; ?>" data-quantity="<?php echo $variant['quantity']; ?>">
                                    <?php echo htmlspecialchars($variant['size']); ?> 
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity-input" class="form-label"><strong>Số lượng:</strong></label>
                        <input type="number" class="form-control" id="quantity-input" name="quantity" value="1" min="1" required disabled>
                    </div>

                    <button type="submit" id="add-to-cart-btn" disabled class="btn btn-primary btn-lg w-100"><i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng</button>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        Sản phẩm tạm thời hết hàng.
                    </div>
                <?php endif; ?>
            </form>

        <?php endif; ?>

    </div>
</div>

<script>
function changeImage(newSrc) {
    document.getElementById('main-product-image').src = newSrc;
}
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy các element cần thiết bằng ID
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
                    // Vô hiệu hóa ô số lượng và nút bấm
                    quantityInput.disabled = true;
                    addToCartBtn.disabled = true;
                    quantityInput.value = 1;
                }
            });
        }
    });
</script>
<!-- SEO: Schema Markup cho Google Rich Snippets -->
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<?php echo htmlspecialchars($product['name']); ?>",
  "image": [
    "<?php echo htmlspecialchars($primary_image); ?>"
   ],
  "description": "<?php echo htmlspecialchars(strip_tags($product['description'])); ?>",
  "brand": {
    "@type": "Brand",
    "name": "<?php echo htmlspecialchars($product['manufacturer'] ?? 'Basketball4Life'); ?>"
  },
  "offers": {
    "@type": "Offer",
    "url": "<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>",
    "priceCurrency": "VND",
    "price": "<?php echo $product['price']; ?>",
    "availability": "<?php echo (!empty($product['variants'])) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock'; ?>",
    "itemCondition": "https://schema.org/NewCondition"
  }
}
</script>
