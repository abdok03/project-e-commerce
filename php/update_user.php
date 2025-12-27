<?php
session_start();
require "../config/database.php";

$db = (new Database())->connecte();
$id = $_SESSION['user_id'];

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$stmt = $db->prepare("UPDATE users SET name=?, email=?, phone_number=? WHERE id=?");
$stmt->execute([$name,$email,$phone,$id]);

echo "success";
