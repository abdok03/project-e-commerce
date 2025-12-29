<?php
session_start();
require_once "../../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$db = (new Database())->connecte();

$stmt = $db->prepare("
    SELECT o.id, o.user_id, o.total_amount, o.status, o.created_at, u.name
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="../css/dashborad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 200px;
            background: #2c3e50;
            color: #fff;
            height: 100vh;
            position: fixed;
            right: 0;
            /* بدل left */
            top: 0;
        }


        /* 
       

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
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
            padding: 8px 12px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #555;
        }

        .sidebar ul li a.logout {
            background-color: #c82333;
        }

        .sidebar ul li a.logout:hover {
            background-color: #a71d2a;
        } */

        /* Main content */
        .main-content {
            margin-right: 240px;
            padding: 40px;
            width: calc(100% - 240px);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        select {
            padding: 5px 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .status-btn {
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            border: none;
            background-color: #28a745;
            color: white;
            font-size: 14px;
            transition: 0.3s;
        }

        .status-btn:hover {
            background-color: #218838;
        }

        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }

        .status-paid {
            color: #17a2b8;
            font-weight: bold;
        }

        .status-shipped {
            color: #007bff;
            font-weight: bold;
        }

        .status-completed {
            color: #28a745;
            font-weight: bold;
        }

        .actions-form {
            display: flex;
            justify-content: center;
            gap: 5px;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
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

    <!-- Main content -->
    <div class="main-content">
        <h2>All Orders</h2>

        <table>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total (JD)</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['name']) ?></td>
                    <td><?= number_format($order['total_amount'], 2) ?></td>
                    <td class="status-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></td>
                    <td><?= $order['created_at'] ?></td>
                    <td>
                        <form method="POST" action="update_order_status.php" class="actions-form">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <select name="status">
                                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="paid" <?= $order['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed
                                </option>
                            </select>
                            <button type="submit" class="status-btn">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>