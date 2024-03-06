<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  // vypísanie chyb

require './db/Db.php';

Db::connect('127.0.0.1', 'michudaa', 'root', '');

$category = Db::queryAll("SELECT id, category from category");
$color = Db::queryAll("SELECT id, color from colors");

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if (is_int($page) || $page != 1) {
        $offset = ($page - 1) * 12;
        $products = Db::queryAll("SELECT * FROM `products` limit 12 OFFSET ${offset};");
    } else {
        header("Location: /githubWeb/products.php");
    }
} else {
    $products = Db::queryAll("SELECT * FROM `products` limit 12;");
}

$count = Db::query("SELECT * FROM `products`");
if ($count % 12 == 0) {
    $count = $count / 12;
} else {
    $count = ($count / 12) + 1;
}

if (isset($_GET['category']) || isset($_GET['color'])) {
    switch ($_GET) {
        case !empty($_GET['category']):
            $category = $_GET['category'];
            $products = Db::queryAll("SELECT products.id, products.name, image, cost, description, category.category, color from products left join category on category.id = products.category_id left join colors on colors.id = products.color_id WHERE `category_id` = '${category}'");
            break;

        case !empty($_GET['color']):
            $color = $_GET['color'];
            $products = Db::queryAll("SELECT products.id, products.name, image, cost, description, category.category, color from products left join category on category.id = products.category_id left join colors on colors.id = products.color_id WHERE `color_id` = '${color}'");
            break;
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

    <!--odporúčané produkty-->
    <div class="small-container">
        <h2>Produkty</h2>
        <div class="row row-2">
            <select>
                <option>Všetky produkty</option>
                <option>Najvyššia cena</option>
                <option>Najnižšia cena</option>
                <option>Kategória</option>
                <option>Farba</option>
            </select>

            <form action="">
                <select name="category" onchange="this.form.submit()">
                    <option default selected disabled>Category</option>
                    <?php foreach ($category as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['category'] ?></option>
                    <?php endforeach ?>
                </select>
            </form>

            <form action="">
                <select name="color" onchange="this.form.submit()">
                    <option default selected disabled>Colors</option>
                    <?php foreach ($color as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['color'] ?></option>
                    <?php endforeach ?>
                </select>
            </form>

            
        </div>
        <section class="row">
            <div class="products">
                <?php foreach ($products as $product) : ?>
                    <div class="product" data-product="<?= $product['id'] ?>" method="POST">
                        <img class="product-img" src="<?= $product['image'] ?>">
                        <p class="product-title"><?= $product['name'] ?></p>
                        <p class="product-title"><?= $product['cost'] ?> €</p>
                    </div>
                <?php endforeach ?>
            </div>
        </section>



        <section class="page-btn">
            <?php for ($i = 1; $i <= $count; $i++) : ?>
                <a href="/githubWeb/products.php?page=<?= $i ?>"><span><?= $i ?></span></a>
            <?php endfor; ?>
        </section>

    </div>

    <?php require_once "./includes/footer.php" ?>

</body>
<!-- Toggle menu -->
<script src="js/toggleMenu.js"></script>
<!-- Swiper -->
<script src=" https://cdn.jsdelivr.net/npm/swiper@9.0.1/swiper-bundle.min.js "></script>
<script src="js/slider.js"></script>

</html>