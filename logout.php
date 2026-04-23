<?php
    session_start();
    session_unset();
    session_destroy();
    // mainpage vai login?
    header("Location: mainpage.php");
?>