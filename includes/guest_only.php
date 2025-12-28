<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// إذا المستخدم مسجل دخول
if (isset($_SESSION['user_id'])) {

    $role = strtolower(trim($_SESSION['role'] ?? 'user'));

    // توجيه حسب الدور
    if ($role === 'admin') {
        header("Location: ../admin/html/dashbord.php");
        exit;
    }

    // user عادي
    header("Location: ../html/index.php");
    exit;
}