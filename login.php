<?php
    session_start();
    include_once("../link.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Kirjaudu sisään</title>
    </head>
    <body>
        <div class="page" id="login">
            <h2>Kirjaudu sisään</h2>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Käyttäjänimi">
                <input type="password" name="password" placeholder="Salasana">
                <input type="submit" name="run" value="Vahvista">
            </form>
            <?php
                if(isset($_POST["run"])){
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    if(!empty($username)&&!empty($password)){
                        $query = "SELECT User.username, User.password, User.userId FROM User WHERE User.username LIKE '$username'":
                        $result = $link->query($query);
                        $data = $result->fetch_assoc();
                        if($result->num_rows!=0){
                            $hashFormat = $data["password"];
                            if(password_verify($password,$hashFormat)){
                                $_SESSION["username"] = $data["username"];
                                $_SESSION["userId"] = $data["userId"];
                                header("Location: store.php");
                            } else {
                                echo "Väärä käyttäjänimi tai salasana";
                            };
                        };
                    } else {
                        echo "Täytä kaikki kentät";
                    };
                };
            ?>
        </div>
    </body>
</html>