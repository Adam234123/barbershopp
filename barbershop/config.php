<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barbershop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolati hiba: " . $conn->connect_error);
}
?>
