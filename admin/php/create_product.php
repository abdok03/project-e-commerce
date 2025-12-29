<?php
session_start();
require_once "../../includes/admin_only.php";
require_once "../../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.html");
    exit;
}

$db = (new Database())->connecte();

// رفع الصورة
$uploadDir = "../../uploads/";
if (!is_dir($uploadDir))
    mkdir($uploadDir, 0755, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock_quantity = intval($_POST['stock_quantity'] ?? 0);
    $category_id = intval($_POST['category_id'] ?? 0);
    $car_brand = trim($_POST['car_brand'] ?? '');
    $car_model = trim($_POST['car_model'] ?? '');
    $car_year = intval($_POST['car_year'] ?? 0);

    if ($category_id <= 0)
        die("Please select a valid category.");

    $image_url = null;
    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . rand(1000, 9999) . "." . $ext;
        $destination = $uploadDir . $image_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination))
            $image_url = "uploads/" . $image_name;
        else
            die("Failed to upload image.");
    }

    $stmt = $db->prepare("INSERT INTO products 
        (name, description, price, stock_quantity, category_id, car_brand, car_model, car_year, image_url)
        VALUES (:name, :description, :price, :stock_quantity, :category_id, :car_brand, :car_model, :car_year, :image_url)");

    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':stock_quantity' => $stock_quantity,
        ':category_id' => $category_id,
        ':car_brand' => $car_brand,
        ':car_model' => $car_model,
        ':car_year' => $car_year,
        ':image_url' => $image_url
    ]);

    header("Location: products.php");
    exit;
}

// جلب الفئات
$categories = $db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title> منتج | CarStore</title>
    <link rel="stylesheet" href="../css/dashborad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
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

        /* 
        .sidebar {
            width: 250px;
            background: #111;
            color: #fff;
            transition: 0.3s;
            overflow: hidden;
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
        }

        .product-form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .product-form label {
            display: block;
            margin: 15px 0 5px;
        }

        .product-form input[type=text],
        .product-form input[type=number],
        .product-form textarea,
        .product-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .product-form button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.2s;
        }

        .product-form button:hover {
            background: #0056b3;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar.collapsed ul li a span {
            display: none;
        }

        .toggle-btn {
            position: absolute;
            top: 20px;
            left: 260px;
            font-size: 20px;
            cursor: pointer;
            transition: 0.3s;
        }
    </style>
</head>

<body>

    <div class="dashboard">

        <aside class="sidebar" id="sidebar">
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
            <h1>Add a new product</h1>

            <form action="" method="POST" enctype="multipart/form-data" class="product-form">
                <label> name:</label>
                <input type="text" name="name" required>

                <label>description:</label>
                <textarea name="description"></textarea>

                <label>price:</label>
                <input type="number" step="0.01" name="price" required>

                <label>quantity:</label>
                <input type="number" name="stock_quantity" value="1">

                <label>category:</label>
                <select name="category_id" required>
                    <option value=""> Select category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label> car_brand:</label>
                <input type="text" name="car_brand">

                <label> car_model:</label>
                <input type="text" name="car_model">

                <label> car_year:</label>
                <input type="number" name="car_year">

                <label>image:</label>
                <input type="file" name="image" accept="image/*">

                <button type="submit">Add product</button>
            </form>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.createElement('div');
        toggleBtn.classList.add('toggle-btn');
        toggleBtn.innerHTML = '&#9776;';
        document.body.appendChild(toggleBtn);
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('collapsed'));
    </script>

</body>

</html>