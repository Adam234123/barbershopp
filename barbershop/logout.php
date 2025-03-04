<?php
session_start();
session_destroy();
header("Location: http://localhost/barbershop/login.php");
exit();
?>
