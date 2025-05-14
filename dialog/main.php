<?php
    session_start();

    if (!$_SESSION["_is_agreed"]) {
        echo "Вы не авторизованы.<br>";
        echo "<a href='../index.php'>Вернуться назад</a>";
        exit;
    }

    $handle = new mysqli("localhost", "root", "root", "php-mysql");
    $_my_id = [$_SESSION["_object_id"]];
?>
<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Thrower | Messages</title>
        <link rel="shortcut icon" href="../img/avatar.png">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/forward.css">

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    </head>
    <body>

        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-black">
            <div class="container-fluid">

                <h2 class="navbar-brand text-white h2 mb-0" href="#">
                    <img src="../img/avatar.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                    Thrower
                </h2>

                <span class="navbar-text text-white">
                    <?php echo ($handle->query("SELECT `login` from `users` WHERE `id` = '".$_SESSION["_object_id"]."';")->fetch_assoc())["login"]; ?>
                </span>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row m-1 my-3">
                <div class="col-md-1 text-center border border-dark py-2 px-2 rounded" style="height: 91vh;">
                    <a class="btn btn-dark w-100 mb-1" type="button" onclick="_exit()">Выйти</a>
                    <a class="btn btn-dark w-100" href="add_friends/friend_page.php">Друзья</a>
                    <div class="container-fluid border border-dark my-2 rounded" style="height: 80vh;">
                        <div class="row d-flex flex-column">
                            <div class="col">Здесь будут ваши диалоги</div>
                            <hr>
                            <?php
                                $_users = $handle->query("SELECT * FROM `friends` WHERE `status` = '1' AND (`id_1` = '$_my_id[0]' OR `id_2` = '$_my_id[0]');")->fetch_all();
                                foreach ($_users as $row) {
                                    $player_id_row = 2;
                                    if ($row[2] == $_my_id[0])
                                        $player_id_row = 1;

                                    $_friend = $handle->query("SELECT `login` from `users` WHERE `id` = '$row[$player_id_row]';")->fetch_assoc();
                                    echo "<form action='load_dialog/load_handle.php' method='post'>
                                            <input value=\"".$row[$player_id_row]."\" name=\"person_id\" hidden>
                                            <input type=\"submit\" class='bt btn-dark rounded w-100 bg-dark text-white mb-md-2' style='cursor: pointer;' name='_person_name' value='".$_friend["login"]."'>
                                        </form>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 border border-dark rounded" style="height: 91vh;">
                    <div class="container-fluid bg-black rounded-bottom" style="height: 5vh;">
                        <?php
                            if ($_SESSION["_person_name"] == "" || $_SESSION["_person_name"] == NULL)
                                echo "<h2 class='h2 text-center text-white'>Пока тут пусто :(</h2>";
                            else
                                echo "<h2 class='h2 text-center text-white'>Диалог с ".$_SESSION["_person_name"]."</h2>";
                        ?>
                    </div>
                    <div class="container-fluid overflow-auto" id="add_messages" style="height: 75vh;"></div>
                    <div class="container-fluid border border-bottom-0 border-dark rounded py-2" style="height: 11vh;">
                        <form id="message_add_form" method='post'>
                            <div class="row">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-10"><input id="message_text" class="form-control" name="message" type="text" placeholder="Введите сообщение" required></div>
                                        <div class="col-md-2"><small class="text-danger text-center" id="_danger_throw_message"></small></div>
                                    </div>
                                </div>
                                <div class="col"><input class="btn btn-success text-center mt-2" type="submit" value="Отправить"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/events/end_session.js"></script>
        <script src="../js/ajax/ajax_message.js"></script>
        <script src="../js/ajax/ajax_add_message.js"></script>
    </body>
</html>