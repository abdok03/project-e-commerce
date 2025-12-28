<?php
include "../config/database.php";

$dbObj = new Database();
$db = $dbObj->connecte();

$carType = "Porsche";

$q = $db->prepare("SELECT * FROM car_products WHERE car_type = ?");
$q->execute([$carType]);
$products = $q->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Carbon Chromes</title>
    <link rel="stylesheet" href="porsche.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../assets/icon.png">

</head>

<style>

    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Tahoma, Arial;
    font-weight: 600;
}
body{
    background: #fff;
    color: #000;
    direction: ltr;
}

.icons span {
    margin-right: 20px;
    cursor: pointer;
}

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 40px;
    background:white;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
    position: sticky;
    top:0;
    z-index:9999;
    background:#fff;
}

.logo{
    height:45px;
}

/* Search */
.search-box{
    display:flex;
    width:45%;
}

.search-box input{
    flex:1;
    padding:8px;
    border:1px solid #ebebeb;
}

.search-box button{
    background:#c4161c;
    color:white;
    border:none;
    padding:8px 18px;
}

/* Icons */
.icons i{
    font-size:20px;
    margin-right:18px;
    cursor:pointer;
    color:black;
}

/* Menu */
.menu{
    display:flex;
    justify-content:center;
    gap:18px;
    padding:10px 0;
    list-style:none;
}

.menu li{
    cursor:pointer;
}
.menu a{
    text-decoration: none;
    color: #000;     
    font-weight: 600;
}

.menu a:hover{
    color: #b11218;  
}



.menu .active a,
.menu li:hover{
    color:#c4161c;
}
/* Hero Filter Section */

.hero-filter{
    background: url("../assets/external.png") no-repeat center center/cover;
            background-attachment: fixed;
    color:white;
    padding:80px 20px;
    text-align:center;

}

.hero-content{
    max-width:900px;
    margin:auto;
}

.hero-filter h2{
    font-size:28px;
    font-weight:bold;
    margin-bottom:10px;
}

.hero-filter p{
    color:#ccc;
    font-size:14px;
    line-height:1.6;
    margin-bottom:40px;
}

.filter-box{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:10px;
}

.filter-box select{
    padding:12px;
    min-width:180px;
    border-radius:4px;
    border:none;
}

.search-btn{
    background:#b00000;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:4px;
    cursor:pointer;
}

.search-btn:hover{
    background:#850000;
}


/* Responsive */
@media(max-width:800px){
    .filter-box{
        flex-direction:column;
        align-items:center;
    }

    .filter-box select,
    .search-btn{
        width:90%;
    }
}

.filter-car-section{
    max-width: 400px;
    margin-left: 50px;
    margin-right: auto;
    margin-top: 40px;
}

.filter-car-section h3{
    color:#b00000;
    font-size:20px;
    font-weight:700;
    margin-bottom:15px;
    text-align:left;
}

