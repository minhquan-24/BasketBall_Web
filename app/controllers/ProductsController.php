<?php

class ProductsController {
    private $productModel;
    private $db; 
    public function __construct($db) {
        $this->db = $db; 
        $this->productModel = new Product($this->db);
    }

    public function index() {
        $page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
        $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at_asc';
        
        $records_per_page = 10;
        $from_record_num = ($records_per_page * $page_num) - $records_per_page;

        $stmt = $this->productModel->readPaging($from_record_num, $records_per_page, $category_id, $sort);
        $num = $stmt->rowCount();
        $total_rows = $this->productModel->count($category_id);

        $category_name = null;
        if (!empty($category_id)) {
            // Sử dụng kết nối DB của chính controller, không lấy từ model khác
            $category = new Category($this->db); 
            $category->id = $category_id;
            $category->readOne();
            $category_name = $category->name;
        }

        if ($category_name) {
        // Nếu đang xem danh mục cụ thể
        $page_title = $category_name . " - Basketball4Life";
        $meta_desc = "Mua sắm các sản phẩm " . $category_name . " chính hãng, chất lượng cao với giá tốt nhất tại Basketball4Life.";
    } else {
        // Nếu đang ở trang chủ (Tất cả sản phẩm)
        $page_title = "Tất cả sản phẩm - Basketball4Life";
        $meta_desc = "Cửa hàng giày bóng rổ uy tín số 1. Cung cấp giày Nike, Jordan, Adidas, Jersey và phụ kiện bóng rổ chính hãng.";
    }
    
        // --- BREADCRUMBS LOGIC ---
        $breadcrumbs = [];
        $breadcrumbs[] = ['label' => 'Sản phẩm', 'url' => 'index.php?controller=products&action=index'];
        if ($category_name) {
            $breadcrumbs[] = ['label' => $category_name, 'url' => null];
        }
        
        require '../resources/views/layouts/header.php';
        require '../resources/views/products/index.php';
        require '../resources/views/layouts/footer.php';
    }

    public function show() {
        // Lấy ID từ URL, ví dụ: index.php?controller=products&action=show&id=1
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id === 0) {
            // Nếu không có ID, chuyển về trang lỗi hoặc trang sản phẩm
            header('Location: index.php?controller=products&action=index');
            exit();
        }

        // Gọi model để lấy dữ liệu chi tiết sản phẩm
        $product = $this->productModel->findById($id);

        if (!$product) {
            // Nếu không tìm thấy sản phẩm, có thể hiển thị trang 404
            die('Sản phẩm không tồn tại.');
        }
        // BREADCRUMBS LOGIC
        $breadcrumbs = [];
        $breadcrumbs[] = ['label' => 'Sản phẩm', 'url' => 'index.php?controller=products&action=index'];
        if (!empty($product['category_name'])) {
            $breadcrumbs[] = ['label' => $product['category_name'], 'url' => 'index.php?controller=products&action=index&category_id=' . $product['category_id']];
        }
        $breadcrumbs[] = ['label' => $product['name'], 'url' => null]; // Item cuối

        $page_title = $product['name'] . " - Basketball4Life";
        $meta_desc = "Mua " . $product['name'] . " chính hãng. " . substr($product['description'], 0, 150) . "...";
    
        // Gọi view để hiển thị
        require '../resources/views/layouts/header.php';
        require '../resources/views/products/detail_user.php';
        require '../resources/views/layouts/footer.php';
    }
    
    // Sau này sẽ có các hàm khác như public function show($id) { ... }
}