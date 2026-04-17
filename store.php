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
                    $query = "SELECT Product.name, Category.name, Product.description, Product.prize FROM Product INNER JOIN Category ON "
                ?>
            </div>
        </div>
    </body>
</html>