<?php
// Fallback curated products if database query is empty
$default_featured_items = [
    [
        'id' => 1,
        'name' => 'Nike LeBron 20 "Time Machine"',
        'category_name' => 'Basketball Shoe',
        'price' => 4850000,
        'image_url' => 'images/lebron20-1.png',
        'badge' => 'BEST SELLER',
        'rating' => 5
    ],
    [
        'id' => 3,
        'name' => 'Under Armour Curry Flow 10',
        'category_name' => 'Basketball Shoe',
        'price' => 3950000,
        'image_url' => 'images/curry10.jpg',
        'badge' => 'HOT DROP',
        'rating' => 5
    ],
    [
        'id' => 2,
        'name' => 'Jordan Zion 1 "Z-3D"',
        'category_name' => 'Basketball Shoe',
        'price' => 3290000,
        'image_url' => 'images/zion1.webp',
        'badge' => 'GIẢM 15%',
        'rating' => 5
    ],
    [
        'id' => 6,
        'name' => 'Nike Kyrie Flytrap 5 "Ocean Cube"',
        'category_name' => 'Basketball Shoe',
        'price' => 2190000,
        'image_url' => 'images/kyrieflytrap5.jpg',
        'badge' => 'SPEED GRIP',
        'rating' => 5
    ],
    [
        'id' => 4,
        'name' => 'Adidas Harden Vol. 7',
        'category_name' => 'Basketball Shoe',
        'price' => 3650000,
        'image_url' => 'images/harden7.jpg',
        'badge' => 'NEW',
        'rating' => 5
    ],
    [
        'id' => 5,
        'name' => 'Bóng Wilson FIBA 3x3 Official',
        'category_name' => 'Ball',
        'price' => 950000,
        'image_url' => 'images/wilson3x3.jpg',
        'badge' => 'OFFICIAL',
        'rating' => 5
    ]
];

$display_products = (!empty($featured_products) && is_array($featured_products)) 
    ? $featured_products 
    : $default_featured_items;
?>

<!-- =========================================================================
     SECTION 1: EPIC COURT HERO (HERO BÙNG NỔ & TƯƠNG TÁC NÉM RỔ)
     ========================================================================= -->
<section class="hero-court-section mb-4" aria-label="Hero Banner">
    <div class="row align-items-center g-4">
        <!-- Cột Trái: Thông điệp & Kêu gọi hành động -->
        <div class="col-lg-7">
            <div class="hero-live-badge mb-3">
                <span class="pulse-dot"></span>
                <span>NBA EDITION 2025/2026 • OFFICIAL STORE</span>
            </div>

            <h1 class="hero-title mb-3">
                LÀM CHỦ BẢNG RỔ<br>
                <span class="text-gradient-orange">BỨT PHÁ MỌI GIỚI HẠN</span>
            </h1>

            <p class="hero-desc mb-4">
                Chuyên cung cấp những mẫu giày bóng rổ đỉnh cao, lực bật Zoom Air bùng nổ, độ bám sân tuyệt đối và phụ kiện thi đấu chính hãng 100% từ Nike, Jordan, Adidas, Curry.
            </p>

            <div class="d-flex flex-wrap gap-3 mb-4">
                <a href="index.php?controller=products&action=index" class="btn-bb-primary">
                    <span>Khám phá bộ sưu tập</span>
                    <i class="bi bi-arrow-right-circle-fill fs-5"></i>
                </a>
                <a href="#best-sellers" class="btn-bb-outline">
                    <i class="bi bi-fire text-warning"></i>
                    <span>Sản phẩm bán chạy</span>
                </a>
            </div>

            <!-- Thống kê bảo chứng uy tín -->
            <div class="row g-3 hero-stats-row">
                <div class="col-3 hero-stat-item">
                    <span class="hero-stat-num">100%</span>
                    <span class="hero-stat-label">Chính hãng</span>
                </div>
                <div class="col-3 hero-stat-item">
                    <span class="hero-stat-num">2H</span>
                    <span class="hero-stat-label">Giao hỏa tốc</span>
                </div>
                <div class="col-3 hero-stat-item">
                    <span class="hero-stat-num">7 Ngày</span>
                    <span class="hero-stat-label">Đổi trả free</span>
                </div>
                <div class="col-3 hero-stat-item">
                    <span class="hero-stat-num">5.0 ★</span>
                    <span class="hero-stat-label">10k+ Ballers</span>
                </div>
            </div>
        </div>

        <!-- Cột Phải: Visual giày xoay 3D & Mini Game Ném Rổ Tương Tác -->
        <div class="col-lg-5">
            <div class="hero-visual-stage">
                <!-- Vòng quỹ đạo sân bóng rổ quay liên tục -->
                <div class="court-orbit-ring"></div>

                <!-- Badge công nghệ 1 -->
                <div class="floating-pill floating-pill-1">
                    <i class="bi bi-lightning-charge-fill text-warning"></i>
                    <span>Zoom Air Cushioning</span>
                </div>

                <!-- Giày chiến LeBron 20 nổi bồng bềnh -->
                <div class="hero-main-shoe-wrap">
                    <img src="images/lebron20-1.png" alt="Nike LeBron 20 Court Ready" class="hero-main-shoe-img" onerror="this.src='images/wilson.png'">
                </div>

                <!-- Badge công nghệ 2 -->
                <div class="floating-pill floating-pill-2">
                    <i class="bi bi-shield-check text-success"></i>
                    <span>Traction Grip: 9.9/10</span>
                </div>

                <!-- Rổ bóng rổ mini để tương tác ném bóng -->
                <div class="interactive-shoot-box">
                    <div class="mini-hoop">
                        <div class="hoop-backboard"></div>
                        <div class="hoop-rim"></div>
                        <div class="hoop-net" id="mini-hoop-net"></div>
                    </div>
                    <div class="score-toast" id="score-toast">SWISH! +3 PTS 🔥</div>
                </div>

                <!-- Quả bóng rổ tương tác nảy tưng tưng (Click để ném vào rổ) -->
                <div class="interactive-ball-wrap" id="interactive-ball-wrap" title="Nhấn vào bóng để thử ném 3 điểm!">
                    <div class="interactive-ball" id="interactive-ball"></div>
                    <div class="ball-shadow"></div>
                    <div class="shoot-hint"><i class="bi bi-hand-index-thumb"></i> Click ném rổ!</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
     SECTION 2: INFINITE BRAND MARQUEE (DẢI THƯƠNG HIỆU CHUYỂN ĐỘNG VÔ TẬN)
     ========================================================================= -->
