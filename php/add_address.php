<?php
session_start();
require "../config/database.php";

$db = (new Database())->connecte();

$user_id = $_SESSION['user_id'];

$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$country = $_POST['country'];
$city = $_POST['city'];
$area = $_POST['area'];
$street = $_POST['street'];
$postal = $_POST['postal_code'];

$sql = "INSERT INTO addresses 
(user_id, full_name, phone, country, city, area, street, postal_code, is_default)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";

$stmt = $db->prepare($sql);

if($stmt->execute([$user_id,$full_name,$phone,$country,$city,$area,$street,$postal])){
    echo "success";
} else {
    echo "error";
}
