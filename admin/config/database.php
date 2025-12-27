<?php
class Database {
    private $host = "localhost";
    private $db_name = "car_store";   // اسم قاعدة البيانات
    private $username = "root";       // اسم المستخدم
    private $password = "";           // الباسورد
    public $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
            exit;
        }

        return $this->conn;
    }
}
?>
