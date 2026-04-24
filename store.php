<?php
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
                    <a href="cart.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                        </svg>
                    </a>
                </div>
            </header>
            <h1>Verkkokauppa</h1>
            <form action="" method="post">
                <input name="keyword" type="text" placeholder="Etsi tuotteita..." class="search">
                <div class="filters">
                    <label><input name="filter0" type="checkbox" checked> Kaikki</label>
                    <label><input name="filter1" type="checkbox"> Liha</label>
                    <label><input name="filter2" type="checkbox"> Kala</label>
                    <label><input name="filter3" type="checkbox"> Viljatuotteet</label>
                    <label><input name="filter4" type="checkbox"> Marjat</label>
                    <label><input name="filter5" type="checkbox"> Juustot</label>
                    <label><input name="filter6" type="checkbox"> Muut tuotteet</label>
                </div>
                <button style="width: 70px;" type="submit" name="search">Hae</button>
            </form>
            <div class="products">
                <?php
                    $baseQuery="SELECT Products.name, Products.categoryId, Products.description, Products.prize, Products.productId FROM Products WHERE Products.stock > '0'";
                    if(isset($_POST["search"])){
                        if(isset($_POST["keyword"])){
                            $keyword=$_POST["keyword"];
                            $baseQuery=$baseQuery." AND Products.name LIKE '%$keyword%'";
                        };
                        if(!isset($_POST["filter0"])){
                            if(!isset($_POST["filter1"])){$baseQuery=$baseQuery." AND Products.categoryId <> 1";};
                            if(!isset($_POST["filter2"])){$baseQuery=$baseQuery." AND Products.categoryId <> 2";};
                            if(!isset($_POST["filter3"])){$baseQuery=$baseQuery." AND Products.categoryId <> 3";};
                            if(!isset($_POST["filter4"])){$baseQuery=$baseQuery." AND Products.categoryId <> 4";};
                            if(!isset($_POST["filter5"])){$baseQuery=$baseQuery." AND Products.categoryId <> 5";};
                            if(!isset($_POST["filter6"])){$baseQuery=$baseQuery." AND Products.categoryId <> 6";};
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