<?php
include "../config/database.php";

$db = (new Database())->connecte();

// أولاً عرّفي الكاتيجوري
$category = $_GET['category'] ?? null;

// عدد كل المنتجات الداخلية
if($category){
    $countQuery = $db->prepare("
        SELECT COUNT(*) FROM car_products
        WHERE main_type='internal' AND category_slug = :cat
    ");
    $countQuery->bindParam(":cat", $category);
} else {
    $countQuery = $db->prepare("
        SELECT COUNT(*) FROM car_products
        WHERE main_type='internal'
    ");
}

$countQuery->execute();
$total = $countQuery->fetchColumn();


$category = $_GET['category'] ?? null;

// ================= COUNT =================
if($category == "internal"){
    $countQuery = $db->prepare("
        SELECT COUNT(*) FROM products
        WHERE main_type='internal'
    ");
}
elseif($category){
    $countQuery = $db->prepare("
        SELECT COUNT(*) FROM car_products
        WHERE main_type='internal' AND category_slug = :cat
    ");
    $countQuery->bindParam(":cat", $category);
}
else{
    $countQuery = $db->prepare("
        SELECT COUNT(*) FROM car_products
        WHERE main_type='internal'
    ");
}

$countQuery->execute();
$total = $countQuery->fetchColumn();

// ================= PRODUCTS =================
if($category == "internal"){
    $productQuery = $db->prepare("
        SELECT * FROM car_products
        WHERE main_type='internal'
        ORDER BY popularity DESC
    ");
}
elseif($category){
    $productQuery = $db->prepare("
        SELECT * FROM car_products
        WHERE main_type='internal'
        AND category_slug=:cat
        ORDER BY popularity DESC
    ");
    $productQuery->bindParam(":cat", $category);
}
else{
    $productQuery = $db->prepare("
        SELECT * FROM car_products
        WHERE main_type='internal'
        ORDER BY popularity DESC
        LIMIT 5
    ");
}

$productQuery->execute();
$products = $productQuery->fetchAll(PDO::FETCH_ASSOC);


$productQuery->execute();
$products = $productQuery->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Carbon Chromes</title>
    <link rel="stylesheet" href="../css/internal.css">
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
            <a href="#" onclick="openPopup()"><i class="fa fa-user"></i></a>
            <i class="fa fa-heart"></i>
            <i class="fa fa-shopping-cart" id="cartIcon"></i>
        </div>
    </nav>

    <ul class="menu">
        <li><a href="index.html">Home</a></li>
        <li class="active"><a href="internal.html">Internal</a></li>
        <li><a href="external.html">External</a></li>
        <li><a href="Variousproducts.html">Various products</a></li>
    </ul>

    <!-- قسم Hero لصفحة Interior -->
    <section class="hero interior-hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Internal Car Accessories</h1>
        </div>
    </section>

    <section class="brands-section">
        <div class="section-title">
            <h2>Internal Components</h2>
            <div class="title-line"></div>
            <p>Explore our premium collection of internal car accessories. High quality, perfect fit, and professional
                installation.</p>
        </div>
        <div class="brands-container">
            <div class="brands-scroll">
                <div class="brands-row">
                    <a href="product-category.php?category=interior-center"
                        style="text-decoration: none; color: inherit;"></a>
                    <div class="brand" onclick="window.location.href='product-category.php?category=interior-center'">
                        <div class="brand-image">
                            <img src="../assets/وسط-داخلي-150x150.png" alt="Interior Center">
                        </div>
                        <div class="brand-name">Interior Center</div>
                    </div>

                    <div class="brand">
                        <div class="brand-image">
                            <img src="../assets/تنسيق-داخلي-150x150.png" alt="Interior design">
                        </div>
                        <div class="brand-name">Interior Design</div>
                    </div>

                    <div class="brand">
                        <div class="brand-image">
                            <img src="../assets/أبواب-300x300.png" alt="Door">
                        </div>
                        <div class="brand-name">Door</div>
                    </div>

                    <div class="brand">
                        <div class="brand-image">
                            <img src="../assets/أرضيات-150x150.png" alt="Floors">
                        </div>
                        <div class="brand-name">Floors</div>
                    </div>

                    <div class="brand">
                        <div class="brand-image">
                            <img src="../assets/شعارات-وسبائك-300x300.png" alt="Logos and alloys">
                        </div>
                        <div class="brand-name">Logos & Alloys</div>
                    </div>

                    <div class="brand">
                        <div class="brand-image">
                            <img src="../assets/طبلون-1-300x300.png" alt="Dashboard">
                        </div>
                        <div class="brand-name">Dashboard</div>
                    </div>

                    <div class="brand">
                        <div class="brand-image">
                            <img src="../assets/طارة-300x300.png" alt="Hoop">
                        </div>
                        <div class="brand-name">Hoop</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم المنتجات  -->
    <section class="products-page">
        <div class="page-header">
            <h2 class="page-title">Premium Car Accessories</h2>
            <p class="page-subtitle">Discover our exclusive collection of high-quality internal car accessories designed
                for luxury and performance vehicles.</p>
        </div>

        <div class="products-controls">
            <div class="results-count">
                Showing
                <?= $total ?> Products
            </div>

            <div class="products-filters">
                <form method="GET">
                    <?php $selectedCategory = $_GET['category'] ?? ''; ?>
                    <select  id="categoryFilter" name="category" class="filter-select" onchange="this.form.submit()">
                        <option value="">Filter by Category</option>
                        <option value="internal">Internal</option>
                        <option value="interior center">Interior Center</option>
                        <option value="dashboard">Dashboard</option>
                        <option value="buttons">Buttons</option>
                        <option value="displays">Displays</option>
                    </select>
                </form>


                <select class="sort-select">
                    <option>Sort by: Default</option>
                    <option>Sort by: Price Low to High</option>
                    <option>Sort by: Price High to Low</option>
                    <option>Sort by: Popularity</option>
                    <option>Sort by: Newest</option>
                </select>
            </div>
        </div>

        <div class="products-grid">

            <?php if (empty($products)): ?>

                <h2 style="width:100%; text-align:center; color:red;">
                    No Products Found
                </h2>

            <?php else: ?>

                <?php foreach ($products as $p): ?>

                    <div class="product-card">

                        <?php if (!empty($p['badge'])): ?>
                            <div class="product-badge">
                                <?= htmlspecialchars($p['badge']) ?>
                            </div>
                        <?php endif; ?>

                        <div class="product-image">
                            <img src="../uploads/<?= $p['image'] ?>" alt="">
                        </div>

                        <div class="product-content">

                            <h3 class="product-title">
                                <?= htmlspecialchars($p['name']) ?>
                            </h3>

                            <div class="product-price">
                                <span class="price-label">Price includes tax</span>
                                <span class="price-value"><?= $p['price'] ?> SAR</span>
                            </div>

                            <div class="card-actions">
                                <button class="favorite-btn">♡</button>

                                <a href="../php/product.php?id=<?= $p['id'] ?>"
                                    class="action-button">
                                    View Product
                                </a>
                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

        <!-- الترقيم الصفحات -->
        <div class="pagination">
            <button class="page-btn prev">← Previous</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">4</button>
            <button class="page-btn">5</button>
            <button class="page-btn next">Next →</button>
        </div>
    </section>



    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Quality Assurance</h3>
                <div class="quality-item">
                    <div class="quality-title">More than 7,500 products</div>
                    <div class="quality-desc">Extensive collection of premium car accessories</div>
                </div>
                <div class="quality-item">
                    <div class="quality-title">100% Payment Refund</div>
                    <div class="quality-desc">Full refund guarantee on all purchases</div>
                </div>
                <div class="quality-item">
                    <div class="quality-title">Free Shipping</div>
                    <div class="quality-desc">For orders over 289 Saudi Riyal</div>
                </div>
            </div>


            <div class="footer-section">
                <h3>Pages</h3>
                <ul class="pages-list">
                    <li><a href="#">Who are we?</a></li>
                    <li><a href="#">Shipping and Delivery</a></li>
                    <li><a href="#">Privacy Notice</a></li>
                    <li><a href="#">Terms and Conditions</a></li>
                    <li><a href="#">Return and servicing policy</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
            </div>


            <div class="footer-section">
                <h3>We Are On Social Media Platforms</h3>
                <p class="social-text">If you have any questions, you can contact us all:</p>

                <div class="social-icons">
                    <a href="#" class="social-icon facebook" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon twitter" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon instagram" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon whatsapp" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" class="social-icon youtube" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>


            <div class="footer-section">
                <h3>Who are we?</h3>
                <p class="about-text">A store specializing in car accessories and personal accessories. A financial
                    basis scheme All Magicians Trading Establishment C.R (68202196/79).</p>
                <div class="cr-number">Commercial Registration: 68202196/79</div>
            </div>
        </div>


        <div class="copyright">
            <div>All Rights Reserved. <span>Enhancements</span> Copyright © 2025</div>
        </div>
    </footer>


    <!-- Popup Login -->
    <!-- Overlay Background -->
    <div class="popup-overlay" id="popup">
        <div class="popup-box">

            <img src="../assets/logo.png" class="popup-logo">

            <div class="popup-title">Mobile number</div>

            <div class="popup-input">
                <span>+962</span>
                <input type="text" placeholder="Enter mobile number">
            </div>

            <button class="popup-btn" onclick="openPasswordPopup()">
                Login with Password
            </button>

        </div>
    </div>

    <!-- Password Popup -->
    <div class="popup-overlay" id="passwordPopup" style="display:none;">
        <div class="popup-box">

            <img src="../assets/logo.png" class="popup-logo">

            <h3 id="welcomeText">Welcome back, User</h3>

            <div class="popup-title">Enter Password</div>

            <div class="popup-input">
                <input type="password" placeholder="Enter your password">
            </div>

            <button class="popup-btn">
                Login
            </button>

        </div>
    </div>

    <!-- Cart Overlay -->
    <div id="cartOverlay" class="cart-overlay"></div>

    <!-- Cart Sidebar -->
    <div id="cartSidebar" class="cart-sidebar">

        <div class="cart-header">
            <button id="cartCloseBtn" class="cart-close">
                <i class="fa fa-times"></i>
                <span>CLOSING</span>
            </button>

            <span class="cart-title">SHOPPING CART</span>
        </div>

        <div id="cartItems" class="cart-items">
            <!-- JS will inject items here -->
            <p class="empty-cart">No products in the cart.</p>
        </div>

        <div class="cart-footer">
            <div class="cart-total">
                <span>Total (Including VAT)</span>
                <span id="cartTotal">0 SAR</span>
            </div>

            <div class="cart-footer-buttons">
                <button class="cart-btn primary" onclick="window.location.href='checkout.html'">Complete the
                    order</button>
                <button class="cart-btn secondary" onclick="window.location.href='cart.html'">Basket display</button>
            </div>
        </div>

    </div>



    <script>
        document.querySelectorAll('.brand').forEach(brand => {
            brand.addEventListener('click', function() {
                const categoryName = this.querySelector('.brand-name').textContent;
                window.location.href = `product-category.php?category=${encodeURIComponent(categoryName.toLowerCase().replace(/ & /g, '-').replace(/ /g, '-'))}`;
            });
        });


        function openPopup() {
            document.getElementById("popup").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        function openPasswordPopup() {

            let userName = "Ruba";

            document.getElementById("welcomeText").innerText =
                "Welcome back, " + userName;

            document.getElementById("popup").style.display = "none";
            document.getElementById("passwordPopup").style.display = "flex";
        }


        // Popup 1 -------------
        const popupOverlay1 = document.getElementById("popup");
        const popupBox1 = popupOverlay1.querySelector(".popup-box");

        popupOverlay1.addEventListener("click", function() {
            popupOverlay1.style.display = "none";
        });

        popupBox1.addEventListener("click", function(e) {
            e.stopPropagation();
        });


        // Popup 2 -------------
        const popupOverlay2 = document.getElementById("passwordPopup");
        const popupBox2 = popupOverlay2.querySelector(".popup-box");

        popupOverlay2.addEventListener("click", function() {
            popupOverlay2.style.display = "none";
        });

        popupBox2.addEventListener("click", function(e) {
            e.stopPropagation();
        });
    </script>

    <script>
        const cartSidebar = document.getElementById('cartSidebar');
        const cartOverlay = document.getElementById('cartOverlay');
        const cartCloseBtn = document.getElementById('cartCloseBtn');
        const cartIcon = document.getElementById('cartIcon');
        const cartItemsBox = document.getElementById('cartItems');
        const cartTotalEl = document.getElementById('cartTotal');

        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        renderCart();



        function openCart() {
            cartSidebar.classList.add('open');
            cartOverlay.classList.add('show');
        }


        function closeCart() {
            cartSidebar.classList.remove('open');
            cartOverlay.classList.remove('show');
        }


        function renderCart() {
            cartItemsBox.innerHTML = '';

            if (cart.length === 0) {
                cartItemsBox.innerHTML = '<p class="empty-cart">No products in the cart.</p>';
                cartTotalEl.textContent = '0 SAR';
                return;
            }

            let total = 0;

            cart.forEach(item => {
                total += item.price * item.qty;

                const div = document.createElement('div');
                div.className = 'cart-item';

                div.innerHTML = `
                <img src="${item.image}" alt="">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">${item.price} SAR</div>
                    <div class="cart-item-qty">Qty: ${item.qty}</div>
                </div>
            `;

                cartItemsBox.appendChild(div);
            });

            cartTotalEl.textContent = total + ' SAR';
            localStorage.setItem("cart", JSON.stringify(cart));

        }

        function addToCart(product) {

            const existing = cart.find(p => p.name === product.name);
            if (existing) {
                existing.qty += 1;
            } else {
                cart.push({
                    ...product,
                    qty: 1
                });
            }

            renderCart();
            localStorage.setItem("cart", JSON.stringify(cart));

            openCart();
        }

        // ربط أيقونة الكارت
        if (cartIcon) {
            cartIcon.addEventListener('click', openCart);
        }

        // زر الإغلاق
        cartCloseBtn.addEventListener('click', closeCart);
        cartOverlay.addEventListener('click', closeCart);

        // ربط أزرار Add to cart
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                const product = {
                    name: this.dataset.name,
                    price: parseFloat(this.dataset.price),
                    image: this.dataset.image || '../assets/logo.png'
                };
                addToCart(product);
            });
        });


        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {

            btn.addEventListener('click', function() {

                const product = {
                    name: this.dataset.name,
                    price: parseFloat(this.dataset.price),
                    image: this.dataset.image
                };

                addToCart(product);
            });

        });
    </script>
    <script>
function filterCategory(val){
    if(val === "internal"){
        window.location.href = "internal.php?category=internal";
    }else if(val){
        window.location.href = "internal.php?category=" + val;
    }else{
        window.location.href = "internal.php";
    }
}
</script>

<script>

    const params = new URLSearchParams(window.location.search);
const cat = params.get('category');

if(cat){
    document.getElementById("categoryFilter").value = cat;
}

document.getElementById("categoryFilter").addEventListener("change", function () {
    const value = this.value;
    if(value !== "") {
        window.location.href = "internal.php?category=" + value;
    } else {
        window.location.href = "internal.php";
    }
});
</script>


</body>

</html>