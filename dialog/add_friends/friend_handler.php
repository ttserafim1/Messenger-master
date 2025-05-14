<?php

session_start();

unset($_SESSION["_friends_request_error"]);
unset($_SESSION["_friends_request_agree"]);

/*
 * states:
 * throwed - 0
 * friends - 1
 */

function on_main_page() {
    header("Location: friend_page.php");
    exit;
}

if ($_SESSION["_is_agreed"]) {
    $_SESSION["_friends_request_error"] = "Ошибка отправки заявки.";
    $_friend_id = htmlspecialchars(trim($_POST["friend_id"]));
    if (is_numeric($_friend_id) && strlen($_friend_id) <= 12 && strlen($_friend_id) >= 0) {
        $handle = new mysqli("localhost", "root", "root", "php-mysql");
        $_get_id = $handle->query("SELECT `id` FROM `users` WHERE `id` = '$_friend_id'")->fetch_assoc();
        if (!$_get_id) {
            $_SESSION["_friends_request_error"] = "Такого ID не существует";
            on_main_page();
        } else if ($_get_id["id"] == $_SESSION["_object_id"]) {
            $_SESSION["_friends_request_error"] = "Вы не можете отправить заявку самому себе";
            on_main_page();
        }
        $throwed_data = [$_SESSION['_object_id'], $_get_id["id"], 0];
        $_matches = $handle->query("SELECT COUNT(*) AS `total_matches` FROM `friends` WHERE `id_1` = '$throwed_data[0]' AND `id_2` = '$throwed_data[1]'")->fetch_assoc();
        $_already_add = $handle->query("SELECT COUNT(*) AS `total_matches` FROM `friends` WHERE `id_2` = '$throwed_data[0]' AND `id_1` = '$throwed_data[1]'")->fetch_assoc();
        if ($_matches["total_matches"] >= 1) {
            $_SESSION["_friends_request_error"] = "Вы уже отправляли заявку этому человеку";
            on_main_page();
        } else if ($_already_add["total_matches"] >= 1) {
            $_SESSION["_friends_request_error"] = "Вам уже отправлена заявка от этого человека";
            on_main_page();
        }
        $_SESSION["_friends_request_error"] = "";
        $_SESSION["_friends_request_agree"] = "Заявка была успешно отправлена!";
        $handle->query("INSERT INTO `friends` (`id_1`, `id_2`, `status`) VALUES ('$throwed_data[0]', '$throwed_data[1]', '$throwed_data[2]')");
        on_main_page();
    }
    else {
        $_SESSION["_friends_request_error"] = "Введите число";
        on_main_page();
    }
}
else
    echo "Ошибка входа.";