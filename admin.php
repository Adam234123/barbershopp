<?php
require 'config.php';

// Foglalások lekérése
$sql = "SELECT * FROM appointments ORDER BY appointment_date, appointment_time";
$result = $conn->query($sql);
?>
<?php
$conn->close();
?>
