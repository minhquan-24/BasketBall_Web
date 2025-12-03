<?php

class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $description;
    public $price;
    public $image_url;
    public $category_id;
    public $created_at;
    public $category_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Đọc tất cả sản phẩm từ database.
     * @return PDOStatement Đối tượng statement để có thể lặp qua.
     */
    // public function read($category_id = null) {
    //     $query = "
    //         SELECT 
    //             c.name as category_name, p.*
    //         FROM 
    //             " . $this->table_name . " p
    //         LEFT JOIN 
    //             categories c ON p.category_id = c.id
    //     ";

    //     // Thêm điều kiện WHERE nếu có category_id được truyền vào
    //     if ($category_id !== null) {
    //         $query .= " WHERE p.category_id = :category_id";
    //     }

    //     $query .= " ORDER BY p.created_at DESC";
        
    //     $stmt = $this->conn->prepare($query);

    //     // Gán giá trị cho :category_id nếu cần
    //     if ($category_id !== null) {
    //         $stmt->bindParam(":category_id", $category_id);
    //     }
        
    //     $stmt->execute();
        
    //     return $stmt;
    // }

    /**
     * Đọc sản phẩm có phân trang, lọc và sắp xếp.
     * @param int $from_record_num Vị trí bắt đầu lấy.
     * @param int $records_per_page Số lượng sản phẩm mỗi trang.
     * @param int|null $category_id ID danh mục để lọc.
     * @param string $sort Sắp xếp theo 'price_asc' hoặc 'price_desc'.
     * @return PDOStatement
     */
    // public function readPaging($from_record_num, $records_per_page, $category_id = null, $sort = 'created_at_desc') {
    //     $query = "
    //         SELECT c.name as category_name, p.*
    //         FROM " . $this->table_name . " p
    //         LEFT JOIN categories c ON p.category_id = c.id
    //     ";
        
    //     // Lọc theo danh mục
    //     if ($category_id !== null) {
    //         $query .= " WHERE p.category_id = :category_id";
    //     }

    //     // Sắp xếp
    //     switch ($sort) {
    //         case 'price_asc':
    //             $order_by = "p.price ASC";
    //             break;
    //         case 'price_desc':
    //             $order_by = "p.price DESC";
    //             break;
    //         case 'created_at_asc':
    //             $order_by = "p.id ASC";
    //             break;
    //         default: 
    //             $order_by = "p.created_at DESC";
    //             break;
    //     }
    //     $query .= " ORDER BY {$order_by}";

    //     // Phân trang
    //     $query .= " LIMIT :from_record_num, :records_per_page";

    //     $stmt = $this->conn->prepare($query);

    //     if ($category_id !== null) {
    //         $stmt->bindParam(":category_id", $category_id);
    //     }
    //     $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
    //     $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
        
    //     $stmt->execute();
    //     return $stmt;
    // }

    // /**
    //  * Đếm tổng số sản phẩm (cần cho phân trang).
    //  * @param int|null $category_id ID danh mục để lọc.
    //  * @return int Tổng số sản phẩm.
    //  */
    // public function count($category_id = null) {
    //     $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name;
    //     if ($category_id !== null) {
    //         $query .= " WHERE category_id = :category_id";
    //     }

    //     $stmt = $this->conn->prepare($query);
    //     if ($category_id !== null) {
    //         $stmt->bindParam(":category_id", $category_id);
    //     }
        
    //     $stmt->execute();
    //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $row['total_rows'];
    // }

    public function readPaging($from_record_num, $records_per_page, $category_id = null, $sort = 'created_at_desc', $keyword = null) {
    $query = "
        SELECT c.name as category_name, p.*
        FROM " . $this->table_name . " p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE 1=1 
    ";
    
    if ($category_id !== null) {
        $query .= " AND p.category_id = :category_id";
    }

    if ($keyword !== null) {
        $query .= " AND p.name LIKE :keyword";
    }

    switch ($sort) {
        case 'price_asc': $order_by = "p.price ASC"; break;
        case 'price_desc': $order_by = "p.price DESC"; break;
        default: $order_by = "p.created_at DESC"; break;
    }
    $query .= " ORDER BY {$order_by} LIMIT :from_record_num, :records_per_page";

    $stmt = $this->conn->prepare($query);

    if ($category_id !== null) $stmt->bindParam(":category_id", $category_id);
    if ($keyword !== null) {
        $searchTerm = "%{$keyword}%";
        $stmt->bindParam(":keyword", $searchTerm);
    }
    
    $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt;
}

