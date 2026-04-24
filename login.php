<?php
    session_start();
    include_once("link.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Kirjaudu sisään</title>
        <link rel="stylesheet" href="styles/homepage.css">
        <link rel="icon" href="images/FAVICON.png" type="image/png">
    </head>
    <body>
<<<<<<< HEAD
        <nav>
            <img class="nav-logo" src="images/ALTERNATE LOGO_lapinakuva.png" alt="">
            <button><a href="register.php">Minulla ei ole käyttäjää</a></button>
        </nav>
        <div class="page" id="login">
            <div class="bgimage-login">
                <h2>Kirjaudu sisään</h2>
                <form  class ="login-form" action="login.php" method="post">
=======
        <nav></nav>
        <div class="page" id="login">
            <h2>Kirjaudu sisään</h2>
            <form class="login-form" action="login.php" method="post">
>>>>>>> e80faab97de9df965fd40d6369a18ece3d08961c
                <input type="text" name="username" placeholder="Käyttäjänimi">
                <input type="password" name="password" placeholder="Salasana">
                <button class="submit-button" type="submit" name="run" value="Vahvista">Kirjaudu</button>
            </form>
            </div>
            <?php
                if(isset($_POST["run"])){
                    $username=$_POST["username"];
                    $password=$_POST["password"];
                    if(!empty($username)&&!empty($password)){
                        $query="SELECT User.username, User.password, User.userId FROM User WHERE User.username LIKE '$username'";
                        $result=$link->query($query);
                        $data=$result->fetch_assoc();
                        if($result->num_rows!=0){
                            $hashFormat=$data["password"];
                            if(password_verify($password,$hashFormat)){
                                $_SESSION["username"]=$data["username"];
                                $_SESSION["userId"]=$data["userId"];
                                header("Location: store.php");
                            }else{
                                echo"Väärä käyttäjänimi tai salasana";
                            };
                        };
                    }else{
                        echo"Täytä kaikki kentät";
                    };
                };
            ?>
<<<<<<< HEAD
=======
            <form class="create-account-form" action="" method="post">
                <h2>Tai luo uusi käyttäjä</h2>
                <input type="text" name="username" placeholder="Käyttäjänimi">
                <input type="password" name="password" placeholder="Salasana">
                <input type="password" name="repeatPassword" placeholder="Vahvista salasana">
                <input type="submit" name="createAccount" value="Luo käyttäjä">
            </form>
            <?php
                if(isset($_POST["createAccount"])){
                    $username=$_POST["username"];
                    $password=$_POST["password"];
                    $repeatPassword=$_POST["repeatPassword"];
                    $query="SELECT User.username FROM User WHERE User.username LIKE '$username'";
                    $result=$link->query($query);
                    if(empty($username)||empty($password)||empty($repeatPassword)){
                        echo"Täytä kaikki kentät";
                    }else if($result->num_rows!=0){
                        echo"Käyttäjänimi on jo käytössä";
                    }else if($password!=$repeatPassword){
                        echo"Salasanat eivät täsmää";
                    }else{
                        $hashFormat=password_hash($password,PASSWORD_DEFAULT);
                        $query="INSERT INTO User (username, password) VALUES ('$username','$hashFormat')";
                        $result=$link->query($query);
                        $query="SELECT User.username, User.userId FROM User WHERE User.password LIKE '$hashFormat'";
                        $data=$link->query($query)->fetch_assoc();
                        $_SESSION["username"]=$data["username"];
                        $_SESSION["userId"]=$data["userId"];
                        header("Location: store.php");
                    };
                };
            ?>
>>>>>>> e80faab97de9df965fd40d6369a18ece3d08961c
        </div>

        <footer>By Jesse and Rasmus</footer>
    </body>
</html>