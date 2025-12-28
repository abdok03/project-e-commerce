<?php
session_start();
// var_dump($_SESSION['user_id']);
require_once "../config/database.php";

$dbObj = new Database();
$db = $dbObj->connecte();

// الماركة اللي بدك تعرض منتجاتها
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
    <section class="products-section">
        <h2>Available Products</h2>
        <div class="products-grid">
            <?php if (empty($products)): ?>
                <h2 style="text-align:center; color:red; width:100%;">Product Not Found</h2>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <?php
                    echo '../uploads/' . $p['image_url'];
                    ?>

                    <div class="product-card">
                        <?php
                        // مسار السيرفر للصور
                        $imagePath = __DIR__ . '/../uploads/' . $p['image_url'];
                        // URL للعرض في المتصفح
                        $imageUrl = 'http://localhost/car_e-c/project-e-commerce/uploads/' . $p['image_url'];

                        if (file_exists($imagePath)) {
                            echo '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($p['name']) . '">';

                        } else {
                            echo 'الصورة غير موجودة';
                        }
                        ?>

                        <h3><?= htmlspecialchars($p['name']) ?></h3>
                        <p><?= $p['price'] ?> SAR</p>

                        <a href="single_product.php?id=<?= $p['id'] ?>" class="view-btn">View Details</a>

                        <form method="POST" action="add_to_cart.php">
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">

                            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>