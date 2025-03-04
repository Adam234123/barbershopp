
<?php
require 'config.php';

$sql = "SELECT appointment_date, appointment_time FROM appointments";
$result = $conn->query($sql);

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

echo json_encode($appointments);

$conn->close();
?>
