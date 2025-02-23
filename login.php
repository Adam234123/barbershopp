<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['email'] = $email;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Hibás jelszó!";
            }
        } else {
            $error = "Nincs ilyen felhasználó!";
        }
        $stmt->close();
    } else {
        $error = "Minden mezőt ki kell tölteni!";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Bejelentkezés</title>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="css/kepek/logo.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="contact.html">Kapcsolat</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">Rólunk</a></li>
                    <li class="nav-item"><a class="nav-link" href="http://localhost/barbershop/login.php">Bejelentkezés/Regisztráció</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <form class="login-box" method="POST" action="login.php">
            <h2>Jelentkezzen be fiókjába</h2>

            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

            <div class="form-group">
                <label for="email">E-mail-cím</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="E-mail-cím" required>
            </div>
            <div class="form-group">
                <label for="password">Jelszó</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Jelszó" required>
            </div>
            <button type="submit" class="btn btn-success btn-block">Bejelentkezés</button>
            <p class="register-link">Még nincs fiókja? <a href="register.php">Regisztráció</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   
</body> 
</html>
