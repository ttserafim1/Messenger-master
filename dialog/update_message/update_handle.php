<?php

session_start();

if ($_SESSION["messages_loaded"]) {
    $handle = new mysqli("localhost", "root", "root", "php-mysql");

    $messages = $handle->query("SELECT * FROM `messages` WHERE (`from` = '" . $_SESSION["_object_id"] . "' OR `from` = '" . $_SESSION["messages_person_id"] . "') ORDER BY `data` ASC")->fetch_all();
    if (count($messages) != count($_SESSION["messages"])) {
        $_SESSION["messages"] = [];
        // ADD

        foreach ($messages as $row) {
            if (($_SESSION["_object_id"] == $row[1] || $_SESSION["_object_id"] == $row[2]) && ($_SESSION["messages_person_id"] == $row[1] || $_SESSION["messages_person_id"] == $row[2]))
                array_push($_SESSION["messages"], ["date" => $row[4], "writed_id" => $row[1], "got_id" => $row[2], "message" => $row[3]]);
        }

        // ADD

        // UPDATE

        $ready_string = "";
        foreach ($_SESSION["messages"] as $keys) {
            /*
            * date - дата
            * writed_id - отправляющий id
            * got_id - получающий id
            * message - сообщение
            */
            if ($keys["writed_id"] == $_SESSION["_object_id"]) {
                $ready_string = $ready_string . "<div class='container-fluid'>
                                                    <div class='row'>
                                                        <div class='col-md-6 mt-md-2 rounded-2' style='background-color: #d5d5d5; float: left; word-wrap: break-word;'>
                                                            <h5 class='h5 py-md-1 col-md-12 px-2' style='color: #383838;'>" . $keys["message"] . "</h5>
                                                        </div>
                                                    </div>
                                                </div>";
            } else {
                $ready_string = $ready_string . "<div class='container-fluid'>
                                                    <div class='row'>
                                                         <div class='col-md-6'></div>
                                                        <div class='col-md-6 mt-md-2 rounded-2' style='background-color: #2d2d2d; float: right; word-wrap: break-word;'>
                                                            <h5 class='h5 py-md-1 col-md-12 px-2' style='color: #cdcdcd;'>" . $keys["message"] . "</h5>
                                                        </div>
                                                    </div>
                                               </div>";
            }
        }

        $_SESSION["ready_string"] = $ready_string;

        // UPDATE
    }

    mysqli_close($handle);
}

$response = array(
    'status' => 'success',
    'message' => $_SESSION["ready_string"]
);
echo json_encode($response);