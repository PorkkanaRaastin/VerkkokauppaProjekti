<?php
//Jessen tekemä
    session_start();
    session_unset();
    session_destroy();
    // mainpage vai login?
    header("Location: login.php");
?>