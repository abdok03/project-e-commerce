<?php
session_start();
require_once "../includes/guest_only.php";
require_once "../config/database.php";
require_once "../classes/user.php";
$db = (new Database())->connecte();
$user = new Users($db);

$phone = trim($_POST['phone_number'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($phone) || empty($password)) {
    die("<p style='color:red;'>الرجاء تعبئة جميع الحقول</p>");
}

$phone_clean = preg_replace('/[^0-9]/', '', $phone);

if (strlen($phone_clean) === 9 && $phone_clean[0] === '7') {
    $phone_final = '0' . $phone_clean;
} elseif (strlen($phone_clean) === 10 && $phone_clean[0] === '0') {
    $phone_final = '+962' . substr($phone_clean, 1);
} elseif (strlen($phone_clean) === 12 && substr($phone_clean, 0, 3) === '962') {
    $phone_final = '+' . $phone_clean;
} elseif (strlen($phone_clean) === 13 && substr($phone_clean, 0, 4) === '9627') {
    $phone_final = '+' . substr($phone_clean, 0);
} else {
    die("<p style='color:red;'>رقم الهاتف غير صالح</p>");
}

$stmt = $db->prepare("SELECT * FROM users WHERE phone_number = :phone LIMIT 1");
$stmt->bindParam(":phone", $phone_final);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    die("<p style='color:red;'>رقم الهاتف غير مسجل</p>");
}

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!password_verify($password, $data['password'])) {
    die("<p style='color:red;'>كلمة المرور خاطئة</p>");
}

session_regenerate_id(true);
$_SESSION['user_id'] = $data['id'];
$_SESSION['user_name'] = $data['name'];
$_SESSION['role'] = $data['role'] ?? 'user';

if ($_SESSION['role'] === 'admin') {
    header('Location: ../admin/html/dashbord.php');
} else {
    header('Location: ../html/index.php');
}
exit;
