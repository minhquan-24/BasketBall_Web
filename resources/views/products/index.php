<!-- Header cho trang sản phẩm -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <h1><?php echo !empty($category_name) ? htmlspecialchars($category_name) : 'Tất cả sản phẩm'; ?></h1>
    
    <form action="index.php" method="GET" class="d-flex align-items-center">
        <input type="hidden" name="controller" value="products">
        <input type="hidden" name="action" value="index">
        <?php if (!empty($category_id)): ?>
            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
        <?php endif; ?>
        <label for="sort" class="form-label me-2 mb-0">Sắp xếp:</label>
        <select class="form-select w-auto" id="sort" name="sort" onchange="this.form.submit()">
            <option value="created_at_desc" <?php echo ($sort == 'created_at_desc' ? 'selected' : ''); ?>>Mới nhất</option>
            <option value="price_asc" <?php echo ($sort == 'price_asc' ? 'selected' : ''); ?>>Giá: Tăng dần</option>
            <option value="price_desc" <?php echo ($sort == 'price_desc' ? 'selected' : ''); ?>>Giá: Giảm dần</option>
        </select>
    </form>
</div>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
    <?php if ($num > 0): ?>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): extract($row); ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <a href="index.php?controller=products&action=show&id=<?php echo $id; ?>">
                        <div class="product-image-container">
                            <img src="<?php echo htmlspecialchars($image_url ?? 'https://via.placeholder.com/400x300?text=No+Image'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($name); ?>" style="height: 200px; object-fit: contain;">
                        </div> 
                    </a>
                    <div class="card-body d-flex flex-column">
                        <?php if (!empty($category_name)): ?>
                            <p class="card-subtitle mb-2">
                                <span class="badge bg-primary fw-light"><?php echo htmlspecialchars($category_name); ?></span>
                            </p>
                        <?php endif; ?>
                        <h5 class="card-title" style="font-size: 1rem;"><a href="index.php?controller=products&action=show&id=<?php echo $id; ?>" class="text-dark text-decoration-none"><?php echo htmlspecialchars($name); ?></a></h5>
                        <p class="card-text text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($description); ?></p>
                        <p class="card-text fs-6 fw-bold text-danger mt-auto"><?php echo number_format($price, 0, ',', '.'); ?> VNĐ</p>
                        <a href="index.php?controller=products&action=show&id=<?php echo $id; ?>" class="btn btn-outline-dark w-100 btn-sm mt-2">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="col-12 text-center">Không tìm thấy sản phẩm nào phù hợp.</p>
    <?php endif; ?>
</div>

<nav aria-label="Page navigation" class="mt-5">
    <ul class="pagination justify-content-center">
        <?php
        $total_pages = ceil($total_rows / $records_per_page);

        if ($total_pages >= 1): 
            $query_params = $_GET;

            // Nút 'Trang trước'
            if ($page_num > 1) {
                $query_params['page_num'] = $page_num - 1;
                echo "<li class='page-item'><a class='page-link' href='index.php?" . http_build_query($query_params) . "'>Page before</a></li>";
            }

            // Các nút số trang
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i == $page_num) ? 'active' : '';
                $query_params['page_num'] = $i;
                echo "<li class='page-item {$active_class}'><a class='page-link' href='index.php?" . http_build_query($query_params) . "'>{$i}</a></li>";
            }

            // Nút 'Trang sau'
            if ($page_num < $total_pages) {
                $query_params['page_num'] = $page_num + 1;
                echo "<li class='page-item'><a class='page-link' href='index.php?" . http_build_query($query_params) . "'>Page After</a></li>";
            }
        endif;
        ?>
    </ul>
</nav>