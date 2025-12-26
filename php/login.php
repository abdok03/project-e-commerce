<?php
session_start();
require_once "../config/database.php";
require_once "../classes/user.php";

$db = (new Database())->connecte();
$user = new users($db);

$phone = trim($_POST['phone_number'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($phone) || empty($password)) {
    die("الرجاء تعبئة جميع الحقول");
}

if (!preg_match('/^07[789][0-9]{7}$/', $phone)) {
    die("رقم الهاتف غير صالح");
}


$query = "SELECT * FROM users WHERE phone_number = :phone LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(":phone", $phone);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    die("رقم الهاتف غير مسجل");
}

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!password_verify($password, $data['password'])) {
    die("كلمة المرور غير صحيحة");
}

$_SESSION['user_id'] = $data['id'];
$_SESSION['user_name'] = $data['name'];
$_SESSION['role'] = $data['role'];

header("Location: index.html");
exit;
