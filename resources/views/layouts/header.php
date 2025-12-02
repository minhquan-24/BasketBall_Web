<?php

require_once __DIR__ . '/../../../app/models/Category.php';
$header_db_conn = (new Database())->getConnection();
$category = new Category($header_db_conn);
$categories_stmt = $category->readAll();

// **Cải tiến quan trọng**: Lấy tất cả danh mục vào một mảng để có thể lặp lại nhiều lần
$all_categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
$cart_count = 0;
if(isset($_SESSION['cart'])){
    foreach ($_SESSION['cart'] as $item){
        $cart_count += $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo isset($meta_desc) ? htmlspecialchars($meta_desc) : 'Cửa hàng giày bóng rổ chính hãng Basketball4Life. Cung cấp giày Nike, Jordan, Adidas chất lượng cao, giá tốt nhất TPHCM.'; ?>">
    <meta name="keywords" content="giày bóng rổ, basketball shoes, nike, jordan, adidas, phụ kiện bóng rổ">
    
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Basketball4Life - Giày bóng rổ chính hãng'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
<header>
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="images/logobasketball.png" alt="Logo" width="75" height="40" class="me">
                <strong>Basketball4Life</strong>
                <img src="images/logobasketball.png" alt="Logo" width="75" height="40" class="ms">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex position-relative ms-3" role="search" onsubmit="return false;"> 
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input class="form-control" type="search" id="live-search-input" placeholder="Tìm tên giày" aria-label="Search" autocomplete="off">
                    </div>
                    <div id="search-results" class="list-group position-absolute w-100 shadow mt-1" style="top: 100%; z-index: 9999; display: none;"></div>
                </form>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">    
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=contact&action=index">Liên hệ</a>
                    </li>
                    <!-- **** LOGIC CHÍNH NẰM Ở ĐÂY **** -->
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Quản lý Sản phẩm
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php?area=admin&controller=product&action=manage">View all products</a></li>
                                <?php foreach ($all_categories as $row): ?>
                                    <li><a class="dropdown-item" href="index.php?area=admin&controller=product&action=manage&category_id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></a></li>
                                <?php endforeach; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?area=admin&controller=product&action=create"><i class="bi bi-plus-circle me-2"></i>Add a product</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?area=admin&controller=user&action=index">Manage User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?area=admin&controller=order&action=index">Manage Orders</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProducts" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Products
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownProducts">
                                <li><a class="dropdown-item" href="index.php?controller=products&action=index">All products</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <?php foreach ($all_categories as $row): ?>
                                    <li>
                                        <a class="dropdown-item" href="index.php?controller=products&action=index&category_id=<?php echo $row['id']; ?>">
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
                    
                <!-- PHẦN DÀNH CHO USER -->
                <ul class="navbar-nav align-items-center">
                    <?php if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'): ?>
                        <li class="nav-item me-3">
                        <a class="nav-link position-relative" href="index.php?controller=cart&action=index">
                        <i class="bi bi-cart3 fs-5"></i>
            
                    <?php if ($cart_count > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                        <?php echo $cart_count; ?>
                        <span class="visually-hidden">unread messages</span>
                        </span>
                    <?php endif; ?>
                        </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                                <li>
                                    <a class="dropdown-item" href="index.php?controller=profile&action=index">
                                        Profile (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?controller=auth&action=logout">Logout</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <!-- Thêm dòng này vào dropdown menu của User -->
                                <?php if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'): ?>
                                    <li><a class="dropdown-item" href="index.php?controller=order&action=history">Lịch sử mua hàng</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=auth&action=login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary btn-sm text-white" href="index.php?controller=auth&action=register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Breadcrumbs (Giữ nguyên không đổi) -->
<div class="container my-3">
    <?php if (isset($breadcrumbs) && is_array($breadcrumbs)): ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <?php foreach ($breadcrumbs as $i => $crumb): ?>
                    <?php if ($i == count($breadcrumbs) - 1): ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($crumb['label']); ?></li>
                    <?php else: ?>
                        <li class="breadcrumb-item"><a href="<?php echo $crumb['url']; ?>"><?php echo htmlspecialchars($crumb['label']); ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </nav>
    <?php endif; ?>
</div>

<main class="container my-4 flex-grow-1">