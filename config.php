<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barbershop";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); // FONTOS: magyar ékezetek miatt

if ($conn->connect_error) {
    die("Kapcsolati hiba: " . $conn->connect_error);
}
?>
