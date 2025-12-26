<?php
session_start();
require_once "../config/database.php";
require_once "../classes/user.php";

$db = (new Database())->connecte();
$user = new users($db);

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone_number'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$terms = $_POST['terms'] ?? '';

if (empty($name) || empty($phone) || empty($password) || empty($confirm_password)) {
    die("الرجاء تعبئة جميع الحقول");
}

if ($password !== $confirm_password) {
    die("كلمتا المرور غير متطابقتين");
}

if (!preg_match('/^07[789][0-9]{7}$/', $phone)) {
    die("رقم الهاتف غير صالح");
}

$query = "SELECT id FROM users WHERE phone_number = :phone LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(":phone", $phone);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    die("رقم الهاتف مستخدم مسبقًا");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$user->name = $name;
$user->phone_number = $phone;
$user->password = $hashed_password;

if ($user->create()) {
    header("Location: login.html");
     exit;
} else {
    echo "حدث خطأ أثناء إنشاء الحساب ❌";
}
