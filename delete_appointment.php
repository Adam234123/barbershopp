<?php
require 'config.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'titkoskulcs123';

// Csak bejelentkezett admin férhet hozzá
if (!isset($_COOKIE['token'])) {
    header("Location: login.php");
    exit();
}

try {
    $decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));

    if ($decoded->role !== 'admin') {
        header("Location: login.php");
        exit();
    }

} catch (Exception $e) {
    header("Location: login.php");
    exit();
}

// Törlés csak POST módszerrel és ha ID meg van adva
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Visszairányítás
header("Location: admin.php");
exit();
?>
