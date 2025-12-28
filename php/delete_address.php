<?php
session_start();
require "../config/database.php";

$db = (new Database())->connecte();
$user_id = $_SESSION['user_id'];

$id = $_POST['id'];

$stmt = $db->prepare("DELETE FROM addresses WHERE id=? AND user_id=?");
$stmt->execute([$id,$user_id]);

echo "success";
