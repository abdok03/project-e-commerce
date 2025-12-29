<?php
session_start();
require_once "../../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}

if (!isset($_POST['order_id'], $_POST['status'])) {
    die("Invalid request");
}

$order_id = (int) $_POST['order_id'];
$status = $_POST['status'];

$db = (new Database())->connecte();
$stmt = $db->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->execute([$status, $order_id]);

header("Location: orders.php");
exit;
?>