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
    die("Please fill in all required fields");
}

if ($password !== $confirm_password) {
    die("Passwords do not match");
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

if ($user->create()) {
    header("Location: login.html");
    exit;
} else {
    echo "An error occurred while creating the account ";
}
?>
