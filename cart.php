<?php
    $confirmOrder=FALSE;
    include_once("link.php");
    session_start();
    if(!isset($_SESSION["userId"])){
        header("Location: login.php");
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
                $confirmOrder=TRUE;
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
        <link rel="icon" href="images/FAVICON.png" type="image/png">
    </head>
    <body>
            <nav>
                <a href="mainpage.php">
                    <img src="images/ALTERNATE LOGO_lapinakuva.png" alt="logo" class="nav-logo">
                </a>
                <a href="store.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-shop" viewBox="0 0 16 16">
                        <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z"/>
                    </svg>
                </a>
            </nav>
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
                            $stackPrize=intval($amount)*floatval($prize);
                            $productName=$details["name"];
                            $description=$details["description"];
                            $query="SELECT Categories.name FROM Categories WHERE Categories.categoryId LIKE '$categoryId'";
                            $category=$link->query($query)->fetch_assoc()["name"];
                            echo"<div class='item'>
                            <h3>$productName</h3>
                            <p>$category</p>
                            <div class='row'>
                            <form class='orders' action='' method='post'>
                            <input name='newAmount' type='number' value='$amount' min='1'>
                            <input type='hidden' name='productId' value='$productId'>
                            <button style='color: lightgreen;' type='submit' name='changeAmount'>OK</button>
                            <button style='color: coral;' type='submit' name='deleteOrderItem'>Poista</button>
                            </form>
                            <span>$stackPrize €</span>
                            </div>
                            </div>";
                            $totalPrize+=($stackPrize);
                        };};
                        echo"<div class='total'>Yhteensä: $totalPrize €</div>";
                    ?>
                </section>
                <section class="order-form">
                    <form class="order-form-info" action="" method="post">
                        <h2>Tilaustiedot</h2>
                        <input name="name" type="text" placeholder="Nimi">
                        <input name="email" type="email" placeholder="Sähköpostiosoite">
                        <input name="phone" type="tel" placeholder="Puhelinnumero">
                        <button type="submit" name="sendOrder">
                            <?php
                                if($confirmOrder==TRUE){
                                    echo"Tilaus vastaanotettu";
                                }else{
                                    echo"Tee tilaus >>>";
                                };
                            ?>
                        </button>
                    </form>
                </section>
            </div>
        </main>
        <footer>Jesse Kujala & Rasmus Rautanen</footer>
    </body>
</html>