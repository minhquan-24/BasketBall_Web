<?php
// Fallback curated products if database query is empty
$default_featured_items = [
    [
        'id' => 1,
        'name' => 'Nike LeBron 20 "Time Machine"',
        'category_name' => 'Basketball Shoe',
        'price' => 4850000,
        'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60',
        'badge' => 'BEST SELLER',
        'rating' => 5
    ],
    [
        'id' => 3,
        'name' => 'Under Armour Curry Flow 10',
        'category_name' => 'Basketball Shoe',
        'price' => 3950000,
        'image_url' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60',
        'badge' => 'HOT DROP',
        'rating' => 5
    ],
    [
        'id' => 2,
        'name' => 'Jordan Zion 1 "Z-3D"',
        'category_name' => 'Basketball Shoe',
        'price' => 3290000,
        'image_url' => 'https://images.unsplash.com/photo-1552346154-21d32810baa3?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60',
        'badge' => 'GIẢM 15%',
        'rating' => 5
    ],
    [
        'id' => 6,
        'name' => 'Nike Kyrie Flytrap 5',
        'category_name' => 'Basketball Shoe',
        'price' => 2190000,
        'image_url' => 'https://images.unsplash.com/photo-1514989940723-e8e51635b782?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60',
        'badge' => 'SPEED GRIP',
        'rating' => 5
    ]
];

$display_products = (!empty($featured_products) && is_array($featured_products)) 
    ? $featured_products 
    : $default_featured_items;
?>

<!-- HERO SECTION: Clean & Modern -->
<section class="mb-5 position-relative rounded-4 overflow-hidden shadow-sm" style="min-height: 400px; background: url('https://images.unsplash.com/photo-1519861531473-9200262188bf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.6;"></div>
    <div class="position-relative z-1 container py-5 d-flex flex-column justify-content-center h-100 text-white">
        <span class="badge bg-danger mb-3 align-self-start py-2 px-3">BỘ SƯU TẬP MỚI 2026</span>
        <h1 class="display-4 fw-bold mb-3">LÀM CHỦ SÂN ĐẤU</h1>
        <p class="lead mb-4" style="max-width: 600px;">Khám phá những mẫu giày bóng rổ đỉnh cao nhất, giúp bạn bứt phá giới hạn và tự tin tỏa sáng trên mọi mặt sân.</p>
        <div>
            <a href="index.php?controller=products&action=index" class="btn btn-warning btn-lg fw-bold me-3 px-4 rounded-pill">Mua Ngay</a>
            <a href="#best-sellers" class="btn btn-outline-light btn-lg fw-bold px-4 rounded-pill">Sản phẩm Hot</a>
        </div>
    </div>
</section>

<!-- BRAND MARQUEE -->
<div class="bg-light py-3 mb-5 border-top border-bottom overflow-hidden">
    <div class="container d-flex justify-content-between align-items-center fw-bold text-muted text-uppercase" style="white-space: nowrap; font-size: 0.9rem;">
        <span><i class="bi bi-dribbble me-1"></i> Nike Hoops</span>
        <span>★ Air Jordan</span>
        <span><i class="bi bi-fire me-1"></i> Adidas Basketball</span>
        <span><i class="bi bi-lightning-charge-fill me-1"></i> Curry Brand</span>
        <span><i class="bi bi-trophy-fill me-1"></i> Puma Hoops</span>
    </div>
</div>

<!-- FEATURED CATEGORIES -->
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-0">Danh Mục Nổi Bật</h2>
        </div>
        <a href="index.php?controller=products&action=index" class="text-danger fw-bold text-decoration-none">
            Xem tất cả <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <a href="index.php?controller=products&action=index&category_id=1" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Giày bóng rổ" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center bg-dark text-white">
                        <h5 class="card-title fw-bold mb-0">Giày Bóng Rổ</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="index.php?controller=products&action=index&category_id=2" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1515523110800-9415d13b84a8?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Bóng thi đấu" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center bg-dark text-white">
                        <h5 class="card-title fw-bold mb-0">Bóng Thi Đấu</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="index.php?controller=products&action=index&category_id=4" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1574258495973-f010dfbb5371?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Phụ kiện" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center bg-dark text-white">
                        <h5 class="card-title fw-bold mb-0">Túi & Phụ Kiện</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- BEST SELLERS -->
<section id="best-sellers" class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-0">Sản Phẩm Bán Chạy</h2>
        </div>
        <a href="index.php?controller=products&action=index" class="btn btn-outline-dark rounded-pill btn-sm px-3 fw-bold">
            Xem tất cả <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        <?php foreach ($display_products as $prod): 
            $prod_id = $prod['id'] ?? 1;
            $prod_name = $prod['name'] ?? 'Giày bóng rổ';
            $prod_price = is_numeric($prod['price']) ? (float)$prod['price'] : 2500000;
            $formatted_price = ($prod_price < 1000) 
                ? number_format($prod_price * 25400, 0, ',', '.') . ' đ'
                : number_format($prod_price, 0, ',', '.') . ' đ';
            $prod_img = !empty($prod['image_url']) ? $prod['image_url'] : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60';
            $prod_cat = $prod['category_name'] ?? 'Bóng Rổ';
            $prod_badge = $prod['badge'] ?? '';
        ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative">
                    <?php if($prod_badge): ?>
                        <span class="badge bg-danger position-absolute top-0 end-0 m-3 z-1"><?php echo htmlspecialchars($prod_badge); ?></span>
                    <?php endif; ?>
                    
                    <a href="index.php?controller=products&action=show&id=<?php echo $prod_id; ?>" class="text-center p-3">
                        <img src="<?php echo htmlspecialchars($prod_img); ?>" class="card-img-top rounded-3" alt="<?php echo htmlspecialchars($prod_name); ?>" style="height: 200px; object-fit: cover;">
                    </a>

                    <div class="card-body d-flex flex-column">
                        <span class="text-muted small fw-semibold mb-1"><?php echo htmlspecialchars($prod_cat); ?></span>
                        <h6 class="card-title fw-bold mb-2">
                            <a href="index.php?controller=products&action=show&id=<?php echo $prod_id; ?>" class="text-dark text-decoration-none">
                                <?php echo htmlspecialchars($prod_name); ?>
                            </a>
                        </h6>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-danger fs-5"><?php echo $formatted_price; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- COURT PERKS -->
<section class="mb-5 bg-light py-5 rounded-4">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <i class="bi bi-truck fs-1 text-primary mb-3"></i>
                <h6 class="fw-bold">Giao Hỏa Tốc</h6>
                <p class="text-muted small">Nhận hàng trong vòng 2H nội thành</p>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-arrow-repeat fs-1 text-primary mb-3"></i>
                <h6 class="fw-bold">Đổi Trả Dễ Dàng</h6>
                <p class="text-muted small">Miễn phí đổi size trong vòng 7 ngày</p>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-shield-check fs-1 text-primary mb-3"></i>
                <h6 class="fw-bold">100% Chính Hãng</h6>
                <p class="text-muted small">Cam kết đền bù gấp đôi nếu phát hiện Fake</p>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-headset fs-1 text-primary mb-3"></i>
                <h6 class="fw-bold">Hỗ Trợ 24/7</h6>
                <p class="text-muted small">Tư vấn nhiệt tình bởi các baller thực thụ</p>
            </div>
        </div>
    </div>
</section>