<div class="bb-marquee-wrapper" aria-hidden="true">
    <div class="bb-marquee-track">
        <div class="bb-marquee-item"><i class="bi bi-dribbble"></i> NIKE HOOPS</div>
        <div class="bb-marquee-item"><span class="gold-star">★</span> AIR JORDAN</div>
        <div class="bb-marquee-item"><i class="bi bi-fire"></i> ADIDAS BASKETBALL</div>
        <div class="bb-marquee-item"><i class="bi bi-lightning-charge-fill"></i> CURRY BRAND</div>
        <div class="bb-marquee-item"><i class="bi bi-trophy-fill text-warning"></i> PUMA HOOPS</div>
        <div class="bb-marquee-item"><i class="bi bi-dribbble"></i> WILSON OFFICIAL NBA</div>
        <div class="bb-marquee-item"><span class="gold-star">★</span> MOLTEN FIBA</div>
        <div class="bb-marquee-item"><i class="bi bi-patch-check-fill"></i> SPALDING STREET</div>
        <!-- Lặp lại track để chạy vô tận không bị giật -->
        <div class="bb-marquee-item"><i class="bi bi-dribbble"></i> NIKE HOOPS</div>
        <div class="bb-marquee-item"><span class="gold-star">★</span> AIR JORDAN</div>
        <div class="bb-marquee-item"><i class="bi bi-fire"></i> ADIDAS BASKETBALL</div>
        <div class="bb-marquee-item"><i class="bi bi-lightning-charge-fill"></i> CURRY BRAND</div>
        <div class="bb-marquee-item"><i class="bi bi-trophy-fill text-warning"></i> PUMA HOOPS</div>
        <div class="bb-marquee-item"><i class="bi bi-dribbble"></i> WILSON OFFICIAL NBA</div>
        <div class="bb-marquee-item"><span class="gold-star">★</span> MOLTEN FIBA</div>
        <div class="bb-marquee-item"><i class="bi bi-patch-check-fill"></i> SPALDING STREET</div>
    </div>
</div>

<!-- =========================================================================
     SECTION 3: MASCOT ARENA & TƯ VẤN VỊ TRÍ THI ĐẤU (LINH VẬT SÂN ĐẤU)
     ========================================================================= -->
