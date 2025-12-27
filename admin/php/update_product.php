<?php
require_once "../../includes/admin_only.php";
require_once "../../config/database.php";

$db = (new Database())->connecte();

$id = $_POST['id'];

$stmt = $db->prepare("SELECT image_url FROM products WHERE id=?");
$stmt->execute([$id]);
$current = $stmt->fetch(PDO::FETCH_ASSOC);
$imagePath = $current['image_url'];

if (!empty($_FILES['image']['name'])) {
    $imageName = time() . "_" . $_FILES['image']['name'];
    $target = "../assets/uploads/" . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $imagePath = "assets/uploads/" . $imageName;
    }
}

$query = "UPDATE products SET
name=:name,
description=:description,
price=:price,
stock_quantity=:stock,
category_id=:category,
car_brand=:brand,
car_model=:model,
car_year=:year,
image_url=:image
WHERE id=:id";

$stmt = $db->prepare($query);
$stmt->execute([
    ":name" => $_POST['name'],
    ":description" => $_POST['description'],
    ":price" => $_POST['price'],
    ":stock" => $_POST['stock_quantity'],
    ":category" => $_POST['category_id'] ?: null,
    ":brand" => $_POST['car_brand'],
    ":model" => $_POST['car_model'],
    ":year" => $_POST['car_year'] ?: null,
    ":image" => $imagePath,
    ":id" => $id
]);

header("Location: products.php");
exit;
