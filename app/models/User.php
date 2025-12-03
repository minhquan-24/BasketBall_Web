<?php

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $email;
    public $password; 
    public $name;
    public $role;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password) VALUES (:name, :email, :password)";
        
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email)); 
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(":email", $this->email);  
        $stmt->bindParam(":password", $password_hash); 
        $stmt->bindParam(":name", $this->name);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->role = $row['role'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }
    public function readAll(){
        $query = "SELECT id, email, name, role, created_at FROM " . $this->table_name . " ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne(){
        $query = "SELECT id, email, name, role, created_at FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->role = $row['role'];
            $this->email = $row['email'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        return $stmt->execute();
    }

    public function count() {
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total_rows'];
    }

    public function readPaging($from_record_num, $records_per_page) {
    $query = "SELECT id, email, name, role, created_at 
              FROM " . $this->table_name . " 
              ORDER BY id ASC 
              LIMIT :from, :limit";
    
    $stmt = $this->conn->prepare($query);
    
    $stmt->bindParam(":from", $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(":limit", $records_per_page, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt;
    }

}