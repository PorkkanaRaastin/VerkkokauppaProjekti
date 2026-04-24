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
        <nav>
            <img class="nav-logo" src="images/ALTERNATE LOGO_lapinakuva.png" alt="">
            <button><a href="register.php">Minulla ei ole käyttäjää</a></button>
        </nav>
        <div class="page" id="login">
            <div class="bgimage-login">
                <h2>Kirjaudu sisään</h2>
                <form  class ="login-form" action="login.php" method="post">
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
                                header("Location: mainpage.php");
                            }else{
                                echo"Väärä käyttäjänimi tai salasana";
                            };
                        };
                    }else{
                        echo"Täytä kaikki kentät";
                    };
                };
            ?>
        </div>

        <footer>By Jesse and Rasmus</footer>
    </body>
</html>