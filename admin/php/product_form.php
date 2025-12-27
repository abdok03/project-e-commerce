<?php
$isEdit = isset($product);
$action = $isEdit ? "update_product.php" : "add_product.php";
?>

<form action="<?= $action ?>" method="POST" enctype="multipart/form-data">

<?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= $product['id'] ?>">
<?php endif; ?>

<input type="text" name="name" placeholder="Product Name"
       value="<?= $product['name'] ?? '' ?>" required>

<textarea name="description"><?= $product['description'] ?? '' ?></textarea>

<input type="number" step="0.01" name="price"
       value="<?= $product['price'] ?? '' ?>" required>

<input type="number" name="stock_quantity"
       value="<?= $product['stock_quantity'] ?? 0 ?>">

<select name="category_id">
    <option value="">Select Category</option>
    <?php
    $cats = $db->query("SELECT * FROM categories");
    while ($cat = $cats->fetch(PDO::FETCH_ASSOC)):
    ?>
        <option value="<?= $cat['id'] ?>"
            <?= ($product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
            <?= $cat['name'] ?>
        </option>
    <?php endwhile; ?>
</select>

<input type="text" name="car_brand" value="<?= $product['car_brand'] ?? '' ?>" placeholder="Car Brand">
<input type="text" name="car_model" value="<?= $product['car_model'] ?? '' ?>" placeholder="Car Model">
<input type="number" name="car_year" value="<?= $product['car_year'] ?? '' ?>" placeholder="Car Year">

<?php if (!empty($product['image_url'])): ?>
    <img src="../<?= $product['image_url'] ?>" width="80"><br>
<?php endif; ?>

<input type="file" name="image">

<button class="btn btn-save">
    <?= $isEdit ? 'Update Product' : 'Add Product' ?>
</button>

</form>
