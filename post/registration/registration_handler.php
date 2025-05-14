<?php

session_start();

$allow_keys = [
    "_registration_error_email",
    "_registration_error_name",
    "_registration_error_username",
    "_registration_error_password",
    "_was_registered"
];

foreach ($allow_keys as $key) {
    unset($_SESSION[$key]);
}

$data = [];
foreach ($_POST as $key) {
    array_push($data, trim($key));
}

$return = false;
if (strlen($data[0]) <= 3) {
    $_SESSION["_registration_error_email"] = "Email должен содержать более 4х символов";
    $return = true;
} else if (strlen($data[1]) <= 3) {
    $_SESSION["_registration_error_name"] = "В вашем имени должно быть минимум 4 символа";
    $return = true;
} else if (strlen($data[2]) <= 2) {
    $_SESSION["_registration_error_username"] = "Ваш логин должен состоять минимум из 3х символов";
    $return = true;
} else if (strlen($data[3]) <= 4) {
    $_SESSION["_registration_error_password"] = "Ваш пароль должен состоять минимум из 4х символов";
    $return = true;
}

if ($return) {
    header("Location: registration_page.php");
    exit;
}

$handle = new mysqli("localhost", "root", "root", "php-mysql");
$_logins = $handle->query('SELECT `login`, `email` FROM `users`')->fetch_all();

$is_login_free = true;
$is_email_free = true;
foreach ($_logins as $index) {
    if (strtolower($index[0]) == strtolower($data[2]))
        $is_login_free = false;
    if (strtolower($index[1]) == strtolower($data[0]))
        $is_email_free = false;
}

if ($is_login_free && $is_email_free) {
    $data[3] = md5($data[3]);
    $handle->query("INSERT INTO `users` (`email`, `login`, `name`, `password`) VALUES ('$data[0]', '$data[2]', '$data[1]', '$data[3]')");
    $_SESSION["_was_registered"] = "Вы были успешно зарегистрированы. Введите логин и пароль.";
    header("Location: ../../index.php");
} else if (!$is_login_free) {
    $_SESSION["_registration_error_username"] = "Данный логин уже занят";
    header("Location: registration_page.php");
    exit;
} else if (!$is_email_free) {
    $_SESSION["_registration_error_email"] = "Данный email уже занят";
    header("Location: registration_page.php");
    exit;
}