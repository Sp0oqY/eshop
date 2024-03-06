<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // vypísanie chyb

require './db/Db.php';

Db::connect('127.0.0.1', 'michudaa', 'root', '');
if (isset($_POST['sendRATING'])) {

    $nick = $_POST['nick'];
    $text = $_POST['text'];

    if (!empty($nick) || !empty($text)) {
        Db::query("INSERT INTO `rating` (nick, text) VALUES ('$nick', '$text')");
    } else {
        echo "All fields must be field out";
        die();
    }
}

$products = Db::queryAll("SELECT id, name, image, cost, description from products where id =1 or id =2 or id =3");
$ratings = Db::queryAll("SELECT id, nick, text from rating");




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
            <div class="row">
                <div class="col-2">
                    <h1>Dajte svojmu oblečeniu emóciu</h1>
                    <p>Oblečenie môže byť pre veľa z nás prostriedkom vyjadrenia svojich <br> myšlienok , ak to cítiš
                        tak aj ty my ti pomôžeme sa vyjadriť</p>
                    <a href="products.php" class="btn">Preskúmaj teraz &#10144;</a>
                </div>
                <div class="col-2">
                    <img src="img/overall.jpeg" alt="">
                </div>
            </div>
        </div>
    </div>

    <!--odporúčané produkty-->
    <div class="small-container">
        <h2 class="title">Odporúčané Produkty</h2>
        <section class="row">
            <div class="products">
                <?php foreach ($products as $product) : ?>
                    <div class="product" data-product="<?= $product['id'] ?>" method="POST">
                        <img class="product-img" src="<?= $product['image'] ?>">
                        <p class="product-title"><?= $product['name'] ?></p>
                    </div>
                <?php endforeach ?>
            </div>
        </section>
        <h2 class="title">Novinky</h2>
        <div class="row">
            <div class="col-4">
                <img src="img/tricko1.jpeg" alt="">
                <h4>Levis Tričko</h4>
                <div class="rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <p>50€</p>
            </div>
            <div class="col-4">
                <img src="img/tricko1.jpeg" alt="">
                <h4>Levis Tričko</h4>
                <div class="rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <p>50€</p>
            </div>
            <div class="col-4">
                <img src="img/tricko1.jpeg" alt="">
                <h4>Levis Tričko</h4>
                <div class="rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <p>50€</p>
            </div>
        </div>
    </div>

    <!--Ponuka-->
    <div class="offer">
        <div class="small-container">
            <div class="row">
                <div class="col-2">
                    <img src="./img/mikina6.png" class="offer-img">
                </div>
                <div class="col-2">
                    <p>Mikina, ktorá je fakt naložená</p>
                    <h1>Nike mikina</h1>
                    <p>Limitovaná edícia mikiny Nike <b>x</b> Michudaa</p>
                    <a class="btn" href="products.php">Kúp Teraz &#8594;</a>
                </div>
            </div>
        </div>
    </div>

    <!--recenzie-->
    <h2 class="title">Recenzie</h2>
    <div class="slide-container swiper">
        <div class="slide-content">
            <div class="card-wrapper swiper-wrapper">
                <?php foreach ($ratings as $rating) : ?>
                    <div class="card swiper-slide">
                        <div class="image-content">
                            <span class="overlay"></span>

                            <div class="card-image">
                                <img src="./img/mici.JPG" class="card-img">
                            </div>
                        </div>

                        <div class="card-content">
                            <h2 class="nick-rating"><?= $rating['nick'] ?></h2>
                            <p class="description"><?= $rating['text'] ?></p>


                        </div>
                    </div>

                <?php endforeach ?>
                <?php if (isset($_SESSION['id'])) : ?>
                <div class="card swiper-slide">
                    <div class="image-content">
                        <span class="overlay"></span>

                        <div class="card-image">
                            <img src="./img/mici.JPG" class="card-img">
                        </div>
                    </div>
                    
                    <div class="card-content">
                        <form action="" method="POST" >
                            <label for="subject">Meno</label>
                            <h2 class="nick-rating"> <input name="nick" id="nictext" type="text"></h2>
                            <label for="subject">Recenzia</label>
                            <p class="description"><input name="text" id="rectext" type="text"></p>
                            <button class="btnrec" type="submit" name="sendRATING">Submit</button>
                        </form>

                    </div>
                    
                </div>
                <?php endif; ?>


            </div>

        </div>
        <div class="swiper-button-next swiper-navBtn"></div>
        <div class="swiper-button-prev swiper-navBtn"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!--brands-->




    <?php require_once "./includes/footer.php" ?>
</body>
<!-- Toggle menu -->
<script src="js/toggleMenu.js"></script>
<!-- Swiper -->
<script src=" https://cdn.jsdelivr.net/npm/swiper@9.0.1/swiper-bundle.min.js "></script>
<script src="js/slider.js"></script>

</html>