<section class="mascot-court-banner mb-5" aria-label="Tư vấn cùng linh vật">
    <div class="row align-items-center g-4">
        <!-- Linh vật Bò Tót Taurus #23 phong cách thể thao -->
        <div class="col-md-3 text-center">
            <div class="mascot-avatar-wrap">
                <svg class="mascot-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <radialGradient id="bullGlow" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#ff7043" />
                            <stop offset="100%" stop-color="#bf360c" />
                        </radialGradient>
                        <radialGradient id="hornGlow" cx="50%" cy="30%" r="70%">
                            <stop offset="0%" stop-color="#ffb703" />
                            <stop offset="100%" stop-color="#e65100" />
                        </radialGradient>
                    </defs>

                    <!-- Vòng hào quang phía sau -->
                    <circle cx="100" cy="100" r="85" fill="#11141a" stroke="#ff5722" stroke-width="4" stroke-dasharray="6,4" />

                    <!-- Thân áo số 23 Basketball4Life -->
                    <path d="M50 170 Q100 150 150 170 L160 200 L40 200 Z" fill="#d32f2f" stroke="#111" stroke-width="3"/>
                    <path d="M70 170 L100 195 L130 170" fill="none" stroke="#fff" stroke-width="3"/>
                    <text x="100" y="192" font-family="'Montserrat', sans-serif" font-weight="900" font-size="20" fill="#fff" text-anchor="middle">23</text>

                    <!-- Sừng Bò Tót (Chicago Bulls style) -->
                    <path d="M45 75 Q20 50 18 18 Q40 38 65 58 Z" fill="url(#hornGlow)" stroke="#111" stroke-width="3"/>
                    <path d="M155 75 Q180 50 182 18 Q160 38 135 58 Z" fill="url(#hornGlow)" stroke="#111" stroke-width="3"/>

                    <!-- Đầu & Khuôn mặt chiến binh -->
                    <ellipse cx="100" cy="95" rx="52" ry="46" fill="url(#bullGlow)" stroke="#111" stroke-width="3"/>
                    
                    <!-- Băng đô trán thể thao -->
                    <path d="M52 68 Q100 58 148 68 L145 80 Q100 70 55 80 Z" fill="#11141a" stroke="#ffb703" stroke-width="2"/>
                    <text x="100" y="76" font-family="sans-serif" font-weight="900" font-size="8" fill="#ffb703" text-anchor="middle">B4L HOOPS</text>

                    <!-- Mắt phát sáng nhấp nháy -->
                    <polygon points="72,92 86,96 74,102" fill="#fff" class="mascot-eye"/>
                    <polygon points="128,92 114,96 126,102" fill="#fff" class="mascot-eye"/>
                    <circle cx="80" cy="96" r="3" fill="#ffeb3b"/>
                    <circle cx="120" cy="96" r="3" fill="#ffeb3b"/>

                    <!-- Mũi bò tót & Khuyên vàng đặc trưng -->
                    <ellipse cx="100" cy="116" rx="28" ry="18" fill="#e64a19" stroke="#111" stroke-width="2"/>
                    <circle cx="92" cy="114" r="4" fill="#111"/>
                    <circle cx="108" cy="114" r="4" fill="#111"/>
                    <circle cx="100" cy="126" r="10" fill="none" stroke="#ffb703" stroke-width="3"/>

                    <!-- Quả bóng rổ đang xoay trên ngón tay -->
                    <g class="mascot-spinning-ball">
                        <circle cx="135" cy="45" r="18" fill="#ff7043" stroke="#111" stroke-width="2"/>
                        <line x1="117" y1="45" x2="153" y2="45" stroke="#111" stroke-width="1.5"/>
                        <line x1="135" y1="27" x2="135" y2="63" stroke="#111" stroke-width="1.5"/>
                    </g>
                </svg>
            </div>
            <div class="mt-2 text-warning fw-bold small"><i class="bi bi-fire"></i> TAURUS #23 • MASCOT</div>
        </div>

        <!-- Bong bóng thoại tư vấn chọn giày theo lối chơi -->
        <div class="col-md-9">
            <div class="mascot-speech-bubble">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-danger">CHIẾN THUẬT SÂN ĐẤU</span>
                    <strong class="text-dark">Linh Vật Taurus Nhận Diện Phong Cách Của Bạn:</strong>
                </div>

                <div id="mascot-speech-text" style="transition: opacity 0.25s ease;">
                    Yo Baller! Bạn thường thi đấu ở vai trò nào trên sân? Nhấn vào các vị trí bên dưới để Taurus tư vấn dòng giày phù hợp nhất giúp bạn phát huy tối đa sức mạnh!
                </div>

                <div class="playstyle-btn-group">
                    <button type="button" class="btn-playstyle active" data-style="guard">
                        ⚡ Point Guard / Shooting Guard (Hậu vệ)
                    </button>
                    <button type="button" class="btn-playstyle" data-style="forward">
                        🚀 Small Forward / Power Forward (Tiền đạo)
                    </button>
                    <button type="button" class="btn-playstyle" data-style="center">
                        🛡️ Center (Trung phong)
                    </button>
                    <button type="button" class="btn-playstyle" data-style="allround">
                        🌟 All-Around (Toàn diện)
                    </button>
                </div>

                <div class="mt-3">
                    <a href="index.php?controller=products&action=index&keyword=Curry" id="mascot-speech-action" class="btn btn-sm btn-danger fw-bold rounded-pill px-3">
                        Xem các mẫu giày được khuyên dùng <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
     SECTION 4: FEATURED CATEGORIES (DANH MỤC TRANG BỊ NỔI BẬT)
     ========================================================================= -->
