<?php
// Nạp các model cần thiết
require_once __DIR__ . '/../../../app/models/Product.php';
require_once __DIR__ . '/../../../app/models/Category.php';

class ProductController {
    private $productModel;
    private $db;
    private $categoryModel;

    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }

    /*
    Action 'manage' - Hiển thị trang quản lý sản phẩm cho Admin.
     */
    public function manage() {
        $page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
        $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at_asc';
        
        $records_per_page = 10; 
        $from_record_num = ($records_per_page * $page_num) - $records_per_page; // số item bỏ qua để xem được page hiện tại.

        $stmt = $this->productModel->readPaging($from_record_num, $records_per_page, $category_id, $sort);
        $num = $stmt->rowCount();
        $total_rows = $this->productModel->count($category_id);
        
        $category_name = null;
        if (!empty($category_id)) {
            $category = new Category($this->db); 
            $category->id = $category_id;
            $category->readOne();
            $category_name = $category->name;
        }
        
        $breadcrumbs = [];
        $breadcrumbs[] = ['label' => 'Quản lý Sản phẩm', 'url' => 'index.php?area=admin&controller=product&action=manage'];
        if($category_name){
            $breadcrumbs[] = ['label' => $category_name, 'url' => null];
        }
        
        $page_title = "Quản lý Sản phẩm";

        require_once __DIR__ . '/../../../resources/views/layouts/header.php';
        require_once __DIR__ . '/../../../resources/views/products/manage.php';
        require_once __DIR__ . '/../../../resources/views/layouts/footer.php';
    }

    // Các action khác (create, store, edit, update, destroy) sẽ được thêm vào đây
    // ... (hàm manage giữ nguyên) ...
    public function create() {
        // Lấy danh sách danh mục để hiển thị trong form
        $categories_stmt = $this->categoryModel->readAll();
        $all_categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);

        $breadcrumbs = [
            ['label' => 'Quản lý Sản phẩm', 'url' => 'index.php?area=admin&controller=product&action=manage'],
            ['label' => 'Thêm mới', 'url' => null]
        ];

        $page_title = "Thêm sản phẩm mới";
        require '../resources/views/layouts/header.php';
        require '../resources/views/products/create.php';
        require '../resources/views/layouts/footer.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gán dữ liệu từ POST vào model
            $this->productModel->name = $_POST['name'];
            $this->productModel->description = $_POST['description'];
            $this->productModel->price = $_POST['price'];
            $this->productModel->manufacturer = $_POST['manufacturer'];
            $this->productModel->usage_type = $_POST['usage_type'];
            $this->productModel->category_id = $_POST['category_id'];
            $this->productModel->image_url = $_POST['image_url']; // Tạm thời dùng URL, sau này có thể nâng cấp upload file
            
            // Validation (bạn có thể thêm logic kiểm tra dữ liệu ở đây)

            if ($this->productModel->create()) {
                $variantsData = $_POST['variants'] ?? [];
                $this->productModel->syncVariants($variantsData);
                header("Location: index.php?area=admin&controller=product&action=manage&status=create_success");
                exit();
            } else {
                header("Location: index.php?area=admin&controller=product&action=create&status=create_failed");
                exit();
            }
        }
    }

    public function edit() {
        // Lấy ID từ URL
        $this->productModel->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

        // Gọi model để đọc thông tin sản phẩm hiện tại
        if (!$this->productModel->readOne()) {
            die('Sản phẩm không tồn tại.');
        }

        // Lấy danh sách danh mục để hiển thị trong form
        $categories_stmt = $this->categoryModel->readAll();
        $all_categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
        $product_variants = $this->productModel->getVariants();
        
        $breadcrumbs = [
            ['label' => 'Quản lý Sản phẩm', 'url' => 'index.php?area=admin&controller=product&action=manage'],
            ['label' => 'Sửa sản phẩm', 'url' => null]
        ];
        $page_title = "Sửa: " . $this->productModel->name;

        require '../resources/views/layouts/header.php';
        require '../resources/views/products/edit.php';
        require '../resources/views/layouts/footer.php';
    }

    /**
     * Action xử lý dữ liệu từ form sửa và cập nhật vào database.
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gán dữ liệu từ form vào đối tượng model
            $this->productModel->id = $_POST['id'];
            $this->productModel->name = $_POST['name'];
            $this->productModel->description = $_POST['description'];
            $this->productModel->price = $_POST['price'];
            $this->productModel->manufacturer = $_POST['manufacturer'];
            $this->productModel->usage_type = $_POST['usage_type'];
            $this->productModel->category_id = $_POST['category_id'];
            $this->productModel->image_url = $_POST['image_url'];

            if ($this->productModel->update()) {
                $variantsData = $_POST['variants'] ?? [];
                $this->productModel->syncVariants($variantsData);
                header("Location: index.php?area=admin&controller=product&action=manage&status=update_success");
                exit();
            } else {
                header("Location: index.php?area=admin&controller=product&action=edit&id=" . $_POST['id'] . "&status=update_failed");
                exit();
            }
        }
    }

    public function delete() {
        $this->productModel->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
        
        if ($this->productModel->delete()) {
            header("Location: index.php?area=admin&controller=product&action=manage&status=delete_success");
            exit();
        } else {
            header("Location: index.php?area=admin&controller=product&action=manage&status=delete_failed");
            exit();
        }
    }

    public function show(){
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if($id === 0){
            die("ERROR: missing ID.");
        }
        $product = $this->productModel->findbyID($id);
        if (!$product) { die('Sản phẩm không tồn tại.'); }

        $breadcrumbs = [];
        $breadcrumbs[] = ['label' => 'Quản lý sản phẩm', 'url' => 'index.php?area=admin&controller=product&action=manage'];
        if(!empty($product['category_name'])){
            $breadcrumbs[] = ['label' => $product['category_name'] , 'url' => 'index.php?area=admin&controller=product&action=manage&category_id=' . $product['category_id']]; 
        }
        $breadcrumbs[] = ['label' => $product['name'], 'url' => null];

        $page_title = "Chi tiết kho: " . $product['name'];

        require '../resources/views/layouts/header.php';
        require '../resources/views/products/detail_admin.php';
        require '../resources/views/layouts/footer.php';
    }
}