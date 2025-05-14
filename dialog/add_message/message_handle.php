<?php

session_start();

$response = [
    "status" => "",
    "message" => ""
];

if (strlen($_POST["message"]) < 2) {
    $response["status"] = "error";
    $response["message"] = "Слишком короткое сообщение";
}
else if ($_SESSION["messages_person_id"] == NULL) {
    $response["status"] = "error";
    $response["message"] = "Выберите диалог";
}
else {
    $handle = new mysqli("localhost", "root", "root", "php-mysql");
    $data = [$_SESSION["_object_id"], $_SESSION["messages_person_id"], $_POST["message"]];
    $handle->query("INSERT INTO `messages` (`from`, `to`, `message`) VALUES ('$data[0]', '$data[1]', '$data[2]')");
    $response["status"] = "success";
}

echo json_encode($response);