<section class="mb-5" aria-label="Danh mục nổi bật">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <div class="section-sub-badge">PRO GEAR CATEGORIES</div>
            <h2 class="section-head-title">Danh Mục Trang Bị</h2>
        </div>
        <a href="index.php?controller=products&action=index" class="text-danger fw-bold text-decoration-none">
            Xem tất cả danh mục <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
        <!-- Category 1: Giày bóng rổ -->
        <div class="col">
            <a href="index.php?controller=products&action=index&category_id=1" class="category-card">
                <div class="category-card-img-wrap">
                    <img src="images/lebron20-1.png" alt="Giày bóng rổ chính hãng" onerror="this.src='images/curry10.jpg'">
                </div>
                <div class="category-card-body">
                    <span class="category-tag">TOP HOT</span>
                    <h3 class="category-title">Giày Bóng Rổ</h3>
                    <p class="text-muted small mb-2">Nike, Jordan, Curry, Adidas Signature</p>
                    <span class="category-action-link">Khám phá ngay <i class="bi bi-chevron-right"></i></span>
                </div>
            </a>
        </div>

        <!-- Category 2: Bóng thi đấu -->
        <div class="col">
            <a href="index.php?controller=products&action=index&category_id=2" class="category-card">
                <div class="category-card-img-wrap">
                    <img src="images/wilson.png" alt="Bóng rổ thi đấu NBA" onerror="this.src='images/wilson3x3.jpg'">
                </div>
                <div class="category-card-body">
                    <span class="category-tag">NBA & FIBA</span>
                    <h3 class="category-title">Bóng Thi Đấu</h3>
                    <p class="text-muted small mb-2">Wilson, Molten, Tarmak, Spalding</p>
                    <span class="category-action-link">Khám phá ngay <i class="bi bi-chevron-right"></i></span>
                </div>
            </a>
        </div>

        <!-- Category 3: Áo & Jersey NBA -->
        <div class="col">
            <a href="index.php?controller=products&action=index&category_id=3" class="category-card">
                <div class="category-card-img-wrap">
                    <img src="images/lakerjersey.jpg" alt="Đồng phục & Jersey NBA" onerror="this.src='images/celtic.jpg'">
                </div>
                <div class="category-card-body">
                    <span class="category-tag">AUTHENTIC</span>
                    <h3 class="category-title">Đồng Phục & Jersey</h3>
                    <p class="text-muted small mb-2">Lakers, Warriors, Celtics, Bulls</p>
                    <span class="category-action-link">Khám phá ngay <i class="bi bi-chevron-right"></i></span>
                </div>
            </a>
        </div>

        <!-- Category 4: Phụ kiện & Balo -->
        <div class="col">
            <a href="index.php?controller=products&action=index&category_id=4" class="category-card">
                <div class="category-card-img-wrap">
                    <img src="images/elite1.jpg" alt="Túi & Phụ kiện bóng rổ" onerror="this.src='images/elite4.png'">
                </div>
                <div class="category-card-body">
                    <span class="category-tag">PRO PROTECTION</span>
                    <h3 class="category-title">Túi & Phụ Kiện</h3>
                    <p class="text-muted small mb-2">Vớ Nike Elite, bó gối, balo đựng bóng</p>
                    <span class="category-action-link">Khám phá ngay <i class="bi bi-chevron-right"></i></span>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- =========================================================================
     SECTION 5: BEST-SELLERS & HOT PICKS (SẢN PHẨM NỔI BẬT NHẤT)
     ========================================================================= -->
