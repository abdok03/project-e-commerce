<?php
class Address {
    private $db;
    private $table = "addresses";

    public function __construct($db){
        $this->db = $db;
    }

    public function getUserAddresses($user_id){
        $sql = "SELECT * FROM $this->table WHERE user_id = ? ORDER BY is_default DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data){
        $sql = "INSERT INTO $this->table 
        (user_id, full_name, phone, country, city, area, street, postal_code, is_default)
        VALUES (:user_id,:full_name,:phone,:country,:city,:area,:street,:postal_code,:is_default)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function setDefault($id,$user_id){
        $this->db->prepare("UPDATE $this->table SET is_default = 0 WHERE user_id=?")
                 ->execute([$user_id]);

        return $this->db->prepare("UPDATE $this->table SET is_default = 1 WHERE id=? AND user_id=?")
                 ->execute([$id,$user_id]);
    }

    public function delete($id,$user_id){
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id=? AND user_id=?");
        return $stmt->execute([$id,$user_id]);
    }
}
?>
