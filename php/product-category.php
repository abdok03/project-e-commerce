<?php
include "../config/database.php";

$db = (new Database())->connecte();

$category = $_GET['category'] ?? '';

$query = $db->prepare("SELECT * FROM car_products 
                       WHERE main_type = 'internal' 
                       AND category_slug = ?");
$query->execute([$category]);

$products = $query->fetchAll(PDO::FETCH_ASSOC);

$countQuery = $db->prepare("SELECT COUNT(*) FROM car_products 
                            WHERE main_type='internal' 
                            AND category_slug=?");
$countQuery->execute([$category]);
$total = $countQuery->fetchColumn();
?>