<section id="best-sellers" class="mb-5" aria-label="Sản phẩm bán chạy">
    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
        <div>
            <div class="section-sub-badge"><i class="bi bi-fire"></i> SÂN ĐẤU NỔI BẬT</div>
            <h2 class="section-head-title">Sản Phẩm Đang Được Săn Đón</h2>
        </div>
        <a href="index.php?controller=products&action=index" class="btn btn-outline-dark rounded-pill btn-sm px-3 fw-bold">
            Xem tất cả sản phẩm <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4">
        <?php foreach ($display_products as $prod): 
            $prod_id = $prod['id'] ?? 1;
            $prod_name = $prod['name'] ?? 'Giày bóng rổ';
            $prod_price = is_numeric($prod['price']) ? (float)$prod['price'] : 2500000;
            // Nếu giá tiền dưới 10,000 (dạng USD trong mock database cũ), hiển thị theo quy đổi tỷ giá
            $formatted_price = ($prod_price < 1000) 
                ? number_format($prod_price * 25400, 0, ',', '.') . ' VNĐ'
                : number_format($prod_price, 0, ',', '.') . ' VNĐ';
            $prod_img = !empty($prod['image_url']) ? $prod['image_url'] : 'images/lebron20-1.png';
            $prod_cat = $prod['category_name'] ?? 'Bóng Rổ';
            $prod_badge = $prod['badge'] ?? 'HOT DEAL';
        ?>
            <div class="col">
                <div class="product-sport-card">
                    <span class="product-badge badge-hot"><?php echo htmlspecialchars($prod_badge); ?></span>
                    
                    <a href="index.php?controller=products&action=show&id=<?php echo $prod_id; ?>">
                        <div class="product-image-container">
                            <img src="<?php echo htmlspecialchars($prod_img); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($prod_name); ?>"
                                 onerror="this.src='images/wilson.png'">
                        </div>
                    </a>

                    <div class="product-sport-body">
                        <span class="product-category-chip"><?php echo htmlspecialchars($prod_cat); ?></span>
                        <h4 class="product-card-title">
                            <a href="index.php?controller=products&action=show&id=<?php echo $prod_id; ?>">
                                <?php echo htmlspecialchars($prod_name); ?>
                            </a>
                        </h4>

                        <div class="rating-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span class="text-muted small ms-1">(5.0)</span>
                        </div>

                        <div class="product-price-tag">
                            <?php echo $formatted_price; ?>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="index.php?controller=products&action=show&id=<?php echo $prod_id; ?>" class="btn-card-action w-100">
                                <span>Xem chi tiết</span>
                                <i class="bi bi-arrow-right-short fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- =========================================================================
     SECTION 6: UPGRADED COURT BALL SHOWCASE (SHOWCASE BANH BÓNG RỔ SIÊU MƯỢT)
     ========================================================================= -->
