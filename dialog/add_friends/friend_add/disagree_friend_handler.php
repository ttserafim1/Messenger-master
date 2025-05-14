<?php

session_start();

if (!$_SESSION["_is_agreed"]) {
    echo "Доступ запрещен.";
    exit;
}

$handle = new mysqli("localhost", "root", "root", "php-mysql");
$temp_data = [$_POST["_get_value"], $_SESSION["_object_id"]];
$handle->query("DELETE FROM `friends` WHERE `id_1` = '$temp_data[0]' AND 'id_2' = '$temp_data[1]'");
header("Location: ../friend_page.php");