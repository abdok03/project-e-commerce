<?php
session_start();
require_once "../config/database.php";
require_once "../classes/user.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$db = (new Database())->connecte();
$userObj = new Users($db);

$user_id = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT name, email, phone_number FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found!";
    exit;
}
?>

<?php
$orders = $db->prepare("SELECT status FROM orders WHERE user_id=?");
$orders->execute([$user_id]);
$data = $orders->fetchAll(PDO::FETCH_COLUMN);

$total_orders = count($data);
$delivered = count(array_filter($data, fn($s) => $s == "Delivered"));
$pending = count(array_filter($data, fn($s) => $s == "Pending"));
$approved = count(array_filter($data, fn($s) => $s == "Approved"));
?>
<?php
$orderStmt = $db->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC");
$orderStmt->execute([$user_id]);
$userOrders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
require_once "../classes/Address.php";
$addressObj = new Address($db);
$addresses = $addressObj->getUserAddresses($user_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile | Carbon Chromes</title>
    <link rel="stylesheet" href="../css/internal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="icon" type="image/x-icon" href="../assets/icon.png">
    <link rel="stylesheet" href="../css/external.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../css/profile.css">
</head>
<style>
    
</style>

<body>
    <nav class="navbar">
        <img src="../assets/logo.png" class="logo">
        <div class="search-box">
            <input type="text" placeholder="Search for products...">
            <button>Search</button>
        </div>
        <div class="icons">
            <a href="#"><i class="fa fa-user"></i></a>
            <i class="fa fa-heart"></i>
            <i class="fa fa-shopping-cart" id="cartIcon"></i>
        </div>
    </nav>

    <ul class="menu">
        <li><a href="index.html">Home</a></li>
        <li><a href="internal.html">Internal</a></li>
        <li><a href="external.html">External</a></li>
        <li><a href="Variousproducts.html">Various products</a></li>
    </ul>

    <div class="account-page">


        <aside class="account-sidebar">
            <h2>My Account</h2>
            <ul>
                <li class="active">Dashboard</li>
                <li>Orders</li>
                <li>Addresses</li>
                <li>Account Details</li>
                <li class="logout">Logout</li>
            </ul>
        </aside>

        <section class="account-content" id="dashboardSection">

            <div class="welcome-box">
                <h2>Welcome back, <?php echo $user['name']; ?> </h2>
                <p>Here you can manage your account, track your orders, edit your details and manage your addresses.</p>
            </div>

            <div class="stats-grid">

                <div class="stat-card">
                    <i class="fa-solid fa-box"></i>
                    <h3><?php echo $total_orders ?></h3>
                    <p>Total Orders</p>
                </div>

                <div class="stat-card">
                    <i class="fa-solid fa-truck-fast"></i>
                    <h3><?php echo $delivered ?></h3>
                    <p>Shipped Orders</p>
                </div>

                <div class="stat-card">
                    <i class="fa-solid fa-clock"></i>
                    <h3><?php echo $pending ?></h3>
                    <p>Pending Orders</p>
                </div>

            </div>


            <div class="account-cards">

                <div class="big-card">
                    <div>
                        <h3>Orders</h3>
                        <p>View and track your recent orders</p>
                    </div>
                    <button onclick="showSection('orders')">View Orders</button>
                </div>

                <div class="big-card">
                    <div>
                        <h3>Addresses</h3>
                        <p>Manage your billing & shipping addresses</p>
                    </div>
                    <button onclick="showSection('addresses')">Manage</button>
                </div>

                <div class="big-card">
                    <div>
                        <h3>Account Details</h3>
                        <p>Edit your personal information & password</p>
                    </div>
                    <button onclick="showSection('account')">Edit</button>
                </div>

            </div>

        </section>


        <div id="ordersSection" style="display:none" class="account-content">

            <h2>Your Orders</h2>

            <!-- Filter Tabs -->
            <div class="order-filters">
                <button class="filter-btn active" onclick="filterOrders('all')">All</button>
                <button class="filter-btn" onclick="filterOrders('shipped')">Shipped</button>
                <button class="filter-btn" onclick="filterOrders('processing')">Processing</button>
                <button class="filter-btn" onclick="filterOrders('canceled')">Canceled</button>
            </div>

            <div class="orders-list">

                <?php if (empty($userOrders)): ?>
                    <p>No Orders Found</p>

                <?php else: ?>
                    <?php foreach ($userOrders as $o): ?>
                        <div class="order-card" data-status="<?= strtolower($o['status']) ?>">
                            <div class="order-top">
                                <span class="order-id">#CC<?= $o['id'] ?></span>
                                <span class="badge <?= strtolower($o['status']) ?>">
                                    <?= $o['status'] ?>
                                </span>
                            </div>

                            <p class="order-date"><?= $o['created_at'] ?></p>
                            <p class="order-total"><?= $o['total_amount'] ?> SAR</p>

                            <button class="small-btn"
                                onclick="openOrderDetails('#CC<?= $o['id'] ?>','<?= $o['created_at'] ?>','<?= $o['status'] ?>','<?= $o['total_amount'] ?> SAR')">
                                View Details
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>


            </div>
        </div>


        <div id="addressSection" style="display:none" class="account-content">

            <div class="address-top">
                <h2>My Addresses</h2>
                <button class="add-address-btn" onclick="openAddressModal('shipping')">
                    <i class="fa-solid fa-plus"></i> Add Address
                </button>
            </div>

            <div class="address-grid">
                <?php if (empty($addresses)): ?>
                    <p class="no-address">No Addresses Found</p>

                    <button class="address-btn" onclick="openAddressModal()">
                        Add Address
                    </button>

                <?php else: ?>
                    <?php foreach ($addresses as $a): ?>
                        <div class="address-card <?= $a['is_default'] ? 'default' : '' ?>">

                            <div class="address-header">
                                <i class="fa-solid fa-location-dot"></i>
                                <h3><?= $a['is_default'] ? 'Default Address' : 'Address' ?></h3>
                            </div>

                            <div class="address-body">
                                <?= $a['full_name'] ?><br>
                                <?= $a['city'] ?> - <?= $a['area'] ?><br>
                                <?= $a['street'] ?><br>
                                <?= $a['phone'] ?>
                            </div>

                            <button class="address-btn" onclick="setDefault(<?= $a['id'] ?>)">Make Default</button>

                            <button class="address-btn" style="background:#444"
                                onclick="deleteAddress(<?= $a['id'] ?>)">Delete</button>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>

        </div>




        <div id="accountDetailsSection" style="display:none" class="account-content">
            <h2>Account Details</h2>
            <div class="account-info-box">
                <p><strong>Name:</strong> <span id="userName"><?php echo $user['name']; ?></span>
                <p><strong>Email:</strong> <span id="userEmail"><?php echo $user['email']; ?></span>
                <p><strong>Phone:</strong> <span id="userPhone"><?php echo $user['phone_number']; ?></span>
            </div>
            <button id="editBtn" class="account-btn">Edit Details</button>
            <button id="deleteBtn" class="delete-btn">Delete Account</button>
        </div>

        <div class="modal" id="editModal">
            <div class="modal-box">
                <h3>Edit Account</h3>
                <input type="text" id="editName" placeholder="Name">
                <input type="email" id="editEmail" placeholder="Email">
                <input type="text" id="editPhone" placeholder="Phone">
                <button onclick="updateUser()">Save</button>
                <button onclick="closeModal()">Cancel</button>
            </div>
        </div>

        <div class="modal" id="orderModal">
            <div class="modal-box">

                <h3>Order Details</h3>

                <p><strong>Order ID:</strong> <span id="mOrderId"></span></p>
                <p><strong>Date:</strong> <span id="mOrderDate"></span></p>
                <p><strong>Status:</strong> <span id="mOrderStatus"></span></p>
                <p><strong>Total:</strong> <span id="mOrderTotal"></span></p>

                <button onclick="closeOrderModal()">Close</button>
            </div>
        </div>

        <div class="modal" id="addressModal">
            <div class="modal-box">
                <h3 id="addressTitle">Edit Address</h3>

                <input type="text" id="fullName" placeholder="Full Name">
                <input type="text" id="city" placeholder="City">
                <input type="text" id="country" placeholder="Country">
                <input type="text" id="phone" placeholder="Phone">

                <button onclick="saveAddress()">Save</button>
                <button onclick="closeAddressModal()">Cancel</button>
            </div>
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
                <button class="cart-btn primary" onclick="window.location.href='checkout.html'">Complete the order</button>
                <button class="cart-btn secondary" onclick="window.location.href='cart.html'">Basket display</button>
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

        let cart = [];


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
        let menuItems = document.querySelectorAll(".account-sidebar li");

        menuItems.forEach(item => {
            item.addEventListener("click", function() {

                if (this.classList.contains('logout')) {
                    if (confirm('Are you sure you want to logout?')) {
                        alert('Logged out successfully!');
                        window.location.href = "../php/logout.php";

                    }
                    return;
                }


                menuItems.forEach(li => li.classList.remove("active"));
                this.classList.add("active");


                document.getElementById("dashboardSection").style.display = "none";
                document.getElementById("ordersSection").style.display = "none";
                document.getElementById("addressSection").style.display = "none";
                document.getElementById("accountDetailsSection").style.display = "none";

                if (this.innerText.includes("Dashboard")) {
                    document.getElementById("dashboardSection").style.display = "block";
                } else if (this.innerText.includes("Orders")) {
                    document.getElementById("ordersSection").style.display = "block";
                } else if (this.innerText.includes("Addresses")) {
                    document.getElementById("addressSection").style.display = "block";
                } else if (this.innerText.includes("Account")) {
                    document.getElementById("accountDetailsSection").style.display = "block";
                }
            });
        });


        function showSection(section) {

            document.getElementById("dashboardSection").style.display = "none";
            document.getElementById("ordersSection").style.display = "none";
            document.getElementById("addressSection").style.display = "none";
            document.getElementById("accountDetailsSection").style.display = "none";


            menuItems.forEach(li => li.classList.remove("active"));


            switch (section) {
                case 'orders':
                    document.getElementById("ordersSection").style.display = "block";
                    menuItems[1].classList.add("active");
                    break;
                case 'addresses':
                    document.getElementById("addressSection").style.display = "block";
                    menuItems[2].classList.add("active");
                    break;
                case 'account':
                    document.getElementById("accountDetailsSection").style.display = "block";
                    menuItems[3].classList.add("active");
                    break;
                default:
                    document.getElementById("dashboardSection").style.display = "block";
                    menuItems[0].classList.add("active");
            }
        }

        let modal = document.getElementById("editModal");

        document.getElementById("editBtn").onclick = function() {
            modal.style.display = "flex";


            document.getElementById("editName").value =
                document.getElementById("userName").innerText;

            document.getElementById("editEmail").value =
                document.getElementById("userEmail").innerText;

            document.getElementById("editPhone").value =
                document.getElementById("userPhone").innerText;
        }

        function closeModal() {
            modal.style.display = "none";
        }


        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        function updateUser() {
            let name = editName.value;
            let email = editEmail.value;
            let phone = editPhone.value;

            fetch("../php/update_user.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `name=${name}&email=${email}&phone=${phone}`
                })
                .then(res => res.text())
                .then(data => {
                    if (data === "success") {
                        userName.innerText = name;
                        userEmail.innerText = email;
                        userPhone.innerText = phone;
                        closeModal();
                        alert("Updated Successfully!");
                    }
                })
        }


        document.getElementById("deleteBtn").onclick = function() {
            if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                alert("Account deletion request sent. This is a demo message.");

            }
        }


        function filterOrders(status) {
            let buttons = document.querySelectorAll(".filter-btn");
            let cards = document.querySelectorAll(".order-card");

            buttons.forEach(btn => btn.classList.remove("active"));
            event.target.classList.add("active");

            cards.forEach(card => {
                if (status === "all" || card.dataset.status === status) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }


        // ================== Order Details Popup ==================

        function openOrderDetails(id, date, status, total) {

            document.getElementById("mOrderId").innerText = id;
            document.getElementById("mOrderDate").innerText = date;
            document.getElementById("mOrderStatus").innerText = status;
            document.getElementById("mOrderTotal").innerText = total;

            document.getElementById("orderModal").style.display = "flex";
        }

        function closeOrderModal() {
            document.getElementById("orderModal").style.display = "none";
        }

        // Click outside to close
        let orderModal = document.getElementById("orderModal");
        orderModal.addEventListener("click", function(e) {
            if (e.target === orderModal) {
                closeOrderModal();
            }
        });

        let currentType = "";

        function openAddressModal(type) {
            currentType = type;

            document.getElementById("addressModal").style.display = "flex";

            if (type === "billing") {
                document.getElementById("addressTitle").innerText = "Edit Billing Address";
            } else {
                document.getElementById("addressTitle").innerText = "Add / Edit Shipping Address";
            }

            document.getElementById("fullName").value = "";
            document.getElementById("country").value = "";
            document.getElementById("city").value = "";
            document.getElementById("phone").value = "";
        }

        function closeAddressModal() {
            document.getElementById("addressModal").style.display = "none";
        }

        function saveAddress() {

            let formData = new FormData();
            formData.append("full_name", document.getElementById("fullName").value);
            formData.append("city", document.getElementById("city").value);
            formData.append("country", document.getElementById("country").value);
            formData.append("phone", document.getElementById("phone").value);
            formData.append("area", "");
            formData.append("street", "");
            formData.append("postal_code", "");

            fetch("../php/add_address.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(data => {

                    if (data.trim() === "success") {

                        closeAddressModal();

                        const grid = document.querySelector(".address-grid");

                        let newCard = document.createElement("div");
                        newCard.className = "address-card";

                        newCard.innerHTML = `
        <div class="address-header">
            <i class="fa-solid fa-location-dot"></i>
            <h3>Address</h3>
        </div>

        <div class="address-body">
            ${document.getElementById("fullName").value}<br>
            ${document.getElementById("city").value} - ${document.getElementById("country").value}<br>
            ${document.getElementById("phone").value}
        </div>

        <button class="address-btn">Make Default</button>
        <button class="address-btn" style="background:#444">Delete</button>
    `;

                        grid.appendChild(newCard);

                        alert("Address Saved Successfully !");
                    }

                });
        }

        // إغلاق بالضغط خارج البوب اب
        let addressModal = document.getElementById("addressModal");
        addressModal.addEventListener("click", function(e) {
            if (e.target === addressModal) {
                closeAddressModal();
            }
        });

        function setDefault(id) {
            fetch("../php/set_default.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id=" + id
                })
                .then(r => r.text())
                .then(d => {
                    if (d === "success") {
                        alert("Default Address Updated");
                        location.reload();
                    }
                });
        }

        function deleteAddress(id) {
            if (!confirm("Delete this address?")) return;

            fetch("../php/delete_address.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id=" + id
                })
                .then(r => r.text())
                .then(d => {
                    if (d === "success") {
                        alert("Address Deleted");
                        location.reload();
                    }
                });
        }
    </script>

</body>

</html>