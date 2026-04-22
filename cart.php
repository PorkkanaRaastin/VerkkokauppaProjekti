<?php
    include_once"link.php";
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
            <div class="item">
                <h3>Tuotteen Nimi</h3>
                <p>Luokka 1</p>
                <div class="row">
                    <input type="number" value="2" min="1">
                    <span>7€</span>
                </div>
            </div>

            <div class="item">
                <h3>Tuotteen Nimi</h3>
                <p>Luokka 4</p>
                <div class="row">
                    <input type="number" value="1" min="1">
                    <span>14€</span>
                </div>
            </div>

            <div class="total">Yhteensä 28€</div>
        </section>

        <section class="order-form">
            <h2>Tilaustiedot</h2>
            <input type="text" placeholder="Nimi">
            <input type="email" placeholder="Sähköpostiosoite">
            <input type="tel" placeholder="Puhelinnumero">
            <button>Tee tilaus</button>
        </section>
    </div>
</main>

<footer>
    © TAITAJA 2024 Etu Sukunimi Oppilaitos
</footer>

</body>
</html>