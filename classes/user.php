<?php
require_once("../config/database.php");
$db = (new Database())->connecte();
$user = new users($db);

class users {
    private $coon;
    private $table ="users";
    public $id;
    public $name;
    public $email;
    public $phone_number;
    public $password;
    
    public function __construct($db_name) {
        $this->coon = $db_name;
    }
    public function create(){
    $query = "INSERT INTO {$this->table} (name, phone_number, password)
              VALUES (:name, :phone_number, :password)";

    $stmt = $this->coon->prepare($query);

    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":phone_number", $this->phone_number);
    $stmt->bindParam(":password", $this->password);

    try {
        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
    } catch (PDOException $e) {
        echo "PDO Error: " . $e->getMessage();
        return false;
    }
}


    public function readOne(){
    $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
    $stmt = $this->coon->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function read(){
        $query= "SELECT * FROM  {$this->table} ORDER BY id DESC";
        $stmt= $this->coon->prepare($query);
        $stmt->execute() ;
        return $stmt;
    }
    public function update(){
        $query= "UPDATE {$this->table}
        SET name =:name , phone_number=:phone_number
        WHERE id=:id";
        $stmt= $this->coon->prepare($query);
        $stmt->bindParam(":name", htmlspecialchars(strip_tags($this->name))) ;
        $stmt->bindParam(":phone_number", htmlspecialchars(strip_tags($this->phone_number))) ;
        $stmt->bindParam(":id", $this->id) ;
        return $stmt->execute() ;
    }
    public function delete(){
        $query= "DELETE FROM {$this->table} WHERE id=:id";
        $stmt= $this->coon->prepare($query);
        $stmt->bindParam(":id", $this->id) ;
        return $stmt->execute() ;
    }
}
$db = (new Database())->connecte();
if ($db) {
    echo "تم الاتصال بقاعدة البيانات بنجاح ✅";
} else {
    echo "فشل الاتصال ❌";
}

?>