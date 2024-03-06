<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  // vypísanie chyb
session_start();

require './db/Db.php';

Db::connect('127.0.0.1', 'michudaa', 'root', '');

if (isset($_SESSION['id'])) {
    header('Location: /githubWeb/home.php');
    exit();
}

//signup
if (isset($_POST['sendUSER'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $heslo = password_hash($password, PASSWORD_DEFAULT);

    if (!empty($username) || !empty($email) || !empty($password)) {
        Db::query("INSERT INTO `users` (username, email, password) VALUES ('$username', '$email', '$heslo')");
    } else {
        echo "All fields must be field out";
        die();
    }
}

//login
$chyba = '';
if (isset($_POST['submit'])) 
{
    if ($_POST['usernameLogin'] && $_POST['passwordLogin']) {
        $username = trim($_POST['usernameLogin']);
        $password = $_POST['passwordLogin'];

        $user = Db::queryOne('SELECT password, username, id FROM users WHERE `username`=?', $username);

        if (!$user || !password_verify($password, $user['password'])) {
            $chyba = 'Your username or password is incorrect';
        } else {
            $_SESSION['id'] = $user['id'];
            header('Location: /githubWeb/home.php');
            exit();
        }
    } else {
        $chyba = 'All fields must be filled out';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "./includes/head.php" ?>
</head>

<body>
    <div class="header">
        <div class="container">
            <?php require_once "./includes/header.php" ?>
        </div>
    </div>
<!--account page-->
<div class="account-page">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <img src="./img/mici.JPG" alt="">
            </div>
            <div class="col-2">
            
                <div class="form-container">
                        <div class="form-btn">
                            <span onclick="login()">Login</span>
                            <span onclick="register()">Register</span>
                            <hr id="Indicator">
                        </div>

                        <form id="LoginForm" action="" method="POST">
                            <input type="text" name="usernameLogin" placeholder="Username">
                            <input type="password" name="passwordLogin" placeholder="Password">

                            <button type="submit" name="submit" class="btn">Login</button>
                            <a href="">Forgot Password</a>
                            <span class="vypis"><?php echo ($chyba); ?></span>
                        </form>

                        <form id="RegForm" action="" method="POST">
                            <input type="text" name="username" id="username" placeholder="Username">
                            <input type="email" name="email" id="email" placeholder="E-mail">
                            <input type="password" name="password" id="password" placeholder="Password">
                            <button  type="submit" name="sendUSER" class="btn">Register</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "./includes/footer.php" ?>

</body>
<!-- Toggle menu -->
<script src="js/toggleMenu.js"></script>
<!-- Swiper -->
<script src=" https://cdn.jsdelivr.net/npm/swiper@9.0.1/swiper-bundle.min.js "></script>
<script src="js/slider.js"></script>
<!--Login form-->
<script src="js/loginForm.js"></script>
</html>