<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  // vypísanie chyb
session_start();
require './db/Db.php';

Db::connect('127.0.0.1', 'michudaa', 'root', '');

$products = Db::queryAll("SELECT id, name, image, cost from products");

if (isset($_POST["add"])) {
    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if (!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id'               =>     $_GET["id"],
                'item_name'             =>     $_POST["hidden_name"],
                'item_price'            =>     $_POST["hidden_price"],
                'item_img'              =>     $_POST["hidden_img"],
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        } else {
            echo '<script>alert("Item Already Added")</script>';
        }
    } else {
        $item_array = array(
            'item_id'               =>     $_GET["id"],
            'item_name'             =>     $_POST["hidden_name"],

            'item_price'            =>     $_POST["hidden_price"],
            'item_img'              =>     $_POST["hidden_img"],
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                // echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="Cart.php"</script>';
            }
        }
    }
}

if (isset($_POST['order'])) {
    $meno = $_POST['meno'];
    $priezvisko = $_POST['priezvisko'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $adresa = $_POST['adresa'];
    $mesto = $_POST['mesto'];
    $psc = $_POST['psc'];


    if (!empty($adresa) || !empty($mesto) || !empty($meno) || !empty($telefon)) {
        $lastID = Db::insert_lastID("INSERT INTO `uzivatel` (meno, priezvisko, telefon, email, adresa, mesto, psc) VALUES ('$meno', '$priezvisko', '$telefon', '$email', '$adresa', '$mesto', '$psc')");
    } else {
        echo "All fields must be field out";
        die();
    }

    if (!empty($_POST['items'])) {
        foreach ($_POST['items'] as $item_id => $item) {
            $count = $item['count'];
            Db::query("INSERT INTO `orders` (uzivatel_id, product_id, pocet, cena) VALUES ('$lastID', '$item_id', '$count', 5)");
        }
    }

    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
        unset($_SESSION["shopping_cart"][$keys]);
        // echo '<script>alert("Item Removed")</script>';
        echo '<script>window.location="Cart.php"</script>';
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

    <!--cart items details-->
    <div class="small-container cart-page">
        <table>
            <tr>
                <th>Obrázok</th>
                <th>Názov</th>
                <th>Cena</th>
                <th>Počet</th>
                <th>Spolu</th>
            </tr>
            <tr>
                <td>
                    <div class="cart-info">
                        <img src="./img/logo.png">
                        <div>
                            <p>Red Printed T-shirt</p>
                            <small>Price: 50€</small>
                            <br>
                            <a href="">Remove</a>
                        </div>
                    </div>
                </td>
                <td><input type="number" value="1"></td>
                <td>50 €</td>
            </tr>
            <!-- <tr>
                <td>
                    <div class="cart-info">
                        <img src="./img/logo.png">
                        <div>
                            <p>Red Printed T-shirt</p>
                            <small>Price: 50€</small>
                            <br>
                            <a href="">Remove</a>
                        </div>
                    </div>
                </td>
                <td><input type="number" value="1"></td>
                <td>50 €</td>
            </tr>
            <tr>
                <td>
                    <div class="cart-info">
                        <img src="./img/logo.png">
                        <div>
                            <p>Red Printed T-shirt</p>
                            <small>Price: 50€</small>
                            <br>
                            <a href="">Remove</a>
                        </div>
                    </div>
                </td>
                <td><input type="number" value="1"></td>
                <td>50 €</td>
            </tr> -->
        </table>

        <!-- <div class="total-price">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>200 €</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td>35 €</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>230 €</td>
                </tr>
            </table>
        </div> -->

        <form action="cart.php?action=order" method="POST">
            <table class="table table-bordered tabulka">
                <tr class="">
                    <th>Obrázok</th>
                    <th>Názov</th>

                    <th>Cena</th>
                    <th>Počet</th>
                    <th>Akcia</th>
                </tr>
                <?php
                if (!empty($_SESSION["shopping_cart"])) {
                    $total = 0;
                    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                ?>
                        <tr class="cartRowsHolder">
                            <td class="cartRow"> <img src="<?php echo $values["item_img"]; ?>" alt=""> </td>
                            <td class="cartRow"><?php echo $values["item_name"]; ?></td>
                            <td class="cartRow"><?php $size ?></td>
                            <td class="price"><?php echo $values["item_price"]; ?></td>
                            <td class="cartRow"><input type="number" class="inputNumber" name="items[<?= $values["item_id"] ?>][count]" default="1" value="1"></td>
                            <td class="cartRow"></td>
                            <td class="cartRow"><a class="delButton" href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span>Zmazať</span></a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="3">Spolu</td>
                        <!-- <td>$<?php echo number_format($total, 2); ?></td> -->
                        <td class=""></td>
                        <td></td>
                    </tr>
                <?php
                }
                ?>
            </table>

            <article class="cartArticle2">
                <h1>Dodanie</h1>

                <div class="inputHolder">
                    <input type="text" name="meno" require placeholder="Meno" class="inputBox">
                    <input type="text" name="priezvisko" require placeholder="Priezvisko" class="inputBox">
                    <input type="text" name="telefon" require placeholder="Telefónne číslo" class="inputBox">
                    <input type="text" name="email" require placeholder="E-mail" class="inputBox">
                    <input type="text" name="adresa" require placeholder="Adresa" class="inputBox">
                    <input type="text" name="mesto" require placeholder="Mesto" class="inputBox">
                    <input type="text" name="psc" require placeholder="PSČ" class="inputBox">
                </div>
                <!-- <div class="termsCoditionsHoler">
                    <p class="termsCoditions">Súhlasím so <a href="terms&conditions.html">zmluvnými</a> podmienkami</p>
                    <input type="checkbox" require>
                </div> -->
                <button type="submit" name="order" class="Order">Objednať</button>

            </article>
        </form>

    </div>

    <?php require_once "./includes/footer.php" ?>
</body>
<!-- Toggle menu -->
<script src="js/toggleMenu.js"></script>
<!-- Swiper -->
<script src=" https://cdn.jsdelivr.net/npm/swiper@9.0.1/swiper-bundle.min.js "></script>
<script src="js/slider.js"></script>
<script src="js/cart.js"></script>

</html>