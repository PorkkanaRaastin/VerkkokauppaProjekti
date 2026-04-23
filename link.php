<?php
    $server="localhost";
    $user="root";
    $password="";
    $database="onlinestore";
    $link=new mysqli($server,$user,$password,$database);
    if($link->connect_error) {
        die("Connection error: ".$link->connect_error);
    };
    $link->set_charset("utf8");
?>