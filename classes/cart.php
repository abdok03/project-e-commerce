<?php
class Cart {
    private $conn;
    private $table = "carts";

    public $id;
    public $user_id;

    public function __construct($db) {
        $this->conn = $db;
    }
public function create() {
    $stmt = $this->conn->prepare(
        "INSERT INTO carts (user_id) VALUES (:user_id)"
    );
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->execute();
    return $this->conn->lastInsertId();
}

    public function getCartByUser() {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        $query = "INSERT INTO {$this->table} (user_id) VALUES (:user_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        return [
            "id" => $this->conn->lastInsertId(),
            "user_id" => $this->user_id
        ];
    }
}