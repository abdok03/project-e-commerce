<?php
session_start();
require "../config/database.php";

$db = (new Database())->connecte();
$user_id = $_SESSION['user_id'];

$id = $_POST['id'];

$db->prepare("UPDATE addresses SET is_default=0 WHERE user_id=?")
   ->execute([$user_id]);

$db->prepare("UPDATE addresses SET is_default=1 WHERE id=? AND user_id=?")
   ->execute([$id,$user_id]);

echo "success";
