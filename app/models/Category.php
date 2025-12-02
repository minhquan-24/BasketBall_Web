<?php
class Category{
    private $conn;
    private $table_name = "categories";

    public $id;
    public $name;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function readOne() {
        $query = "SELECT name FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->name = $row['name'];
            return true;
        }
        return false;
    }
}
?>