<section class="home-shoe-showcase" aria-label="Bộ sưu tập bóng rổ">
    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
        <div>
            <div class="section-sub-badge"><i class="bi bi-dribbble"></i> NBA & FIBA STANDARDS</div>
            <h2 class="fw-bold mb-0 text-white">Vũ Khí Mặt Sân - Bộ Sưu Tập Banh Bóng Rổ</h2>
        </div>
        <a href="index.php?controller=products&action=index&category_id=2" class="text-warning fw-bold text-decoration-none">
            Xem tất cả bóng rổ <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="home-shoe-window">
        <div class="home-shoe-track">
            <?php
            $home_balls = [
                ['image' => 'adidas.avif', 'name' => 'Adidas All-Court Pro', 'spec' => 'Indoor & Outdoor • Da PU 8 mảnh'],
                ['image' => 'curry10.avif', 'name' => 'Curry Splash Edition', 'spec' => 'Official Size 7 • Siêu bám tay'],
                ['image' => 'kobeball.avif', 'name' => 'Mamba 24 Special', 'spec' => 'Kobe Tribute • Da PU cao cấp'],
                ['image' => 'puma.avif', 'name' => 'Puma Street Rise', 'spec' => 'Chống mài mòn sân bê tông'],
                ['image' => 'tarmak.avif', 'name' => 'Tarmak BT500 Grip', 'spec' => 'Đạt chuẩn FIBA thi đấu'],
                ['image' => 'jordan.webp', 'name' => 'Jordan Legacy Ball', 'spec' => 'Cảm giác bóng đỉnh cao'],
                // Lặp lại để track trượt liên tục mượt mà
                ['image' => 'adidas.avif', 'name' => 'Adidas All-Court Pro', 'spec' => 'Indoor & Outdoor • Da PU 8 mảnh'],
                ['image' => 'curry10.avif', 'name' => 'Curry Splash Edition', 'spec' => 'Official Size 7 • Siêu bám tay'],
                ['image' => 'kobeball.avif', 'name' => 'Mamba 24 Special', 'spec' => 'Kobe Tribute • Da PU cao cấp'],
                ['image' => 'puma.avif', 'name' => 'Puma Street Rise', 'spec' => 'Chống mài mòn sân bê tông'],
            ];
            foreach ($home_balls as $ball):
            ?>
                <a class="home-shoe-card" href="index.php?controller=products&action=index&category_id=2">
                    <img src="images/<?php echo htmlspecialchars($ball['image']); ?>" alt="<?php echo htmlspecialchars($ball['name']); ?>" onerror="this.src='images/wilson.png'">
                    <div class="shoe-info-badge">
                        <strong><?php echo htmlspecialchars($ball['name']); ?></strong>
                        <span class="shoe-spec"><?php echo htmlspecialchars($ball['spec']); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========================================================================
     SECTION 7: COURT PERKS (ĐẶC QUYỀN DÀNH CHO BALLERS)
     ========================================================================= -->
<section class="mb-5" aria-label="Đặc quyền dịch vụ">
    <div class="row g-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="perk-card">
                <div class="perk-icon-wrap">
                    <i class="bi bi-truck-front"></i>
                </div>
                <div>
                    <h3 class="perk-title">Giao Hỏa Tốc 2H</h3>
                    <p class="perk-desc">Nhận giày chiến ngay trước giờ ra sân thi đấu chiều nay.</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="perk-card">
                <div class="perk-icon-wrap">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div>
                    <h3 class="perk-title">Đổi Size 7 Ngày</h3>
                    <p class="perk-desc">Thử chân tại nhà, đổi size nhanh chóng hoàn toàn miễn phí.</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="perk-card">
                <div class="perk-icon-wrap">
                    <i class="bi bi-shield-shaded"></i>
                </div>
                <div>
                    <h3 class="perk-title">100% Authentic</h3>
                    <p class="perk-desc">Cam kết chính hãng trọn đời. Đền bù gấp đôi nếu phát hiện fake.</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="perk-card">
                <div class="perk-icon-wrap">
                    <i class="bi bi-chat-heart"></i>
                </div>
                <div>
                    <h3 class="perk-title">Tư Vấn Chuẩn Size</h3>
                    <p class="perk-desc">Đội ngũ tư vấn là Ballers kinh nghiệm chọn form theo bề ngang chân.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
     SECTION 8: VIP CLUB / SLAM DUNK CTA (GIA NHẬP CỘNG ĐỒNG)
     ========================================================================= -->
<section class="vip-court-banner" aria-label="Gia nhập cộng đồng Baller">
    <div class="position-relative" style="z-index: 2;">
        <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">
            🏀 EXCLUSIVE BALLER CLUB
        </span>
        <h2 class="vip-title">Gia Nhập Cộng Đồng Basketball4Life</h2>
        <p class="vip-desc">
            Đăng ký để nhận sớm thông tin các phiên bản giày phát hành giới hạn (Limited Drops) và nhận ngay Voucher giảm giá 10% cho đơn hàng đầu tiên!
        </p>

        <form class="vip-subscribe-form" onsubmit="alert('Cảm ơn Baller! Mã giảm giá 10% [BALLER10] đã được gửi tới email của bạn!'); return false;">
            <input type="email" class="form-control vip-input" placeholder="Nhập địa chỉ email của bạn..." required>
            <button type="submit" class="btn-bb-primary flex-shrink-0">
                <span>Nhận mã 10%</span>
                <i class="bi bi-send-fill"></i>
            </button>
        </form>
    </div>
</section>