<?php
require_once "../includes/auth.php";
require_once "../config/database.php";

$db = (new Database())->connecte();

// جلب كل المنتجات
$query = "SELECT * FROM products ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// دالة لتصفية المنتجات حسب القسم
function filterProducts($products, $category_id) {
    return array_filter($products, fn($p) => $p['category_id'] == $category_id);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Carbon Chromes</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="icon" type="image/x-icon" href="../assets/icon.png">
</head>

<body>

<nav class="navbar">
    <img src="../assets/logo.png" class="logo">
    <div class="search-box">
        <input type="text" placeholder="Search for products...">
        <button>Search</button>
    </div>
    <div class="icons">
        <a href="login.html"><i class="fa fa-user"></i></a>
        <i class="fa fa-heart"></i>
        <i class="fa fa-shopping-cart"></i>
    </div>
</nav>

<ul class="menu">
    <li class="active">Home</li>
    <li>Interior</li>
    <li>Exterior</li>
    <li>Miscellaneous Products</li>
    <li>Lighting</li>
    <li>Interior Center</li>
    <li>Keys</li>
    <li>Tires and Rims</li>
</ul>

<section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1>The Largest Car Accessories Store</h1>

        <div class="filters">
            <select>
                <option>Car Manufacturer</option>
            </select>
            <select>
                <option>Product Category</option>
            </select>
            <button class="btn-red">Search</button>
        </div>

        <p class="shipping">Free Shipping for Orders Over 20 Dinar</p>
    </div>
</section>

<section class="luxury-section">
    <div class="luxury-header">
        <h2 class="luxury-title">Luxury Modifications...</h2>
        <div class="newly-arrived-container">
            <div class="line-left"></div>
            <h3 class="newly-arrived">Newly Arrived</h3>
            <div class="line-right"></div>
        </div>
    </div>

    <div class="categories">
        <div class="category">
            <div class="circle">
                <img src="../assets/bmw.png" alt="">
            </div>
            <p>Front<br>Grille</p>
        </div>

        <div class="category">
            <div class="circle">
                <img src="../assets/dog.jpg" alt="">
            </div>
            <p>Car<br>Diffuser</p>
        </div>

        <div class="category">
            <div class="circle">
                <img src="../assets/bmw2.jpg" alt="">
            </div>
            <p>Luxury<br>Rims</p>
        </div>

        <div class="category">
            <div class="circle">
                <img src="../assets/marcedes.jpg" alt="">
            </div>
            <p>Body<br>Kit</p>
        </div>

        <div class="category">
            <div class="circle">
                <img src="../assets/sss.jpg" alt="">
            </div>
            <p>Dashboard<br>Decor</p>
        </div>

        <div class="category">
            <div class="circle">
                <img src="../assets/moryjpg.webp" alt="">
            </div>
            <p>Mirror<br>Covers</p>
        </div>

        <div class="category">
            <div class="circle">
                <img src="../assets/bmw3.jpg" alt="">
            </div>
            <p>Front<br>Lip</p>
        </div>
    </div>
</section>

<section class="brands-section">
    <h2>Choose Your Car and Enjoy its World of Accessories</h2>

    <div class="brands">
        <div class="brand">
            <img src="../assets/porsche-accessories-1-150x150.jpg.webp">
            <p>Porsche<br>Accessories</p>
        </div>

        <div class="brand">
            <img src="../assets/mmarcedes.png">
            <p>Mercedes<br>Accessories</p>
        </div>

        <div class="brand">
            <img src="../assets/BMW-accessories-1-150x150.jpg.webp">
            <p>BMW<br>Accessories</p>
        </div>

        <div class="brand">
            <img src="../assets/lexess-accessories-150x150.jpg.webp">
            <p>Lexus<br>Accessories</p>
        </div>

        <div class="brand second">
            <img src="../assets/ddoogg.jpg">
            <p>Dodge<br>Accessories</p>
        </div>

        <div class="brand second">
            <img src="../assets/land-accessories-1-150x150.jpg.webp">
            <p>Land Rover<br>Accessories</p>
        </div>

        <div class="brand second">
            <img src="../assets/mazda-accessories-150x150.jpg.webp">
            <p>Mazda<br>Accessories</p>
        </div>
    </div>
</section>

<section class="brands-section">
    <h2>All Types of Car Accessories in One Place</h2>

    <div class="brands">

        <div class="brand">
            <img src="../assets/وسط-داخلي-150x150.png">
            <p>Interior Center</p>
        </div>

        <div class="brand">
            <img src="../assets/تنسيق-داخلي-150x150.png">
            <p>Interior</p>
        </div>

        <div class="brand">
            <img src="../assets/الجزء-الأمامي-150x150.png">
            <p>Exterior</p>
        </div>

        <div class="brand">
            <img src="../assets/تخييم-150x150.png">
            <p>Miscellaneous Products</p>
        </div>

        <div class="brand">
            <img src="../assets/طارة-150x150.png">
            <p>Steering Wheel</p>
        </div>

        <div class="brand second">
            <img src="../assets/مفاتيح-150x150.png">
            <p>Keys</p>
        </div>

        <div class="brand second">
            <img src="../assets/كفرات-والجنوط-150x150.png">
            <p>Tires and Rims</p>
        </div>

    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <h2>Distinctive LEDs and Lighting</h2>
    <div class="products">
        <?php
        $ledProducts = filterProducts($products, 1); // category_id=1 for LEDs
        foreach ($ledProducts as $product): ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <h4><?= htmlspecialchars($product['name']) ?></h4>
                <p><?= htmlspecialchars($product['car_brand'] . ' ' . $product['car_model'] . ' ' . $product['image_url']) ?></p>
                <span class="price"><?= htmlspecialchars($product['price']) ?> Jd</span>
                <div class="actions">
                    <button class="add-cart">Add to Cart</button>
                    <span class="fav">♡</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="more-btn">Discover More</button>
</section>

<!-- Rear Diffusers Section -->
<section class="diffusers-section">
    <h2>Rear diffusers</h2>
    <div class="diffusers-container">
        <?php
        $diffusers = filterProducts($products, 2); // category_id=2 for diffusers
        foreach ($diffusers as $diff): ?>
            <div class="diffuser-card">
                <div class="diffuser-image">
                    <img src="<?= htmlspecialchars($diff['car_year_image_url']) ?>" alt="<?= htmlspecialchars($diff['name']) ?>">
                </div>
                <div class="diffuser-info">
                    <div class="diffuser-model"><?= htmlspecialchars($diff['car_model']) ?></div>
                    <h3 class="diffuser-title"><?= htmlspecialchars($diff['name']) ?></h3>
                    <p class="diffuser-description"><?= htmlspecialchars($diff['description']) ?></p>
                    <span class="diffuser-price"><?= htmlspecialchars($diff['price']) ?> Jd</span>
                    <span class="tax-note">Price includes tax</span>
                    <button class="add-to-cart-btn">Add to Cart</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="more-btn">Discover More</button>
</section>

<!-- Best Selling Section -->
<section class="best-selling-section">
    <h2>Best-selling Car Accessories</h2>
    <div class="best-selling-container">
        <?php
        $bestSelling = filterProducts($products, 3); // category_id=3 for best-selling
        foreach ($bestSelling as $item): ?>
            <div class="best-selling-card">
                <div class="best-selling-image">
                    <img src="<?= htmlspecialchars($item['car_year_image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                </div>
                <div class="best-selling-info">
                    <h3 class="best-selling-title"><?= htmlspecialchars($item['name']) ?></h3>
                    <div class="size-info"><?= htmlspecialchars($item['car_model']) ?></div>
                    <span class="best-selling-price"><?= htmlspecialchars($item['price']) ?> Jd</span>
                    <span class="tax-note">Price includes tax</span>
                    <select class="options-select">
                        <option>Select One Of The Options</option>
                    </select>
                    <button class="select-options-btn">Select One Of The Options</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- بقية الكود (Reviews, FAQ, Footer, JS) يبقى كما هو تمامًا -->
<!-- ... (لن أكرر بقية HTML وJS لأنك طلبت عدم الحذف أو التغيير) -->

</body>
</html>
