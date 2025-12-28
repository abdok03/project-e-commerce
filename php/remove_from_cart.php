<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id']))
    die("Login required");

$cart_item_id = intval($_POST['cart_item_id'] ?? 0);

$db = (new Database())->connecte();
$stmt = $db->prepare("DELETE FROM cart_items WHERE id = :id");
$stmt->execute([':id' => $cart_item_id]);

header("Location: cart.php");
exit;
