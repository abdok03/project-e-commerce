<?php
session_start();
require_once "../../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.html");
    exit;
}

$db = (new Database())->connecte();

// Stats
$totalOrders   = $db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalProducts = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalUsers    = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalSales    = $db->query("SELECT SUM(total_amount) FROM orders")->fetchColumn();
$totalSales    = $totalSales ?? 0;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | CarStore</title>
    <link rel="stylesheet" href="../css/dashborad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard">

    <aside class="sidebar">
        <h2>🚗 CarStore</h2>
        <ul>
            <li><a href="dashborad.php"><i class="fa fa-home"></i>dashbord</a></li>
            <li><a href="../php/products.php"><i class="fa fa-box"></i> Products</a></li>
            <li><a href="../php/create_product.php"><i class="fa fa-tags"></i> Add product</a></li>
            <li><a href="orders.php"><i class="fa fa-shopping-cart"></i> Orders</a></li>
            <li><a href="users.php"><i class="fa fa-users"></i> Users</a></li>
            <li><a href="reports.php"><i class="fa fa-chart-line"></i> Reports</a></li>
            <li><a href="logout.php" class="logout"><i class="fa fa-sign-out"></i> logout</a></li>
        </ul>
    </aside>

    <main class="content">
        <header>
            <h1>لوحة التحكم</h1>
        </header>

        <section class="stats">
            <div class="card">🛒 الطلبات <span><?= $totalOrders ?></span></div>
            <div class="card">📦 المنتجات <span><?= $totalProducts ?></span></div>
            <div class="card">👤 المستخدمين <span><?= $totalUsers ?></span></div>
            <div class="card">💰 المبيعات <span>$<?= number_format($totalSales) ?></span></div>
        </section>
    </main>

</div>

</body>
</html>
