<?php
class CartItem {
    private $conn;
    private $table = "cart_items";

    public $cart_id;
    public $product_id;
    public $quantity;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add() {
        // تحقق إذا المنتج موجود بالسلة
        $query = "SELECT id, quantity FROM {$this->table} 
                  WHERE cart_id = :cart_id AND product_id = :product_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cart_id", $this->cart_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // تحديث الكمية
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $newQty = $row['quantity'] + $this->quantity;

            $query = "UPDATE {$this->table} SET quantity = :qty WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":qty", $newQty);
            $stmt->bindParam(":id", $row['id']);
            return $stmt->execute();
        }

        // إضافة جديدة
        $query = "INSERT INTO {$this->table} (cart_id, product_id, quantity)
                  VALUES (:cart_id, :product_id, :quantity)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cart_id", $this->cart_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        return $stmt->execute();
    }

    public function getItems() {
        $query = "SELECT ci.*, p.name, p.price
                  FROM {$this->table} ci
                  JOIN products p ON ci.product_id = p.id
                  WHERE ci.cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cart_id", $this->cart_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function remove($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}