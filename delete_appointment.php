<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Hiba történt a törlés során.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Érvénytelen kérés.";
}
?>
