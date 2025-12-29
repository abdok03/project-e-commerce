<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Carbon Chromes</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="porsche.css">
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
            <a href="../html/login.html"><i class="fa fa-user"></i></a>
            <i class="fa fa-heart"></i>
            <i class="fa fa-shopping-cart" id="cartIcon"></i>
        </div>

    </nav>

    <ul class="menu">
        <li><a href="../html/index.php">Home</a></li>
        <li><a href="../html/internal.html">Internal</a></li>
        <li><a href="../html/external.html">External</a></li>
        <li><a href="../html/Variousproducts.html">Various products</a></li>
    </ul>


    <section class="porsche-section">

        <h2 class="porsche-title">Porsche car accessories</h2>

        <div class="porsche-grid">

            <a href="../php/product.php?id=1" class="porsche-item">
                <img src="Candle bottles.webp" alt="">
                <p>Candle bottles</p>
            </a>


            <a href="../php/product.php?id=2" class="porsche-item">
                <img src="Porsche spark plug skins.webp" alt="">
                <p>Porsche spark plug skins</p>
            </a>

            <a href="../php/product.php?id=3" class="porsche-item">
                <img src="Bag logos.webp" alt="">
                <p>Bag logos</p>
            </a>

            <a href="../php/product.php?id=4" class="porsche-item">
                <img src="porsche wings.webp" alt="">
                <p>Porsche Wings</p>
            </a>

            <a href="../php/product.php?id=5" class="porsche-item">
                <img src="projector.webp" alt="">
                <p>Projector</p>
            </a>

            <a href="../php/product.php?id=6" class="porsche-item">
                <img src="Air conditioner fins and decorations.webp" alt="">
                <p>Air conditioner fins and decorations</p>
            </a>

            <a href="../php/product.php?id=7" class="porsche-item">
                <img src="Door buttons.webp" alt="">
                <p>Door buttons</p>
            </a>

            <a href="../php/product.php?id=8" class="porsche-item">
                <img src="Key cover.webp" alt="">
                <p>Key cover</p>
            </a>

            <a href="../php/product.php?id=9" class="porsche-item">
                <img src="medal.webp" alt="">
                <p>medal</p>
            </a>

            <a href="../php/product.php?id=10" class="porsche-item">
                <img src="Wheel covers.webp" alt="">
                <p>Wheel covers</p>
            </a>

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
                <button class="cart-btn primary" onclick="window.location.href='../html/checkout.html'">Complete the
                    order</button>
                <button class="cart-btn secondary" onclick="window.location.href='../html/cart.html'">Basket
                    display</button>
            </div>
        </div>

    </div>

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