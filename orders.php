<?php
    include_once("link.php");
    session_start();
    if(!isset($_SESSION["userId"])){
        header("Location: login.php");
    };
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Tilaukset</title>
    </head>
    <body>
        <h1>Omat tilaukset</h1>
        <div class="orderlist">
            <?php
                $userId=$_SESSION["userId"];
                $query="SELECT Orders.orderId, Orders.time FROM Orders WHERE Orders.userId LIKE '$userId' AND Orders.status LIKE 'SENT'";
                $result=$link->query($query);
                while($data=$result->fetch_assoc()){
                    $orderId=$data["orderId"];
                    $time=$data["time"];
                    $query="SELECT OrderItem.productId, OrderItem.amount FROM OrderItem WHERE OrderItem.orderId LIKE '$orderId'";
                    $productResult=$link->query($query);
                    if($productResult->num_rows==0){
                        continue;
                    };
                    echo"<span class='order'>
                    <h4>Tilausnumero: $orderId</h4>
                    <p>Tilattu $time</p>
                    <ul>";
                    while($productData=$productResult->fetch_assoc()){
                        $amount=$productData["amount"];
                        $productId=$productData["productId"];
                        $query="SELECT Products.name FROM Products WHERE Products.productId LIKE '$productId'";
                        $productName=$link->query($query)->fetch_assoc()["name"];
                        echo"<li>$amount"."kpl $productName</li>";
                    }
                    echo"</ul></span>";
                };
            ?>
        </div>
    </body>
</html>