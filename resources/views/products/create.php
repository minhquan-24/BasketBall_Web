<h1>Thêm Sản phẩm mới</h1>

<form action="index.php?area=admin&controller=product&action=store" method="POST">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">URL Hình ảnh chính</label>
                <input type="text" class="form-control" id="image_url" name="image_url">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="price" class="form-label">Giá (VNĐ)</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($all_categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>   
                </select>
            </div>
            <div class="mb-3">
                <label for="manufacturer" class="form-label">Nhà sản xuất</label>
                <input type="text" class="form-control" id="manufacturer" name="manufacturer">
            </div>
            <div class="mb-3">
                <label for="usage_type" class="form-label">Loại sân</label>
                <select class="form-select" id="usage_type" name="usage_type">
                    <option value="Both">Cả hai (Indoor/Outdoor)</option>
                    <option value="Indoor">Trong nhà (Indoor)</option>
                    <option value="Outdoor">Ngoài trời (Outdoor)</option>
                </select>
            </div>
        </div>
        <hr>
    
    <h4>Quản lý Size và Số lượng</h4>
    <div id="variants-container">
        <div class="row align-items-center mb-2 variant-row">
            <div class="col-md-4">
                <label class="form-label">Size</label>
                <input type="text" class="form-control" name="variants[size][]" placeholder="Ví dụ: 42, 42.5, M, L...">
            </div>
            <div class="col-md-4">
                <label class="form-label">Số lượng</label>
                <input type="number" class="form-control" name="variants[quantity][]" min="0" value="0">
            </div>
            <div class="col-md-2">
                <label class="form-label d-block">&nbsp;</label>
                <button type="button" class="btn btn-danger btn-sm remove-variant-btn">Xóa</button>
            </div>
        </div>
    </div>
    <button type="button" id="add-variant-btn" class="btn btn-secondary btn-sm mt-2"><i class="bi bi-plus-circle"></i> Thêm Size khác</button>
    
    <hr>
    </div>
    <button type="submit" class="btn btn-success">Lưu sản phẩm</button>
    <a href="index.php?area=admin&controller=product&action=manage" class="btn btn-secondary">Hủy</a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('variants-container');
    const addButton = document.getElementById('add-variant-btn');

    function addVariantRow() {
        const newRow = container.querySelector('.variant-row').cloneNode(true);
        newRow.querySelector('input[name="variants[size][]"]').value = '';
        newRow.querySelector('input[name="variants[quantity][]"]').value = '0';
        container.appendChild(newRow);
    }

    function removeVariantRow(event) {
        if (event.target.classList.contains('remove-variant-btn') && container.querySelectorAll('.variant-row').length > 1) {
            event.target.closest('.variant-row').remove();
        }
    }
    
    addButton.addEventListener('click', addVariantRow);
    container.addEventListener('click', removeVariantRow);
});
</script>