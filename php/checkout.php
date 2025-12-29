<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$db = (new Database())->connecte();

// جلب آخر طلب للمستخدم
$stmt = $db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("No recent order found.");
}

$order_id = $order['id'];

// جلب عناصر الطلب
$stmtItems = $db->prepare("
    SELECT oi.quantity, oi.price_at_purchase, p.name, p.image_url
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmtItems->execute([$order_id]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($items as $item) {
    $total += $item['price_at_purchase'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Summary</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            .order-container {
                max-width: 1000px;
                margin: 0 auto;
            }

            .order-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 20px;
            }

            .product-card {
                background: #fff;
                border-radius: 10px;
                padding: 15px;
                text-align: center;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s;
            }

            .product-card:hover {
                transform: translateY(-5px);
            }

            .product-card img {
                width: 100%;
                height: 150px;
                object-fit: cover;
                border-radius: 10px;
                margin-bottom: 10px;
            }

            .product-info h3 {
                margin: 10px 0 5px;
                font-size: 16px;
            }

            .product-info p {
                font-size: 14px;
                margin: 3px 0;
            }

            .subtotal {
                font-weight: bold;
                color: #e74c3c;
            }

            .total-card {
                background: #ff3b3b;
                color: #fff;
                text-align: right;
                padding: 20px;
                border-radius: 10px;
                font-size: 18px;
                margin-top: 20px;
            }

            .buttons-container {
                display: flex;
                justify-content: center;
                gap: 20px;
                margin-top: 20px;
            }

            .back-btn,
            .checkout-btn {
                padding: 12px 25px;
                color: #fff;
                text-decoration: none;
                border-radius: 6px;
                font-weight: bold;
            }

            .back-btn {
                background-color: #333;
            }

            .back-btn:hover {
                background-color: #555;
            }

            .checkout-btn {
                background-color: #28a745;
            }

            .checkout-btn:hover {
                background-color: #218838;
            }
        }
    </style>
</head>

<body>
    <div class="order-container">
        <h2>Order Summary - Order #<?= htmlspecialchars($order_id) ?></h2>

        <div class="order-grid">
            <?php foreach ($items as $item):
                $subtotal = $item['price_at_purchase'] * $item['quantity'];
                ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($item['image_url'] ?? '../assets/logo.png') ?>"
                        alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="product-info">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p>Quantity: <?= $item['quantity'] ?></p>
                        <p>Price/unit: <?= number_format($item['price_at_purchase'], 2) ?> JD</p>
                        <p class="subtotal">Subtotal: <?= number_format($subtotal, 2) ?> JD</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="total-card">Total: <?= number_format($total, 2) ?> JD</div>

        <div class="buttons-container">
            <a href="../index.php" class="back-btn">Continue Shopping</a>
            <a href="payment.php?order_id=<?= $order_id ?>" class="checkout-btn">Proceed to Payment</a>
        </div>
    </div>

</body>

</html>