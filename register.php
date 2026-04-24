<?php
    include_once"link.php"; 
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekisteröityminen</title>
    <link rel="stylesheet" href="styles/homepage.css">
    <link rel="icon" href="images/FAVICON.png" type="image/png">
</head>
<body>
    <nav>
        <img class="nav-logo" src="images/ALTERNATE LOGO_lapinakuva.png" alt="">
        <button><a href="login.php">Minulla on jo käyttäjä</a></button>
    </nav>
    <div class="bgimage-login">
        <form class ="create-account-form" action="" method="post">
        <h2>Rekisteröidy</h2>
        <input type="text" name="username" placeholder="Käyttäjänimi">
        <input type="password" name="password" placeholder="Salasana">
        <input type="password" name="repeatPassword" placeholder="Vahvista salasana">
        <button class="submit-button" type="submit" name="createAccount" value="Luo käyttäjä">Luo käyttäjä</button>
    </form>
    </div>
    <?php
        if(isset($_POST["createAccount"])){
            $username=$_POST["username"];
            $password=$_POST["password"];
            $repeatPassword=$_POST["repeatPassword"];
            $query="SELECT User.username FROM User WHERE User.username = '$username'";
            $result $link->query($query);
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
    
    <footer>By Jesse and Rasmus</footer>
</body>
</html>