
<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Ellenőrizzük, hogy az időpont már foglalt-e
    $check_sql = "SELECT * FROM appointments WHERE appointment_date = ? AND appointment_time = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Ez az időpont már foglalt!"]);
    } else {
        $insert_sql = "INSERT INTO appointments (customer_name, appointment_date, appointment_time) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sss", $name, $date, $time);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Foglalás sikeres!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Hiba történt a foglalás során!"]);
        }
    }

    $stmt->close();
    $conn->close();
}
?>
