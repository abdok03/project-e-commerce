<?php
session_start();
require_once "../config/database.php";
require_once "../classes/user.php";

$db = (new Database())->connecte();
$user = new users($db);

$phone = trim($_POST['phone_number'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($phone) || empty($password)) {
    die("Please fill in all fields");
}

if (!preg_match('/^07[789][0-9]{7}$/', $phone)) {
    die("Invalid phone number format");
}

$query = "SELECT * FROM users WHERE phone_number = :phone LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(":phone", $phone);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    die("Phone number is not registered");
}

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!password_verify($password, $data['password'])) {
    die("Incorrect password");
}

$_SESSION['user_id'] = $data['id'];
$_SESSION['user_name'] = $data['name'];
$_SESSION['role'] = $data['role'];

header("Location: index.html");
exit;
