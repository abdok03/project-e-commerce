<?php
ini_set('session.cookie_path', '/');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/login.html');
    exit;
}
require_once "../includes/auth.php";
require_once "../config/database.php";

$db = (new Database())->connecte();

$query = "SELECT * FROM products ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

function filterProducts($products, $category_id)
{
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            <i class="fa fa-shopping-cart" id="cartIcon"></i>

        </div>

    </nav>

    <ul class="menu">
        <li class="active"><a href="index.html">Home</a></li>
        <li><a href="internal.html">Internal</a></li>
        <li><a href="external.html">External</a></li>
        <li><a href="Variousproducts.html">Various products</a></li>
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
            <a href="../Car page/porsche.php" class="brand">
                <img src="../assets/porsche-accessories-1-150x150.jpg.webp">
                <p>Porsche<br>Accessories</p>
            </a>

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

            <a href="product-category.html?category=interior-center" class="brand">
                <img src="../assets/وسط-داخلي-150x150.png">
                <p>Interior Center</p>
            </a>


            <a href="internal.html " class="brand">
                <img src="../assets/تنسيق-داخلي-150x150.png">
                <p>Interior</p>
            </a>

            <a href="external.html" class="brand">
                <img src="../assets/الجزء-الأمامي-150x150.png">
                <p>External</p>
            </a>

            <a href="Variousproducts.html" class="brand">
                <img src="../assets/تخييم-150x150.png">
                <p>Various products</p>
            </a>

            <a href="product-category.html?category=hoop" class="brand">
                <img src="../assets/طارة-150x150.png">
                <p>Steering Wheel</p>
            </a>

            <a href="product-category.html?category=keys" class="brand second">
                <img src="../assets/مفاتيح-150x150.png">
                <p>Keys</p>
            </a>


            <a href="product-category.html?category=tires-rims" class="brand second">
                <img src="../assets/كفرات-والجنوط-150x150.png">
                <p>Tires and Rims</p>
            </a>


        </div>
    </section>
    <section class="products-section">
        <h2>Distinctive LEDs and Lighting</h2>
        <div class="products">
            <?php
            $ledProducts = filterProducts($products, 1); // category_id=1 for LEDs
            foreach ($ledProducts as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>">
                    <h4><?= htmlspecialchars($product['name']) ?></h4>
                    <p><?= htmlspecialchars($product['car_brand'] . ' ' . $product['car_model']) ?></p>
                    <span class="price"><?= htmlspecialchars($product['price']) ?> Jd</span>

                    <form method="POST" action="../php/add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="diffusers-section">
        <h2>Rear diffusers</h2>
        <div class="diffusers-container">
            <?php
            $diffusers = filterProducts($products, 2); // category_id=2 for diffusers
            foreach ($diffusers as $diff): ?>
                <div class="diffuser-card">
                    <div class="diffuser-image">
                        <img src="<?= htmlspecialchars($diff['car_year_image_url']) ?>"
                            alt="<?= htmlspecialchars($diff['name']) ?>">
                    </div>
                    <div class="diffuser-info">
                        <div class="diffuser-model"><?= htmlspecialchars($diff['car_model']) ?></div>
                        <h3 class="diffuser-title"><?= htmlspecialchars($diff['name']) ?></h3>
                        <p class="diffuser-description"><?= htmlspecialchars($diff['description']) ?></p>
                        <span class="diffuser-price"><?= htmlspecialchars($diff['price']) ?> Jd</span>
                        <span class="tax-note">Price includes tax</span>
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </div>
                    <form method="POST" action="../php/add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>

                </div>
            <?php endforeach; ?>
        </div>
        <button class="more-btn">Discover More</button>
    </section>


    <section class="best-selling-section">
        <h2>Best-selling Car Accessories</h2>
        <div class="best-selling-container">
            <?php
            $bestSelling = filterProducts($products, 3); // category_id=3 for best-selling
            foreach ($bestSelling as $item): ?>
                <div class="best-selling-card">
                    <div class="best-selling-image">
                        <img src="<?= htmlspecialchars($item['car_year_image_url']) ?>"
                            alt="<?= htmlspecialchars($item['name']) ?>">
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
                    <form method="POST" action="../php/add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>

                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="reviews-section">
        <h2>Customer Reviews of Carbon Chrome Store</h2>

        <div class="slider-container">
            <button class="slider-btn prev-btn">‹</button>
            <button class="slider-btn next-btn">›</button>

            <div class="slider">
                <div class="slide">
                    <div class="review-content">
                        <p class="review-text">Ordered a set of wheel covers and they arrived sooner than expected.
                            Perfect fit and excellent quality. The price was very reasonable compared to other stores.
                            Thank you!</p>

                        <!-- النجوم -->
                        <div class="stars-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>

                        <div class="customer-info">
                            <div class="customer-name">SAUD M...</div>
                            <div class="customer-location">Mecca</div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="slide">
                    <div class="review-content">
                        <p class="review-text">Excellent service and very fast delivery, especially considering I
                            ordered on the weekend. The product quality exceeded my expectations and the customer
                            support was very helpful.</p>

                        <!-- النجوم -->
                        <div class="stars-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>

                        <div class="customer-info">
                            <div class="customer-name">AHMED H...</div>
                            <div class="customer-location">Riyadh</div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="slide">
                    <div class="review-content">
                        <p class="review-text">The carbon fiber parts I ordered were perfectly crafted and fit my car
                            like they were OEM. Shipping was surprisingly fast and the packaging was extremely secure.
                        </p>

                        <!-- النجوم -->
                        <div class="stars-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>

                        <div class="customer-info">
                            <div class="customer-name">MOHAMMED A...</div>
                            <div class="customer-location">Jeddah</div>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="slide">
                    <div class="review-content">
                        <p class="review-text">Best online store for car accessories! Professional customer service and
                            premium quality products. The LED kit transformed my car's appearance completely.</p>

                        <!-- النجوم -->
                        <div class="stars-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>

                        <div class="customer-info">
                            <div class="customer-name">KHALED S...</div>
                            <div class="customer-location">Dubai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dots Navigation -->
        <div class="dots-container">
            <span class="dot active" data-slide="0"></span>
            <span class="dot" data-slide="1"></span>
            <span class="dot" data-slide="2"></span>
            <span class="dot" data-slide="3"></span>
        </div>
    </section>

    <!-- قسم الأسئلة  (FAQ) -->
    <section class="faq-section">
        <h2 class="faq-title">Frequently Asked Questions about Car Accessories</h2>

        <div class="faq-container">
            <!-- سؤال 1 -->
            <div class="faq-item active">
                <div class="faq-question">
                    <span>Do you have men's car accessories?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, we offer a wide range of car accessories designed for men, including performance parts, tech
                        gadgets, and stylish modifications.</p>
                </div>
            </div>

            <!-- سؤال 2 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you have women's car accessories?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, we provide accessories for women including elegant interior decorations, safety accessories,
                        and personalized items.</p>
                </div>
            </div>

            <!-- سؤال 3 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>What types of car accessories are available at Carbon Chrome store?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>We offer interior modifications, External enhancements, lighting kits, rims, tires, keys, and
                        accessories for all major car brands.</p>
                </div>
            </div>

            <!-- سؤال 4 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>Is shipping free?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes! Free shipping for orders over 20 Dinar. Small fee for orders below that amount.</p>
                </div>
            </div>

            <!-- سؤال 5 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you offer installation services?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>We recommend trusted installation partners. Most products come with detailed installation guides.
                    </p>
                </div>
            </div>

            <!-- سؤال 6 -->
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is your return policy?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>14-day return policy for unused items in original packaging. Contact customer service for
                        returns.</p>
                </div>
            </div>
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


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        // Slider JavaScript
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.querySelector('.slider');
            const slides = document.querySelectorAll('.slide');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            const dots = document.querySelectorAll('.dot');

            let currentSlide = 0;
            const totalSlides = slides.length;

            // Function to update slider position
            function updateSlider() {
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;

                // Update active dot
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentSlide);
                });
            }

            // Next slide
            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }

            // Previous slide
            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
            }

            // Event listeners for buttons
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            // Event listeners for dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentSlide = index;
                    updateSlider();
                });
            });

            // Auto slide every 7 seconds
            let slideInterval = setInterval(nextSlide, 7000);

            // Pause auto slide on hover
            const sliderContainer = document.querySelector('.slider-container');
            sliderContainer.addEventListener('mouseenter', () => {
                clearInterval(slideInterval);
            });

            sliderContainer.addEventListener('mouseleave', () => {
                slideInterval = setInterval(nextSlide, 7000);
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    prevSlide();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                }
            });
        });



        // FAQ Accordion Functionality
        document.addEventListener('DOMContentLoaded', function () {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');

                question.addEventListener('click', () => {
                    // Close all other items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('active')) {
                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle current item
                    item.classList.toggle('active');
                });
            });

            // Open first FAQ by default
            if (faqItems.length > 0) {
                faqItems[0].classList.add('active');
            }
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
                cart.push({ ...product, qty: 1 });
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
            btn.addEventListener('click', function () {
                const product = {
                    name: this.dataset.name,
                    price: parseFloat(this.dataset.price),
                    image: this.dataset.image || '../assets/logo.png'
                };
                addToCart(product);
            });
        });


        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {

            btn.addEventListener('click', function () {

                const product = {
                    name: this.dataset.name,
                    price: parseFloat(this.dataset.price),
                    image: this.dataset.image
                };

                addToCart(product);
            });

        });

    </script>

</body>

</html>