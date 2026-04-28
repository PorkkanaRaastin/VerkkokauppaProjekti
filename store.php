<?php
//Jesse tehnyt php ja rasmus muokannut html runkoa jotta tyylit saa hyvin toimimaan
    include_once("link.php");
    session_start();
    if(!isset($_SESSION["userId"])){
        header("Location: login.php");
    };
    if(isset($_POST["addItem"])){
        $productId=$_POST["productId"];
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
        $query="SELECT OrderItem.amount FROM OrderItem WHERE OrderItem.productId LIKE '$productId' AND OrderItem.orderId LIKE '$orderId'";
        $result=$link->query($query);
        if($result->num_rows==0){
            $query="INSERT INTO OrderItem (orderId, productId, amount) VALUES ('$orderId', '$productId', '1')";
            $result=$link->query($query);
        }else{
            $amount=intval($result->fetch_assoc()["amount"])+1;
            $query="UPDATE OrderItem SET OrderItem.amount = $amount WHERE OrderItem.orderId LIKE '$orderId' AND OrderItem.productId LIKE '$productId'";
            $result=$link->query($query);
        };
    };
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Verkkokauppa</title>
        <link rel="stylesheet" href="styles/store.css">
        <link rel="icon" href="images/FAVICON.png" type="image/png">
    </head>
    <body>
        <main>
            <header class="header">
                <div>
                    <a href="mainpage.php">
                        <img src="images/ALTERNATE LOGO_lapinakuva.png" alt="logo" class="logo">
                    </a>
                </div>
                <div>
                    <?php
                        $userId=$_SESSION["userId"];
                        $query="SELECT Orders.orderId FROM Orders WHERE Orders.userId LIKE '$userId' AND Orders.status LIKE 'FILL'";
                        $result=$link->query($query);
                        if($result->num_rows==0){
                            $OrderItemCount=0;
                        }else{
                            $orderId=$result->fetch_assoc()["orderId"];
                            $query="SELECT COUNT(DISTINCT OrderItem.productId) AS 'distinct-count' FROM OrderItem WHERE OrderItem.orderId LIKE '$orderId'";
                            $OrderItemCount=$link->query($query)->fetch_assoc()["distinct-count"];
                        };
                        // $OrderItemCount = tavaran määrä
                    ?>
                    <a class="svg"href="cart.php">
                        <img src="images\shopping_cart_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.svg" alt="svg"">
                    </a>
                </div>
            </header>
            <h1>Verkkokauppa</h1>
            <form action="" method="post">
                <input name="keyword" type="text" placeholder="Etsi tuotteita..." class="search">
                <div class="filters">
                    <?php
                        $val=" checked='true'"
                    ?>
                    <label><input name="f0" type="checkbox"<?php
                        if(isset($_POST["f0"])||(!isset($_POST["f1"])&&!isset($_POST["f2"])&&!isset($_POST["f3"])&&!isset($_POST["f4"])&&!isset($_POST["f5"])&&!isset($_POST["f6"]))){echo$val;};
                    ?>> Kaikki</label>
                    <label><input name="f1" type="checkbox"<?php
                        if(isset($_POST["f1"])){echo$val;};?>> Liha</label>
                    <label><input name="f2" type="checkbox"<?php
                        if(isset($_POST["f2"])){echo$val;};?>> Kala</label>
                    <label><input name="f3" type="checkbox"<?php
                        if(isset($_POST["f3"])){echo$val;};?>> Viljatuotteet</label>
                    <label><input name="f4" type="checkbox"<?php
                        if(isset($_POST["f4"])){echo$val;};?>> Marjat</label>
                    <label><input name="f5" type="checkbox"<?php
                        if(isset($_POST["f5"])){echo$val;};?>> Juustot</label>
                    <label><input name="f6" type="checkbox"<?php
                        if(isset($_POST["f6"])){echo$val;};?>> Muut tuotteet</label>
                </div>
                <button style="width: 70px;" type="submit" name="search">Hae</button>
            </form>
            <a href="orders.php"><button>Tilaukset</button></a>
            <div class="products">
                <?php
                    $baseQuery="SELECT Products.name, Products.categoryId, Products.description, Products.prize, Products.productId FROM Products WHERE Products.stock > '0'";
                    if(isset($_POST["search"])){
                        if(isset($_POST["keyword"])){
                            $keyword=$_POST["keyword"];
                            $baseQuery=$baseQuery." AND Products.name LIKE '%$keyword%'";
                        };
                        if(!isset($_POST["f0"])){
                            if(!isset($_POST["f1"])){$baseQuery=$baseQuery." AND Products.categoryId <> 1";};
                            if(!isset($_POST["f2"])){$baseQuery=$baseQuery." AND Products.categoryId <> 2";};
                            if(!isset($_POST["f3"])){$baseQuery=$baseQuery." AND Products.categoryId <> 3";};
                            if(!isset($_POST["f4"])){$baseQuery=$baseQuery." AND Products.categoryId <> 4";};
                            if(!isset($_POST["f5"])){$baseQuery=$baseQuery." AND Products.categoryId <> 5";};
                            if(!isset($_POST["f6"])){$baseQuery=$baseQuery." AND Products.categoryId <> 6";};
                        };
                    };
                    $result=$link->query($baseQuery);
                    if($result->num_rows==0){
                        echo"No results.";
                    }else{while($data=$result->fetch_assoc()){
                        $name=$data["name"];
                        $targetId=$data["categoryId"];
                        $category=$link->query("SELECT name FROM Categories WHERE categoryId = '$targetId'")->fetch_assoc()["name"];
                        $description=$data["description"];
                        $productId=$data["productId"];
                        $prize=round(floatval($data["prize"]),2)."€";
                        echo"<div class='card'>
                        <h3>$name</h3>
                        <p class='category'>$category</p>
                        <span class='description'>$description</span>
                        <div class='bottom'>
                        <span>$prize</span>
                        <form action='' method='post'>
                        <input type='hidden' value='$productId' name='productId'>
                        <button type='submit' name='addItem'>";
                        if(isset($_POST["addItem"])&&$_POST["productId"]==$productId){
                            echo"Lisätty";
                        }else{
                            echo"Lisää ostoskoriin";
                        };
                        echo"</button></form></div></div>";
                    };};
                ?>
            </div>
        </main>
        <footer>By Jesse and Rasmus</footer>
    </body>
</html>