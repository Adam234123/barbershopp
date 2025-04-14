<?php
session_start();
session_destroy();

// Token törlése
setcookie('token', '', time() - 3600, "/");

header("Location: login.php");
exit();
?>
