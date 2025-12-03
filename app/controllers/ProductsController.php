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
        
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;


        $records_per_page = 10;
        $from_record_num = ($records_per_page * $page_num) - $records_per_page;

        $stmt = $this->productModel->readPaging($from_record_num, $records_per_page, $category_id, $sort, $keyword);
        $num = $stmt->rowCount();
        $total_rows = $this->productModel->count($category_id, $keyword);

        $category_name = null;
        if (!empty($category_id)) {
            $category = new Category($this->db); 
            $category->id = $category_id;
            $category->readOne();
            $category_name = $category->name;
        }

        if ($category_name) {
        $page_title = $category_name . " - Basketball4Life";
        $meta_desc = "Mua sắm các sản phẩm " . $category_name . " chính hãng, chất lượng cao với giá tốt nhất tại Basketball4Life.";
        } else {
            $page_title = "Tất cả sản phẩm - Basketball4Life";
            $meta_desc = "Cửa hàng giày bóng rổ uy tín số 1. Cung cấp giày Nike, Jordan, Adidas, Jersey và phụ kiện bóng rổ chính hãng.";
        }

        if ($keyword) {
        $page_title = "Kết quả tìm kiếm: '" . htmlspecialchars($keyword) . "'";
        $category_name = "Tìm kiếm: " . htmlspecialchars($keyword);
    } elseif ($category_name) {
        $page_title = $category_name;
    } else {
        $page_title = "Tất cả sản phẩm";
    }
    
    
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
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id === 0) {
            header('Location: index.php?controller=products&action=index');
            exit();
        }

        $product = $this->productModel->findById($id);

        if (!$product) {
            die('Sản phẩm không tồn tại.');
        }

        $breadcrumbs = [];
        $breadcrumbs[] = ['label' => 'Sản phẩm', 'url' => 'index.php?controller=products&action=index'];
        if (!empty($product['category_name'])) {
            $breadcrumbs[] = ['label' => $product['category_name'], 'url' => 'index.php?controller=products&action=index&category_id=' . $product['category_id']];
        }
        $breadcrumbs[] = ['label' => $product['name'], 'url' => null];

        $page_title = $product['name'] . " - Basketball4Life";
        $meta_desc = "Mua " . $product['name'] . " chính hãng. " . substr($product['description'], 0, 150) . "...";
    
        require '../resources/views/layouts/header.php';
        require '../resources/views/products/detail_user.php';
        require '../resources/views/layouts/footer.php';
    }
    
    public function searchAjax() {
    $keyword = $_GET['keyword'] ?? '';
    
    if (!empty($keyword)) {
        
        $query = "SELECT id, name, price, image_url 
                  FROM products 
                  WHERE name LIKE :keyword 
                  LIMIT 5";
                  
        $stmt = $this->db->prepare($query);
        $searchTerm = "%" . $keyword . "%"; 
        $stmt->bindParam(':keyword', $searchTerm);
        $stmt->execute();
        
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Trả về JSON (Dữ liệu máy đọc)
        header('Content-Type: application/json');
        echo json_encode($products);
        exit; 
    }
}

}