<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // vypísanie chyb

require './db/Db.php';

Db::connect('127.0.0.1', 'michudaa', 'root', '');

$products = Db::queryAll("SELECT id, name, image, cost from products");

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
    
    <div class="about-section">
        <div class="inner-container">
            <h1>O nás</h1>
            <p class="text">
                Michudaa brand je novozaložená značka oblečenia ktorá chce pomôcť ľudom vyjadriť sa pomocou ich oblečenia.
                U nás si uvedomujeme, že v dnešnej dobe môže byť náročné sa vyjadriť a nadviazať kontakt. Vďaka našemu 
                oblečeniu nebudete potrebovať slová na to aby ste sa vyjadrili. 
            </p>
            <div class="skills">
                <span>Kvalita</span>
                <span>Komfort</span>
                <span>Spokojnosť</span>
            </div>
        </div>
    </div>
    <?php require_once "./includes/footer.php" ?>
    <script>
        var MenuItems = document.getElementById("MenuItems");

        MenuItems.style.maxHeight = "0px";

        function menutoggle()
        {
            if(MenuItems.style.maxHeight == "0px")
            {
                MenuItems.style.maxHeight = "200px"
            }

            else
            {
                MenuItems.style.maxHeight = "0px"
            }
        }
    </script>



</body>