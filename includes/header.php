<?php
if (session_status() === 1) {
    session_start();
}
?>

<div class="navbar">
    <div class="logo">
        <a href="home.php"><img src="./img/logo.png" height="75.5" width="86.5" alt="" ></a>
    </div>
    <nav>
        <ul id="MenuItems">
            
            <?php if (isset($_SESSION['id']) === 1) : ?>
                <li><a href="admin.php">Admin</a></li>
            <?php endif; ?>
            
            <li><a href="home.php">Domov</a></li>
            <li><a href="products.php">Produkty</a></li>
            <li><a href="about.php">o Nás</a></li>
            <li><a href="contact.php">Kontakt</a></li>

            <?php if (isset($_SESSION['id'])) : ?>
                <li><a href="logout.php">Odhlásiť sa</a></li>
            <?php else : ?>
                <li><a href="account.php">Prihlásenie</a></li>
            <?php endif; ?>

        </ul>
    </nav>
    <a href="cart.php"><img src="./img/cart.png" width="30px" height="30px" alt=""></a>
    <img src="./img/menu.png" class="menu-icon" onclick="menutoggle()">
</div>