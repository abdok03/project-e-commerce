<?php
require_once "../../includes/admin_only.php";
require_once "../../config/database.php";

$db = (new Database())->connecte();

$id = $_GET['id'] ?? null;
if (!$id) die("Invalid product");

$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) die("Product not found");

// جلب الفئات
$categories = $db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تعديل المنتج | CarStore</title>
<style>
body{font-family:tahoma,sans-serif;background:#f4f6f8;margin:0;}
.dashboard{display:flex;min-height:100vh;}
.sidebar{width:250px;background:#111;color:#fff;transition:0.3s;}
.sidebar h2{padding:20px;text-align:center;border-bottom:1px solid #333;}
.sidebar ul{list-style:none;padding:0;margin:0;}
.sidebar ul li{border-bottom:1px solid #333;}
.sidebar ul li a{display:block;padding:15px 20px;color:#fff;text-decoration:none;transition:0.2s;}
.sidebar ul li a:hover{background:#444;}
.content{flex:1;padding:30px;}
h1{margin-top:0;color:#111;margin-bottom:20px;}
.product-form{background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
.product-form label{display:block;margin:15px 0 5px;}
.product-form input[type=text],
.product-form input[type=number],
.product-form textarea,
.product-form select{width:100%;padding:10px;border:1px solid #ccc;border-radius:5px;}
.product-form button{margin-top:20px;padding:12px 20px;background:#28a745;color:#fff;border:none;border-radius:5px;cursor:pointer;transition:0.2s;}
.product-form button:hover{background:#218838;}
img{width:100px;height:auto;border-radius:5px;margin-top:10px;}
.sidebar.collapsed{width:60px;}
.toggle-btn{position:absolute;top:20px;left:260px;font-size:20px;cursor:pointer;transition:0.3s;}
</style>
</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <h2>🚗 CarStore</h2>
        <ul>
            <li><a href="dashboard.php">لوحة التحكم</a></li>
            <li><a href="products.php">المنتجات</a></li>
            <li><a href="categories.php">الأقسام</a></li>
        </ul>
    </aside>

    <main class="content">
        <h1>تعديل المنتج</h1>

        <form action="update_product.php" method="POST" enctype="multipart/form-data" class="product-form">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">

            <label>اسم المنتج:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label>الوصف:</label>
            <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

            <label>السعر:</label>
            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

            <label>الكمية:</label>
            <input type="number" name="stock_quantity" value="<?= $product['stock_quantity'] ?>">

            <label>الفئة:</label>
            <select name="category_id" required>
                <option value="">اختر الفئة</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>ماركة السيارة:</label>
            <input type="text" name="car_brand" value="<?= htmlspecialchars($product['car_brand']) ?>">

            <label>موديل السيارة:</label>
            <input type="text" name="car_model" value="<?= htmlspecialchars($product['car_model']) ?>">

            <label>سنة السيارة:</label>
            <input type="number" name="car_year" value="<?= $product['car_year'] ?>">

            <label>الصورة الحالية:</label>
            <?php if(!empty($product['image_url'])): ?>
                <img src="<?= $product['image_url'] ?>" alt="product">
            <?php endif; ?>

            <label>تغيير الصورة:</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">تحديث المنتج</button>
        </form>

    </main>
</div>

<script>
// Sidebar toggle
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.createElement('div');
toggleBtn.classList.add('toggle-btn');
toggleBtn.innerHTML = '&#9776;';
document.body.appendChild(toggleBtn);
toggleBtn.addEventListener('click', ()=> sidebar.classList.toggle('collapsed'));
</script>

</body>
</html>
