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
    // إنشاء كارت جديد
    $stmt = $db->prepare("INSERT INTO carts (user_id) VALUES (?)");
    $stmt->execute([$user_id]);
    $cart_id = $db->lastInsertId();
}

$product_id = (int) $_POST['product_id'];
$stmt = $db->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, 1)");
$stmt->execute([$cart_id, $product_id]);

header("Location: carts.php");
exit;
?>