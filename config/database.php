<?php
class Database {
    private $db_name = "car_store";
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    public $coon;

    public function connecte() {
        try {
            $this->coon = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            $this->coon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->coon;
        } catch (PDOException $e) {
            echo "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
            return null;
        }
    }
}
?>
