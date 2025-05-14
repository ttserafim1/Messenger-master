<?php

session_start();

if (!$_SESSION["_is_agreed"]) {
    echo "Доступ запрещен.";
    exit;
}

$_SESSION["_person_name"] = $_POST["_person_name"];
$_SESSION["messages"] = [];
$_SESSION["messages_person_id"] = $_POST["person_id"];
$_SESSION["messages_loaded"] = true;

header("Location: ../main.php");