<?php
    include_once("link.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Verkkokauppa</title>
        <link rel="stylesheet" href="store.css">
    </head>
    <body>
        <main>
            <header class="header">
                <div>LOGO</div>
                <div>🛒 Etusivu</div>
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
                    $query="SELECT Products.name, Products.categoryId, Products.description, Products.prize FROM Products";
                    $result=$link->query($query);
                    if($result->num_rows==0){
                        echo"No results.";
                    }else{while($data=$result->fetch_assoc()){
                        $name=$data["name"];
                        $targetId=$data["categoryId"];
                        $category=$link->query("SELECT name FROM Categories WHERE categoryId = '$targetId'")->fetch_assoc()["name"];
                        $description=$data["description"];
                        $prize=round(floatval($data["prize"]),2)."€";
                        echo"<div class='card'>
                        <h3>$name</h3>
                        <p class='category'>$category</p>
                        <span>$description</span>
                        <div class='bottom'>
                        <span>$prize</span>
                        <button>Add to cart</button>
                        </div>
                        </div>";
                    };};
                ?>  
            </div>
        </main>
    </body>
</html>