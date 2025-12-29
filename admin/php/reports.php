<?php
session_start();
require_once "../../config/database.php";

// التحقق من صلاحية الأدمن
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$db = (new Database())->connecte();

// عدد المستخدمين
$stmt = $db->prepare("SELECT COUNT(*) as total_users FROM users");
$stmt->execute();
$totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

// عدد الطلبات
$stmt = $db->prepare("SELECT COUNT(*) as total_orders FROM orders");
$stmt->execute();
$totalOrders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

// مجموع المبيعات
$stmt = $db->prepare("SELECT SUM(total_amount) as total_sales FROM orders");
$stmt->execute();
$totalSales = $stmt->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;

// عدد الطلبات حسب الحالة
$stmt = $db->prepare("
    SELECT status, COUNT(*) as count 
    FROM orders 
    GROUP BY status
");
$stmt->execute();
$statusCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Reports</title>
    <link rel="stylesheet" href="../css/dashborad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            display: flex;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f0f2f5;
        }

        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: #fff;
            height: 100vh;
            padding: 20px;
            position: fixed;
            right: 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            color: #fff;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #333;
        }

        .main-content {
            margin-right: 240px;
            padding: 30px;
            flex: 1;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
        }

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 25px 20px;
            width: 220px;
            text-align: center;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #555;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }

        /* ألوان مختلفة للبطاقات */
        .card.users {
            background: #007bff;
            color: #fff;
        }

        .card.orders {
            background: #17a2b8;
            color: #fff;
        }

        .card.sales {
            background: #28a745;
            color: #fff;
        }

        .card.pending {
            background: #ffc107;
            color: #fff;
        }

        .card.paid {
            background: #20c997;
            color: #fff;
        }

        .card.shipped {
            background: #6f42c1;
            color: #fff;
        }

        .card.completed {
            background: #fd7e14;
            color: #fff;
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <h2>🚗 CarStore</h2>
        <ul>
            <li><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="../php/products.php"><i class="fa fa-box"></i> Products</a></li>
            <li><a href="../php/create_product.php"><i class="fa fa-tags"></i> Add Product</a></li>
            <li><a href="orders.php"><i class="fa fa-shopping-cart"></i> Orders</a></li>
            <li><a href="users.php"><i class="fa fa-users"></i> Users</a></li>
            <li><a href="reports.php"><i class="fa fa-chart-line"></i> Reports</a></li>
            <li><a href="logout.php" class="logout"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </aside>

    <div class="main-content">
        <h2>Admin Reports</h2>
        <div class="cards-container">
            <div class="card users">
                <h3>Total Users</h3>
                <p><?= $totalUsers ?></p>
            </div>
            <div class="card orders">
                <h3>Total Orders</h3>
                <p><?= $totalOrders ?></p>
            </div>
            <div class="card sales">
                <h3>Total Sales</h3>
                <p><?= number_format($totalSales, 2) ?> JD</p>
            </div>
            <?php foreach ($statusCounts as $status):
                $statusClass = strtolower($status['status']);
                ?>
                <div class="card <?= $statusClass ?>">
                    <h3><?= ucfirst($status['status']) ?> Orders</h3>
                    <p><?= $status['count'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>