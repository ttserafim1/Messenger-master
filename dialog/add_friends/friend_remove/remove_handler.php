<?php

session_start();

if (!$_SESSION["_is_agreed"]) {
    echo "Доступ запрещен.";
    exit;
}

$handle = new mysqli("localhost", "root", "root", "php-mysql");
$temp_data = [$_POST["_get_value"]];
$handle->query("DELETE FROM `friends` WHERE `identify` = '$temp_data[0]'");
header("Location: ../friend_page.php");