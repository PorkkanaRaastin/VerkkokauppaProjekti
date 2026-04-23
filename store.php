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
        <meta charset="UTF-8">
        <title>Verkkokauppa</title>
        <link rel="stylesheet" href="styles/store.css">
    </head>
    <body>
        <main>
            <header class="header">
                <div><a href="mainpage.php"><img src="images/ALTERNATE LOGO.png" alt="logo" class="logo"></a></div>
                <div>
                    <a href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                    </svg></a>
                </div>
            </header>
            <h1>Verkkokauppa</h1>
            <input type="text" placeholder="Etsi tuotteita..." class="search">
            <div class="filters">
                <label><input type="checkbox" checked> Kaikki</label>
                <label><input type="checkbox"> Kala</label>
                <label><input type="checkbox"> Liha</label>
                <label><input type="checkbox"> Viljatuotteet</label>
                <label><input type="checkbox"> Marjat</label>
                <label><input type="checkbox"> Juustot</label>
                <label><input type="checkbox"> Muut tuotteet</label>
            </div>
            <div class="products">
                <?php
                    $query="SELECT Products.name, Products.categoryId, Products.description, Products.prize, Products.productId FROM Products";
                    $result=$link->query($query);
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
                        <span>$description</span>
                        <div class='bottom'>
                        <span>$prize</span>
                        <form action='' method='post'>
                        <input type='hidden' value='$productId' name='productId'>
                        <button type='submit' name='addItem'>Lisää ostoskoriin</button>
                        </form>
                        </div>
                        </div>";
                    };};
                    if(isset($_POST["addItem"])){
                        $productId=$_POST["productId"];
                        $userId=$_SESSION["userId"];
                        $query="SELECT Cart.cartId FROM Cart WHERE Cart.userId LIKE '$userId'";
                        $result=$link->query($query);
                        if($result->num_rows==0){
                            $time = date("Y")."-".date("m")."-".date("d");
                            $query="INSERT INTO Orders (time) VALUES ('$time')";
                            $result=$link->query($query);
                            $orderId=$link->insert_id;
                            $query="INSERT INTO Cart (orderId, userId) VALUES ('$orderId', '$userId')";
                        }else{
                            $query="SELECT Cart.orderId FROM Cart WHERE Cart.userId LIKE '$userId'";
                            $orderId=$link->query($query)->fetch_assoc()["orderId"];
                        };
                        if(TRUE){
                            $query="INSERT INTO CartItem (cartId, productId, amount) VALUES ('$orderId', '$productId', '1')";
                        }else{
                            $query="SELECT CartItem.amount FROM CartItem WHERE CartItem.cartId LIKE '$orderId' AND CartItem.productId LIKE '$productId'";
                            $amount=intval($link->query($query)->fetch_assoc()["amount"])+1;
                            $query="UPDATE CartItem SET CartItem.amount = '$amount' WHERE CartItem.productId LIKE '$productId' AND cartId LIKE '$orderId'";
                            $result=$link->query($query);
                        };
                    };
                ?>
            </div>
        </main>
    </body>
</html>