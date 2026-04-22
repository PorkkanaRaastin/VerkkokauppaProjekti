<?php
    include_once("link.php");
    session_start();
    if(!isset($_SESSION["userId"])){
        header("Location: login.php");
    };
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Ostoskori</title>
    <link rel="stylesheet" href="styles/cart.css">
</head>
<body>

<header>
    <div class="logo">LOGO</div>
    <nav>
        <a href="#">Etusivu</a>
        <div class="cart">🛒 2</div>
    </nav>
</header>

<main>
    <h1>Ostoskori</h1>

    <div class="container">
        <section class="cart-items">
        <?php
            $userId=$_SESSION["userId"];
            $query="SELECT Cart.cartId FROM Cart WHERE Cart.userId LIKE '$userId'";
            $cartId=$link->query($query)->fetch_assoc()["cartId"];
            $orderId="SELECT Cart.orderId FROM Cart WHERE Cart.cartId LIKE '$cartId'";
            $orderId=$link->query($query)->fetch_assoc()["orderId"];
            $query="SELECT CartItem.productId, CartItem.amount FROM CartItem WHERE CartItem.cartId LIKE '$cartId'";
            $result=$link->query($query);
            $totalPrize=0;
            while($data=$result->fetch_assoc()){
                $productId=$data["productId"];
                $itemAmount=$data["amount"];
                $query="SELECT Products.name, Products.prize, Products.categoryId FROM Products WHERE Products.productId LIKE '$productId'";
                $tempResult=$link->query($query)->fetch_assoc();
                $prize=$tempResult["prize"];
                $name=$tempResult["name"];
                $categoryId=$temp["categoryId"];
                $query="SELECT Categories.name FROM Categories WHERE Categories.categoryId LIKE '$categoryId'";
                $categoryName=$link->query($query)->fetch_assoc()["name"];
                echo"<div class='item'>
                <h3>$name</h3>
                <p>$categoryName</p>
                <div class='row'>
                <input type='number' value='$itemAmount' min='1'>
                <span>$prize<span>
                </div></div>";
                $totalPrize+=$prize;
            };
        ?>

        <div class="total"><?phpecho$totalPrize;?></div>
        </section>

        <section class="order-form">
            <h2>Tilaustiedot</h2>
            <input type="text" placeholder="Nimi">
            <input type="email" placeholder="Sähköpostiosoite">
            <input type="tel" placeholder="Puhelinnumero">
            <button>Tee tilaus</button>
        </section>
    </div>
</main>

<footer>
    Jesse Kujala & Rasmus Rautanen
</footer>

</body>
</html>