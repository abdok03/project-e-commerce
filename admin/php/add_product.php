<?php
require_once "../../includes/admin_only.php";
require_once "../../config/database.php";

$db = (new Database())->connecte();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'];
    $stock = $_POST['stock_quantity'] ?? 0;
    $category_id = $_POST['category_id'] ?: null;
    $car_brand = $_POST['car_brand'] ?? '';
    $car_model = $_POST['car_model'] ?? '';
    $car_year = $_POST['car_year'] ?? null;

    $image_url = null;
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "../../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $image_name = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image_name);
        $image_url = "uploads/" . $image_name;
    }

    $stmt = $db->prepare("
        INSERT INTO products
        (name, description, price, stock_quantity, category_id, car_brand, car_model, car_year, image_url)
        VALUES
        (:name, :description, :price, :stock, :category_id, :car_brand, :car_model, :car_year, :image_url)
    ");

    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':stock' => $stock,
        ':category_id' => $category_id,
        ':car_brand' => $car_brand,
        ':car_model' => $car_model,
        ':car_year' => $car_year,
        ':image_url' => $image_url
    ]);

    header("Location: dashboard.php");
    exit;
}
