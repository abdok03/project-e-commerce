<?php
session_start();
// var_dump($_SESSION['user_id']);
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/login.html');
    exit;
}

$user_id = $_SESSION['user_id'];
$db = (new Database())->connecte();

// جلب كارت المستخدم
$stmt = $db->prepare("SELECT id FROM carts WHERE user_id = :user_id LIMIT 1");
$stmt->execute([':user_id' => $user_id]);
$cart = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($cart);


$cart_items = [];
if ($cart) {
    $cart_id = $cart['id'];
    $stmt = $db->prepare("
        SELECT ci.id AS item_id, p.id AS product_id, p.name, p.price, p.image_url, ci.quantity
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.cart_id = :cart_id
    ");
    $stmt->execute([':cart_id' => $cart_id]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($cart_items);

}

// تحديث الكمية
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_qty'])) {
        $item_id = intval($_POST['item_id']);
        $qty = intval($_POST['quantity']);
        if ($qty < 1)
            $qty = 1;
        $stmt = $db->prepare("UPDATE cart_items SET quantity = :qty WHERE id = :id");
        $stmt->execute([':qty' => $qty, ':id' => $item_id]);
        header('Location: cart.php');
        exit;
    }

    // حذف المنتج
    if (isset($_POST['remove_item'])) {
        $item_id = intval($_POST['item_id']);
        $stmt = $db->prepare("DELETE FROM cart_items WHERE id = :id");
        $stmt->execute([':id' => $item_id]);
        header('Location: cart.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Your Cart | CarStore</title>
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <nav class="navbar">
        <img src="../assets/logo.png" class="logo">
        <div class="icons">
            <a href="login.html"><i class="fa fa-user"></i></a>
            <i class="fa fa-heart"></i>
            <i class="fa fa-shopping-cart"></i>
        </div>
    </nav>

    <div class="cart-container">

        <div class="cart-table">
            <table>
                <thead>
                    <tr>
                        <th>PRODUCT</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>TOTAL</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($cart_items)): ?>
                        <tr>
                            <td colspan="5">No products in cart.</td>
                        </tr>
                    <?php else:
                        $grand_total = 0;
                        foreach ($cart_items as $item):
                            $total = $item['price'] * $item['quantity'];
                            $grand_total += $total;
                            ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars($item['image_url']) ?>" width="80"
                                        alt="<?= htmlspecialchars($item['name']) ?>">
                                    <p><?= htmlspecialchars($item['name']) ?></p>
                                </td>
                                <td><?= $item['price'] ?> JD</td>
                                <td>
                                    <form method="POST" style="display:flex; gap:5px;">
                                        <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                                        <button type="submit" name="update_qty" class="btn">Update</button>
                                    </form>
                                </td>
                                <td><?= $total ?> JD</td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                                        <button type="submit" name="remove_item" class="btn btn-delete">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="summary">
            <h3>TOTAL SHOPPING CART</h3>
            <p class="summary-total"><?= $grand_total ?? 0 ?> JD</p>
            <button class="checkout-btn">Checkout</button>
        </div>

    </div>

</body>

</html>