public function count($category_id = null, $keyword = null) {
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " WHERE 1=1";
    
    if ($category_id !== null) $query .= " AND category_id = :category_id";
    if ($keyword !== null) $query .= " AND name LIKE :keyword";

    $stmt = $this->conn->prepare($query);
    
    if ($category_id !== null) $stmt->bindParam(":category_id", $category_id);
    if ($keyword !== null) {
        $searchTerm = "%{$keyword}%";
        $stmt->bindParam(":keyword", $searchTerm);
    }
    
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total_rows'];
}

    public function findById($id) {
        $query = "
            SELECT p.*, c.name as category_name
            FROM " . $this->table_name . " p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
            LIMIT 0,1
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $product_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product_data) {
            return false; 
        }

        $query_images = "SELECT * FROM product_images WHERE product_id = ?";
        $stmt_images = $this->conn->prepare($query_images);
        $stmt_images->bindParam(1, $id);
        $stmt_images->execute();
        $product_data['images'] = $stmt_images->fetchAll(PDO::FETCH_ASSOC);
        
        $query_variants = "SELECT * FROM product_variants WHERE product_id = ? AND quantity > 0 ORDER BY size ASC";
        $stmt_variants = $this->conn->prepare($query_variants);
        $stmt_variants->bindParam(1, $id);
        $stmt_variants->execute();
        $product_data['variants'] = $stmt_variants->fetchAll(PDO::FETCH_ASSOC);

        return $product_data;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=:name, description=:description, price=:price, manufacturer=:manufacturer, 
                      usage_type=:usage_type, category_id=:category_id, image_url=:image_url";
        
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->manufacturer = htmlspecialchars(strip_tags($this->manufacturer));
        $this->usage_type = htmlspecialchars(strip_tags($this->usage_type));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));


        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":manufacturer", $this->manufacturer);
        $stmt->bindParam(":usage_type", $this->usage_type);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":image_url", $this->image_url);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->manufacturer = $row['manufacturer'];
            $this->usage_type = $row['usage_type'];
            $this->category_id = $row['category_id'];
            $this->image_url = $row['image_url'];
            return true;
        }
        return false;
    }

    
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET name = :name, description = :description, price = :price, 
                      manufacturer = :manufacturer, usage_type = :usage_type, 
                      category_id = :category_id, image_url = :image_url
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->manufacturer = htmlspecialchars(strip_tags($this->manufacturer));
        $this->usage_type = htmlspecialchars(strip_tags($this->usage_type));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':manufacturer', $this->manufacturer);
        $stmt->bindParam(':usage_type', $this->usage_type);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        return $stmt->execute();
    }

    public function getVariants() {
        $query = "SELECT * FROM product_variants WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function syncVariants($variantsData) {
        $this->conn->beginTransaction();
        try {
            $stmt_get_ids = $this->conn->prepare("SELECT id FROM product_variants WHERE product_id = ?");
            $stmt_get_ids->execute([$this->id]);
            $ids_in_db = $stmt_get_ids->fetchAll(PDO::FETCH_COLUMN);

            $ids_from_form = []; 

            if (!empty($variantsData['size'])) {
                foreach ($variantsData['size'] as $index => $size) {
                    $quantity = $variantsData['quantity'][$index];
                    $variantId = $variantsData['id'][$index] ?? null;

                    if (empty(trim($size))) {
                        continue;
                    }
                    
                    if (!empty($variantId)) { 
                        $stmt_update = $this->conn->prepare("UPDATE product_variants SET size = ?, quantity = ? WHERE id = ? AND product_id = ?");
                        $stmt_update->execute([$size, $quantity, $variantId, $this->id]);
                        $ids_from_form[] = $variantId;
                    } else { 
                        $stmt_insert = $this->conn->prepare("INSERT INTO product_variants (product_id, size, quantity) VALUES (?, ?, ?)");
                        $stmt_insert->execute([$this->id, $size, $quantity]);
                        $ids_from_form[] = $this->conn->lastInsertId();
                    }
                }
            }
            
            
            $ids_to_delete = array_diff($ids_in_db, $ids_from_form);

            if (!empty($ids_to_delete)) {
                $placeholders = implode(',', array_fill(0, count($ids_to_delete), '?'));
                $stmt_delete = $this->conn->prepare("DELETE FROM product_variants WHERE id IN ({$placeholders}) AND product_id = ?");
                
                $params = array_values($ids_to_delete);
                $params[] = $this->id;

                $stmt_delete->execute($params);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}