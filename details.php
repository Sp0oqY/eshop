<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  // vypísanie chyb
session_start();
require './db/Db.php';

Db::connect('127.0.0.1', 'michudaa', 'root', '');

if (isset($_GET['product'])) {
    $productid = $_GET['product'];
    $product = Db::queryOne("SELECT id, name, image, cost, description from products WHERE id = ${productid};");
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
    <!--Single products details-->

    <div class="small-container single-product">
        <div class="row">
            <div class="col-2">
                <!-- <img id="ProductImg" src="./img/mikina7.jpg" width="100%">

                <div class="small-img-row">
                    <div class="small-img-col">
                        <img class="small-img" src="./img/mikina6.png" width="100%">
                    </div>
                    <div class="small-img-col">
                        <img class="small-img" src="./img/mikina4.jpg" width="100%">
                    </div>
                    <div class="small-img-col">
                        <img class="small-img" src="./img/mikina2.jpeg" width="100%">
                    </div>
                    <div class="small-img-col">
                        <img class="small-img" src="./img/mikina7.jpg" width="100%">
                    </div>
                </div> -->

                <img id="ProductImg" src="<?= $product['image'] ?>">

            </div>

            <div class="col-2">
                <form method="post" action="cart.php?action=add&id=<?php echo $product["id"]; ?>">

                    <h2><?= $product['name'] ?></h2>
                    <h4>Cena: <?= $product['cost'] ?>€</h4>
                   
                    <select>
                        <option>Select Size</option>
                        <option>XXL</option>
                        <option>XL</option>
                        <option>L</option>
                        <option>M</option>
                        <option>S</option>
                    </select>
                    
                    
                    <input class="btn" type=submit name=add value="Add to cart">
                    <h3>Product details <i class="fa fa-indent"></i></h3>
                    <br>
                    <p><?= $product['description'] ?></p>

                    <input type="hidden" name="hidden_name" value=" <?= $product['name'] ?>" />
                    <input type="hidden" name="hidden_price" value=" <?= $product['cost'] ?>" />
                    <input type="hidden" name="hidden_img" value="<?= $product['image'] ?>" />
                </form>
                

            </div>
        </div>
    </div>

    <!--title-->
    <div class="small-container">
        <div class="row row-2">
            <h2>Related Products</h2>
            <p>View More</p>
        </div>
    </div>

    <!--odporúčané produkty-->
    <div class="small-container">

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

    <?php require_once "./includes/footer.php" ?>

</body>
<!-- Toggle menu -->
<script src="js/toggleMenu.js"></script>
<!-- Swiper -->
<script src=" https://cdn.jsdelivr.net/npm/swiper@9.0.1/swiper-bundle.min.js "></script>
<script src="js/slider.js"></script>
<!--Product gallery-->
<script src="js/productGallery.js"></script>
<script src="js/cart.js"></script>

</html>