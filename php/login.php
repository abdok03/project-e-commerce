<?php
session_start();
// require_once "../includes/guest_only.php";
require_once "../config/database.php";
require_once "../classes/user.php";


$db = (new Database())->connecte();
$user = new Users($db);

$phone = trim($_POST['phone_number'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($phone) || empty($password)) {
    die("Please fill in all fields");
}

if (!preg_match('/^(?:\+962|0)?7[789][0-9]{7}$/', $phone)) {
    die("Invalid phone number format");
}

if (strlen($phone) === 9 && $phone[0] === '7') {
    $phone = '0' . $phone;
}

if (str_starts_with($phone, '+962')) {
    $phone = '0' . substr($phone, 4);
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
session_regenerate_id(true);
$_SESSION['user_id'] = $data['id'];
$_SESSION['user_name'] = $data['name'];
$_SESSION['role'] = $data['role'];


if ($_SESSION['role'] == 'admin') {

    header('Location: ../admin/html/dashbord.php');
} else {
    header('Location: ../html/index.php');
}
exit;
