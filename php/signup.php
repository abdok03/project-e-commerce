<?php
session_start();
require_once "../config/database.php";
require_once "../classes/user.php";

$db = (new Database())->connecte();
$user = new Users($db);

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone_number'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (empty($name) || empty($phone) || empty($password) || empty($confirm_password)) {
    die("Please fill in all required fields");
}

if ($password !== $confirm_password) {
    die("Passwords do not match");
}

$phone = preg_replace('/[^0-9]/', '', $phone);

if (str_starts_with($phone, '962')) { // 962791234567
    $phone = '0' . substr($phone, 3);
} elseif (strlen($phone) === 9 && $phone[0] === '7') { // 791234567
    $phone = '0' . $phone;
} elseif (strlen($phone) === 10 && $phone[0] === '0') { // 0791234567
    $phone = $phone;
} else {
    die("Invalid phone number format");
}

if (!preg_match('/^07[789][0-9]{7}$/', $phone)) {
    die("Invalid phone number format");
}

$query = "SELECT id FROM users WHERE phone_number = :phone LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(":phone", $phone);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    die("Phone number is already registered");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$user->name = $name;
$user->phone_number = $phone;
$user->password = $hashed_password;
$user->email = $email ?: null;

if ($user->create()) {
    header("Location: ../html/login.html");
    exit;
} else {
    echo "An error occurred while creating the account";
}
?>
