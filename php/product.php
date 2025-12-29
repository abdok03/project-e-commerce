<?php
session_start();
require_once "../config/database.php";

$dbObj = new Database();
$db = $dbObj->connecte();

$car_brand = 'kia';
$q = $db->prepare("SELECT * FROM products WHERE car_brand = ?");
$q->execute([$car_brand]);
$products = $q->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Carbon Chromes</title>
</head>

<body>

    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <?php
                $img = $product['image_url'] ?? '';
                $img = ltrim($img, '/'); // يشيل / إذا موجودة في البداية
                ?>
                <img src="/car_e-c/project-e-commerce/<?= htmlspecialchars($img) ?>"
                    style="border:2px solid red; width:150px" alt="<?= htmlspecialchars($product['name']) ?>">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p><?= $product['price'] ?> Jd</p>
                <a href="single_product.php?id=<?= $product['id'] ?>" class="view-btn">View Details</a>
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>