.filter-car-box{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.filter-car-box select{
    width:100%;
    padding:12px;
    border-radius:4px;
    border:1px solid #ccc;
    font-size:14px;
}

.car-filter-btn{
    background:#b00000;
    border:none;
    padding:12px;
    color:white;
    font-weight:bold;
    border-radius:4px;
    cursor:pointer;
}

.car-filter-btn:hover{
    background:#850000;
}

/* Mobile */
@media(max-width:768px){
    .filter-car-section{
        margin:20px auto;
        text-align:center;
    }

    .filter-car-box select,
    .car-filter-btn{
        width:100%;
    }
}


.faq-section{
    max-width:900px;
    margin:60px auto;
    text-align:center;
}

.faq-title{
    font-weight:700;
    margin-bottom:20px;
}

.faq-box{
    border:1px solid #ddd;
    border-radius:6px;
}

.faq-item{
    border-bottom:1px solid #ddd;
}

.faq-item:last-child{
    border-bottom:none;
}

.faq-question{
    padding:14px;
    font-size:14px;
    text-align:left;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:10px;
}

.faq-question span{
    color:#b00000;
    font-size:18px;
    font-weight:bold;
}

.faq-answer{
    display:none;
    padding:14px;
    text-align:left;
    font-size:13px;
    color:#444;
    background:#fafafa;
}

.faq-description{
    margin-top:25px;
    color:#555;
    line-height:1.6;
}
  .footer {
            background: #1a1a1a;
            color: #ccc;
            padding: 30px 20px 20px;
            font-size: 13px;
            margin-top: 40px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #333;
        }
        
        .footer-section h3 {
            color: white;
            font-size: 15px;
            margin-bottom: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
       
        .quality-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #333;
        }
        
        .quality-item:last-child {
            border-bottom: none;
        }
        
        .quality-title {
            color: #c4161c;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .quality-desc {
            color: #999;
            font-size: 12px;
            line-height: 1.4;
        }
        
        
        .pages-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .pages-list li {
            margin-bottom: 8px;
        }
        
        .pages-list a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.2s ease;
            font-size: 12px;
        }
        
        .pages-list a:hover {
            color: #c4161c;
        }
        
        
        .social-text {
            font-size: 12px;
            color: #999;
            margin-bottom: 15px;
            line-height: 1.4;
        }
        
        .social-icons {
            display: flex;
            gap: 12px;
            margin: 15px 0;
        }
        
        .social-icon {
            width: 32px;
            height: 32px;
            background: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .social-icon:hover {
            background: #c4161c;
            transform: translateY(-3px);
        }
        
        .social-icon.facebook { background: #1877f2; }
        .social-icon.twitter { background: #1da1f2; }
        .social-icon.instagram { background: #e4405f; }
        .social-icon.whatsapp { background: #25d366; }
        .social-icon.youtube { background: #ff0000; }
        
        .contact-email {
            color: #c4161c;
            font-size: 12px;
            margin: 8px 0;
            display: block;
            text-decoration: none;
        }
        
        .contact-link {
            color: #ccc;
            text-decoration: none;
            font-size: 12px;
            transition: color 0.2s ease;
            display: inline-block;
            margin-top: 10px;
            padding: 5px 0;
        }
        
        .contact-link:hover {
            color: #c4161c;
        }
        
      
        .about-text {
            font-size: 12px;
            color: #999;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        
        .cr-number {
            font-size: 11px;
            color: #777;
            margin-top: 10px;
        }
        
        
        .copyright {
            text-align: center;
            padding: 20px 0 0;
            color: #777;
            font-size: 11px;
        }
        
        .copyright span {
            color: #c4161c;
            font-weight: 600;
        }
        
        
        @media (max-width: 992px) {
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }
        }
        
        @media (max-width: 576px) {
            .footer {
                padding: 25px 15px 15px;
            }
            
            .footer-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .footer-section {
                border-bottom: 1px solid #333;
                padding-bottom: 20px;
            }
            
            .footer-section:last-child {
                border-bottom: none;
            }
            
            .social-icons {
                gap: 10px;
            }
            
            .social-icon {
                width: 30px;
                height: 30px;
                font-size: 13px;
            }
        }

              a{
    text-decoration: none;
    }
     a:hover{
    text-decoration: none;
    }

    /* ========== CART OVERLAY + SIDEBAR ========== */

.cart-overlay{
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    z-index: 900;
    opacity: 0;
    pointer-events: none;
    transition: opacity .3s ease;
}

/* لما نفتح الكارت */
.cart-overlay.show{
    opacity: 1;
    pointer-events: auto;
}
.cart-sidebar{
    position: fixed;
    top: 0;
    right: -420px; 
    width: 400px;
    height: 100vh;
    background: #fff;
    z-index: 9999;
    box-shadow: -3px 0 10px rgba(0,0,0,0.2);
    overflow-y: auto;
    transition: right .35s ease;   
}
.cart-sidebar.open{
    right: 0;        
}

/* Header */
.cart-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-bottom: 1px solid #eee;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .5px;
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 10;


}



.cart-close{
    display: flex;
    align-items: center;
    gap: 6px;
    background: none;
    border: none;
    font-size: 12px;
    cursor: pointer;
    color: #111;
}

.cart-close i{
    font-size: 14px;
}

.cart-title{
    font-weight: 700;
    font-size: 14px;
}

/* Body */
.cart-items{
    flex: 1;
    overflow-y: auto;
    padding: 15px 18px;
}

.empty-cart{
    font-size: 14px;
    color: #666;
    text-align: center;
    margin-top: 40px;
}

/* Cart item */
.cart-item{
    display: flex;
    gap: 10px;
    padding: 10px;
    border-bottom: 1px solid #eee;
}
.cart-item img{
    width: 65px;
    height: 65px;
    object-fit: cover;
}
.cart-item-info{
    font-size: 14px;
}



.cart-item-name{
    font-weight: 600;
    margin-bottom: 4px;
}

.cart-item-price{
    color: #b00000;
    font-weight: 600;
    margin-bottom: 2px;
}

.cart-item-qty{
    font-size: 12px;
    color: #777;
}

/* Footer */
.cart-footer{
    border-top: 1px solid #eee;
    padding: 12px 18px 16px;
}

.cart-total{
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    margin-bottom: 12px;
}

.cart-total span:last-child{
    font-weight: 700;
}

.cart-footer-buttons{
    display: flex;
    gap: 8px;
}

.cart-btn{
    flex: 1;
    padding: 9px 8px;
    font-size: 12px;
    border-radius: 3px;
    border: none;
    cursor: pointer;
    text-transform: uppercase;
}

.cart-btn.primary{
    background: #111;
    color: #fff;
}

.cart-btn.secondary{
    background: #e4e4e4;
    color: #333;
}

/* Scrollbar بسيط */
.cart-items::-webkit-scrollbar{
    width: 6px;
}
.cart-items::-webkit-scrollbar-thumb{
    background: #ccc;
    border-radius: 3px;
}


</style>
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
        <li><a href="../html/index.html">Home</a></li>
        <li><a href="../html/internal.html">Internal</a></li>
        <li><a href="../html/external.html">External</a></li>
        <li><a href="../html/Variousproducts.html">Various products</a></li>
    </ul>



    <section class="hero-filter">
    <div class="hero-content">

        <h2>Select your car category to see the products specific to it.</h2>

        <p>
            A wide selection of grilles is available to suit various car makes and models.
            BMW grilles, front axle grilles, lower grilles for Mercedes vehicles, and other grille types.
        </p>

        <div class="filter-box">

            <select>
                <option selected disabled>Porsche</option>
                <option>BMW</option>
                <option>Mercedes</option>
            </select>

            <select>
                <option selected disabled>Car model</option>
                <option>911</option>
                <option>Cayenne</option>
                <option>Macan</option>
            </select>

            <select>
                <option selected disabled>Year of manufacture</option>
                <option>2025</option>
                <option>2024</option>
                <option>2023</option>
            </select>

            <select>
                <option selected disabled>Net</option>
                <option>Front Grille</option>
                <option>Rear Grille</option>
            </select>
            
            <button class="search-btn">Research</button>

        </div>

    </div>
</section>

<section class="filter-car-section">
    <h3>Filter parts by car</h3>

    <div class="filter-car-box">

        <select>
            <option selected disabled>PORSCHE</option>
            <option>BMW</option>
            <option>Mercedes</option>
        </select>

        <select>
            <option selected disabled>Car model</option>
            <option>911</option>
            <option>Cayenne</option>
            <option>Macan</option>
        </select>

        <select>
            <option selected disabled>Year of manufacture</option>
            <option>2025</option>
            <option>2024</option>
            <option>2023</option>
        </select>

        <select>
            <option selected disabled>Net</option>
            <option>Front Grille</option>
            <option>Rear Grille</option>
        </select>

        <button class="car-filter-btn">research</button>

    </div>
</section>

<section class="products-section">
    <h2>Available Products</h2>

    <div class="products-grid">

        <?php if(empty($products)): ?>

            <h2 style="text-align:center; color:red; width:100%;">
                Product Not Found
            </h2>

        <?php else: ?>

            <?php foreach($products as $p): ?>
            
            <div class="product-card">
                <img src="../uploads/<?= $p['image'] ?>" alt="">
                
                <h3><?= $p['name'] ?></h3>

                <p><?= $p['price'] ?> SAR</p>

                <a href="single_product.php?id=<?= $p['id'] ?>" class="view-btn">
                    View Details
                </a>
            </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</section>




<section class="faq-section">

    <h3 class="faq-title">Frequently asked questions</h3>

    <div class="faq-box">
        <div class="faq-item">
            <div class="faq-question">
                <span>+</span>
                Is the grille you have available identical to the one from the agency?
            </div>
            <div class="faq-answer">
                Yes, they are high-quality grilles identical in shape and fit.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>+</span>
                Is shipping free?
            </div>
            <div class="faq-answer">
                Shipping depends on country and delivery method.
            </div>
        </div>
    </div>

    <p class="faq-description">
        A wide selection of grilles is available to suit various car makes and models.
        BMW grilles, front axle grilles, lower grilles for Mercedes vehicles,
        and other grille types.
    </p>

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
                <button class="cart-btn primary" onclick="window.location.href='../html/checkout.html'">Complete the order</button>
                <button  class="cart-btn secondary" onclick="window.location.href='../html/cart.html'">Basket display</button>
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

<script>
document.querySelectorAll(".faq-question").forEach(q =>{
    q.addEventListener("click", ()=>{
        let answer = q.nextElementSibling;
        answer.style.display =
            answer.style.display === "block" ? "none" : "block";
    });
});
</script>
</body>
</html>