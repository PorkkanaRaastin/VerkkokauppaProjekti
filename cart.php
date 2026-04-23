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
            $totalPrize=0.00;
            $userId=$_SESSION["userId"];
            $query="SELECT Orders.orderId FROM Orders WHERE Orders.userId LIKE '$userId' AND Orders.status LIKE 'FILL'";
            $result=$link->query($query);
            if($result->num_rows==0){
                $time=date("Y")."-".date("m")."-".date("d");
                $query="INSERT INTO Orders (time, userId, status) VALUES ('$time', '$userId', 'FILL')";
                $result=$link->query($query);
            };
            $query="SELECT Orders.orderId FROM Orders WHERE Orders.userId LIKE '$userId' AND Orders.status LIKE 'FILL'";
            $orderId=$link->query($query)->fetch_assoc()["orderId"];
            $query="SELECT OrderItem.productId, OrderItem.amount FROM OrderItem WHERE OrderItem.orderId LIKE '$orderId'";
            $result=$link->query($query);
            if($result->num_rows==0){
                echo"Ostoskorisi on tyhjä";
            }else{while($data=$result->fetch_assoc()){
                $productId=$data["productId"];
                $amount=$data["amount"];
                $query="SELECT Products.name, Products.categoryId, Products.prize, Products.description FROM Products WHERE Products.productId LIKE '$productId'";
                $details=$link->query($query)->fetch_assoc();
                $categoryId=$details["categoryId"];
                $prize=round($details["prize"],2);
                $productName=$details["name"];
                $description=$details["description"];
                $query="SELECT Categories.name FROM Categories WHERE Categories.categoryId LIKE '$categoryId'";
                $category=$link->query($query)->fetch_assoc()["name"];
                echo"<div class='item'>
                <h3>$productName</h3>
                <p>$category</p>
                <div class='row'>
                <input type='number' value='$amount' min='1'>
                <span>$prize</span>
                </div>
                </div>";
                $totalPrize+=($prize*$amount);
            };};
            echo"<div class='total'>$totalPrize</div>";
        ?>
        </section>

        <section class="order-form">
            <form action="" method="post">
                <h2>Tilaustiedot</h2>
                <input type="text" placeholder="Nimi">
                <input type="email" placeholder="Sähköpostiosoite">
                <input type="tel" placeholder="Puhelinnumero">
                <button type="submit" name="sendOrder">Tee tilaus</button>
            </form>
            <?php
                if(isset($_POST["sendOrder"])){
                    // set order status to SENT
                }
            ?>
        </section>
    </div>
</main>

<footer>
    Jesse Kujala & Rasmus Rautanen
</footer>

</body>
</html>