<?php

session_start();

if ($_SESSION["_is_agreed"]) {
    echo "Доступ запрещен.";
    exit;
}

unset($_SESSION["_post_error"]);
unset($_SESSION["_was_registered"]);

$handle = new mysqli("localhost", "root", "root", "php-mysql");
$_users = $handle->query('SELECT `id`, `login`, `password` FROM `users`');

$username = htmlspecialchars(trim($_POST["username"]));
$password = md5(htmlspecialchars(trim($_POST["password"])));

$_SESSION["_post_error"] = "Введен неверный логин или пароль";
foreach ($_users as $row) {
    $data = array($row["login"], $row["password"]);
    if ($data[0] == $username && $data[1] == $password) {
        $_SESSION["_is_agreed"] = true;
        $_SESSION["_object_id"] = $row["id"];
        $_SESSION["_post_error"] = "";
        header("Location: ../dialog/main.php");
        exit;
    }
}
if (strlen($_SESSION["_post_error"]) > 1)
    header("Location: ../index.php");