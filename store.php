<?php
    include_once("link.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Store</title>
        <link rel="stylesheet" href="store.css">
        <link rel="stylesheet" href="grid.css">
    </head>
    <body>
        <div class="gridLayout">
            <div id="productDisplay">
                <?php
                    $query="SELECT Product.name, Category.name AS 'category', Product.description, Product.prize FROM Product INNER JOIN Category ON Product.categoryId = Category.categoryId";
                    $result=$link->query($query);
                    while($data=$result->fetch_assoc()){
                        $name=$data["name"];
                        $category=$data["category"];
                        $description=$data["description"];
                        $prize=$data["prize"];
                        echo"<div class='productContainer'>";

                        echo"</div>";
                    };
                ?>
            </div>
        </div>
    </body>
</html>