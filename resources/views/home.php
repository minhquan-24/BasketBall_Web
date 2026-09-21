<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Chào mừng đến với Cửa hàng!</h1>
        <p class="col-md-8 fs-4">Nơi cung cấp những mẫu giày bóng rổ chính hãng, chất lượng hàng đầu với mức giá tốt nhất.</p>
        <a href="index.php?controller=products&action=index" class="btn btn-primary btn-lg" type="button">Khám phá ngay</a>
    </div>
</div>

<section class="home-shoe-showcase" aria-label="Giày bóng rổ nổi bật">
    <div class="d-flex justify-content-between align-items-end mb-3">
        <div>
            <small class="text-danger fw-bold">COURT READY</small>
            <h2 class="fw-bold mb-0">Khám phá bộ sưu tập</h2>
        </div>
        <a href="index.php?controller=products&action=index" class="text-danger fw-bold text-decoration-none">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="home-shoe-window">
        <div class="home-shoe-track">
            <?php
            $home_shoes = [
                ['image' => 'adidas.avif', 'name' => 'Adidas Court'],
                ['image' => 'curry10.avif', 'name' => 'Curry 10'],
                ['image' => 'kobeball.avif', 'name' => 'Kobe Edition'],
                ['image' => 'puma.avif', 'name' => 'Puma Rise'],
                ['image' => 'tarmak.avif', 'name' => 'Tarmak'],
                ['image' => 'jordan.webp', 'name' => 'Jordan Flight'],
            ];
            foreach ($home_shoes as $shoe):
            ?>
                <a class="home-shoe-card" href="index.php?controller=products&action=index">
                    <img src="images/<?php echo htmlspecialchars($shoe['image']); ?>" alt="<?php echo htmlspecialchars($shoe['name']); ?>">
                    <strong><?php echo htmlspecialchars($shoe['name']); ?></strong>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>