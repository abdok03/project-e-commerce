<?php
require_once "../../includes/admin_only.php";
require_once "../../config/database.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.html");
    exit;
}
$db = (new Database())->connecte();
$stmt = $db->query("SELECT * FROM products ORDER BY id DESC");

?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>product | CarStore</title>
    <link rel="stylesheet" href="../css/dashborad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: tahoma, sans-serif;
            background: #f4f6f8;
            margin: 0;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            margin-right: 240px;
            /* بدل margin-left */
            padding: 20px;
            width: calc(100% - 240px);
        }

        /* .sidebar {
                width: 250px;
                background: #111;
                color: #fff;
                transition: 0.3s;
            }

            .sidebar h2 {
                padding: 20px;
                text-align: center;
                border-bottom: 1px solid #333;
            }

            .sidebar ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .sidebar ul li {
                border-bottom: 1px solid #333;
            }

            .sidebar ul li a {
                display: block;
                padding: 15px 20px;
                color: #fff;
                text-decoration: none;
                transition: 0.2s;
            }

            .sidebar ul li a:hover {
                background: #444;
            } */

        .content {
            flex: 1;
            padding: 30px;
        }

        h1 {
            margin-top: 0;
            color: #111;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        table th {
            background: #007bff;
            color: #fff;
        }

        table tr:hover {
            background: #f1f1f1;
        }

        img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            transition: 0.2s;
            font-size: 14px;
        }

        .btn-edit {
            background: #28a745;
            margin-right: 5px;
        }

        .btn-edit:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-delete:hover {
            background: #c82333;
        }
    </style>
</head>

<body>

    <div class="dashboard">

        <aside class="sidebar">
            <h2>🚗 CarStore</h2>
            <ul>
                <li><a href="dashboard.php"><i class="fa fa-home"></i> dashbord</a></li>
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
                <h1>Products</h1>
            </header>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>price</th>
                    <th>Quantity</th>
                    <th>Img</th>
                    <th>procedures</th>
                </tr>

                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['car_brand'] ?></td>
                        <td><?= $row['price'] ?></td>
                        <td><?= $row['stock_quantity'] ?></td>
                        <td>
                            <?php
                            if (!empty($row['image_url'])) {

                                $imgUrl = '/car_e-c/project-e-commerce/' . ltrim($row['image_url'], '/');

                                $imgPath = $_SERVER['DOCUMENT_ROOT'] . $imgUrl;

                                if (file_exists($imgPath)) {
                                    echo '<img src="' . htmlspecialchars($imgUrl) . '" width="80">';
                                } else {
                                    echo 'الصورة غير موجودة على السيرفر';
                                }

                            } else {
                                echo 'لا يوجد مسار للصورة';
                            }
                            ?>

                        </td>






                        <td>
                            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edite</a>
                            <form action="delete_product.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button class="btn btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

        </main>
    </div>

</body>

</html>