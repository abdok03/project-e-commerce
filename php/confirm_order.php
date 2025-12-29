<?php
require_once "../config/database.php";

$order_id = $_GET['order_id'] ?? 0;
$db = (new Database())->connecte();

// استرجاع الطلب
$stmt = $db->prepare("SELECT * FROM orders WHERE id=?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

// استرجاع المنتجات
$stmtItems = $db->prepare("SELECT oi.*, p.name, p.image_url FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE order_id=?");
$stmtItems->execute([$order_id]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Order Confirmation #<?= $order['id'] ?></h1>
<p>Total: <?= $order['total'] ?> JD</p>
<ul>
<?php foreach($items as $item): ?>
    <li><?= $item['name'] ?> x <?= $item['quantity'] ?> - <?= $item['price'] ?> JD</li>
<?php endforeach; ?>
</ul>
