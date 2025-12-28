<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) die("Login required");

$cart_item_id = intval($_POST['cart_item_id'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1);
if($quantity < 1) $quantity = 1;

$db = (new Database())->connecte();
$stmt = $db->prepare("UPDATE cart_items SET quantity = :quantity WHERE id = :id");
$stmt->execute([':quantity' => $quantity, ':id' => $cart_item_id]);

header("Location: cart.php");
exit;
