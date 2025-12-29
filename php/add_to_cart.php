<?php
ini_set('session.cookie_path', '/');
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    die("غير مسموح");
}

if (!isset($_POST['product_id'])) {
    die("منتج غير صالح");
}

$db = (new Database())->connecte();

$user_id = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT id FROM carts WHERE user_id = ? LIMIT 1");
$stmt->execute([$user_id]);
$cart = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cart) {
    $cart_id = $cart['id'];
} else {
    $stmt = $db->prepare("INSERT INTO carts (user_id) VALUES (?)");
    $stmt->execute([$user_id]);
    $cart_id = $db->lastInsertId();
}

$product_id = (int) $_POST['product_id'];
$quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

$stmt = $db->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
$stmt->execute([$cart_id, $product_id]);
$existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingItem) {
    $newQty = $existingItem['quantity'] + $quantity;
    $stmt = $db->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
    $stmt->execute([$newQty, $existingItem['id']]);
} else {
    $stmt = $db->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$cart_id, $product_id, $quantity]);
}

header("Location: carts.php");
exit;
?>