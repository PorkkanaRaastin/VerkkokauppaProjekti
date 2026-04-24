<?php
    include_once("link.php");
    session_start();
    if(!isset($_SESSION["userId"])){
        //header("Location: login.php");
    };
    $userId=$_SESSION["userId"];
    if(isset($_POST["sendOrder"])){
        $name=$_POST["name"];
        $email=$_POST["email"];
        $phone=$_POST["phone"];
        if(empty($name)||empty($email)||empty($phone)){
            echo"Täytä kaikki kentät";
        }else{
            $query="SELECT Orders.orderId FROM Orders WHERE Orders.userId LIKE '$userId' AND Orders.status LIKE 'FILL'";
            $result=$link->query($query);
            if($result->num_rows==0){
                echo"Ostoskori on tyhjä";
            }else{
                $orderId=$result->fetch_assoc()["orderId"];
                $query="UPDATE Orders SET Orders.status = 'SENT' WHERE Orders.orderId LIKE '$orderId'";
                $result=$link->query($query);
            };
        };
    };
    if(isset($_POST["changeAmount"])){
        $productId=$_POST["productId"];
        $itemCount=$_POST["newAmount"];
        $query="SELECT Orders.orderId FROM Orders WHERE Orders.userId LIKE '$userId' AND Orders.status LIKE 'FILL'";
        $result=$link->query($query);
        if($result->num_rows!=0){
            $orderId=$result->fetch_assoc()["orderId"];
            $query="UPDATE OrderItem SET OrderItem.amount = $itemCount WHERE OrderItem.orderId LIKE '$orderId' AND OrderItem.productId LIKE '$productId'";
            $result=$link->query($query);
        };
    };
    if(isset($_POST["deleteOrderItem"])){
        $productId=$_POST["productId"];
        $query="SELECT Orders.orderId FROM Orders WHERE Orders.userId LIKE '$userId' AND Orders.status LIKE 'FILL'";
        $result=$link->query($query);
        if($result->num_rows!=0){
            $orderId=$result->fetch_assoc()["orderId"];
            $query="DELETE FROM OrderItem WHERE OrderItem.orderId LIKE '$orderId' AND OrderItem.productId LIKE '$productId'";
            $result=$link->query($query);
        };
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
                <a href="mainpage.php">Etusivu</a>
                <a href="store.php">Kauppa</a>
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
                            <form action='' method='post'>
                            <input name='newAmount' type='number' value='$amount' min='1'>
                            <input type='hidden' name='productId' value='$productId'>
                            <button type='submit' name='changeAmount'>OK</button>
                            <button type='submit' name='deleteOrderItem'>Poista ostoskorista</button>
                            </form>
                            <span>$prize €</span>
                            </div>
                            </div>";
                            $totalPrize+=($prize*$amount);
                        };};
                        echo"<div class='total'>$totalPrize €</div>";
                    ?>
                </section>
                <section class="order-form">
                    <form action="" method="post">
                        <h2>Tilaustiedot</h2>
                        <input name="name" type="text" placeholder="Nimi">
                        <input name="email" type="email" placeholder="Sähköpostiosoite">
                        <input name="phone" type="tel" placeholder="Puhelinnumero">
                        <button type="submit" name="sendOrder">Tee tilaus</button>
                    </form>
                </section>
            </div>
        </main>
        <footer>Jesse Kujala & Rasmus Rautanen</footer>
    </body>
</html>