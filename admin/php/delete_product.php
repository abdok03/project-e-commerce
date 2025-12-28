<?php
require_once "../../includes/admin_only.php";
require_once "../../config/database.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.html");
    exit;
}

$db = (new Database())->connecte();

$id = $_POST['id'] ?? null;
if (!$id) {
    die("Invalid product ID");
}

// جلب اسم المنتج للعرض قبل الحذف
$stmt = $db->prepare("SELECT name FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found");
}

// عند تأكيد الحذف
if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>حذف المنتج | CarStore</title>
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
.confirm-box{background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);text-align:center;}
.confirm-box p{font-size:18px;margin-bottom:20px;}
.confirm-box button{padding:10px 20px;margin:0 10px;border:none;border-radius:5px;cursor:pointer;color:#fff;font-size:16px;transition:0.2s;}
.btn-yes{background:#dc3545;}
.btn-yes:hover{background:#c82333;}
.btn-no{background:#6c757d;}
.btn-no:hover{background:#5a6268;}
</style>
</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>🚗 CarStore</h2>
        <ul>
            <li><a href="../html/dashboard.php">لوحة التحكم</a></li>
            <li><a href="products.php">المنتجات</a></li>
            <li><a href="categories.php">الأقسام</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <main class="content">
        <h1>حذف المنتج</h1>
       <div class="confirm-box">
    <p>⚠️ هل أنت متأكد من حذف المنتج التالي؟</p>
    <h2 style="color:#dc3545; margin:10px 0;"><?= htmlspecialchars($product['name']) ?></h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" name="confirm" value="yes" class="btn-yes">نعم، احذف</button>
        <a href="products.php" class="btn-no">إلغاء العملية</a>
    </form>
</div>

<style>
.confirm-box p {
    font-size: 18px;
    margin-bottom: 15px;
    color: #333;
}
.confirm-box h2 {
    font-size: 22px;
    margin-bottom: 25px;
}
.btn-yes {
    background-color: #dc3545;
    color: #fff;
    padding: 12px 25px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: 0.2s;
    font-size: 16px;
}
.btn-yes:hover {
    background-color: #c82333;
}
.btn-no {
    display: inline-block;
    background-color: #6c757d;
    color: #fff;
    padding: 12px 25px;
    border-radius: 5px;
    text-decoration: none;
    margin-left: 10px;
    transition: 0.2s;
    font-size: 16px;
}
.btn-no:hover {
    background-color: #5a6268;
}
</style>

</body>
</html>
