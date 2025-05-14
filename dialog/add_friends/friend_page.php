<?php
    session_start();
    if (!$_SESSION["_is_agreed"]) {
        echo "Сначала войдите в аккаунт.<br>";
        echo '<a href="../../index.php">Вернуться назад</a>';
        exit;
    }
    $_data_id = [$_SESSION["_object_id"]];
    $handle = new mysqli("localhost", "root", "root", "php-mysql");
    $_get_friends = $handle->query("SELECT * FROM `friends` WHERE `status` = '1' AND (`id_1` = '$_data_id[0]' OR `id_2` = '$_data_id[0]')")->fetch_all();
    $_get_id = $handle->query("SELECT `id_1`, `id_2`, `status` FROM `friends` WHERE `id_1` = '$_data_id[0]' AND `status` = '0'")->fetch_all();
?>
<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Thrower | Друзья</title>
        <link rel="shortcut icon" href="../../img/avatar.png">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
    </head>
    <body>
        <div class="container-fluid bg-black">
            <div class="row">
                <div class="col-md-2">
                    <h2 class="h2 text-white">Thrower</h2>
                </div>
                <div class="col-md-8 p-1">
                    <a href="../main.php" class="btn btn-primary active" aria-current="page">Вернуться назад</a>
                </div>
            </div>
        </div>
        <div class="container-fluid text-center">
            <div class="h1">Добавить друга | Ваш ID: №<?=$_SESSION["_object_id"]?></div>
            <label class="form-label">Чтобы добавить в друзья, ниже напишите ID вашего друга</label>
            <form action="../add_friends/friend_handler.php" method="post">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-11">
                            <input class="form-control" name="friend_id" type="text" placeholder="Введите ID" required>
                            <div class="text-danger"><?=$_SESSION["_friends_request_error"]?></div>
                            <div class="text-success"><?=$_SESSION["_friends_request_agree"]?></div>
                        </div>
                        <div class="col-md-1 text-start"><input type="submit" class="btn btn-primary" value="Добавить"></div>
                    </div>
                </div>
            </form>
        </div>

        <br>

        <div class="text-center bg-black text-white"><h1 class="h1 pb-md-2">Заявки в друзья</h1></div>
        <div class="overflow-auto w-100 text-center border border-dark" style="height: 350px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 h4">
                        <h2 class="h2 pt-2">Отправленные</h2>
                        <hr>
                        <?php
                            foreach ($_get_id as $key) {

                                /*
                                 * from - key[0]
                                 * to - key[1]
                                 * status - key[2]
                                 */

                                $_login_id2 = $handle->query("SELECT `login` FROM `users` WHERE `id` = '$key[1]'")->fetch_assoc();
                                echo '<div class="container-fluid text-center mx-5">
                                        <h4 class="h4 mx-3" style="float: left;">Вы отправили заявку '.$_login_id2["login"].'['.$key[1].']</h4> 
                                        <form action="friend_delete/delete_handler.php" method="post">
                                            <input value="'.$key[1].'" name="_get_value" hidden>
                                            <input type="submit" class="btn btn-danger h3" value="Отмена" style="float: left;">
                                        </form>
                                        </div>';
                            }
                        ?>
                    </div>
                    <div class="col-md-6 h4">
                        <h2 class="h2 pt-2">Входящие</h2>
                        <hr>
                        <?php
                            $_get_id = $handle->query("SELECT `id_1`, `id_2`, `status` FROM `friends` WHERE `id_2` = '$_data_id[0]' AND `status` = '0'")->fetch_all();
                            foreach ($_get_id as $key) {
                                $_login_id2 = $handle->query("SELECT `login` FROM `users` WHERE `id` = '$key[0]'")->fetch_assoc();
                                echo '<div class="container-fluid text-center mx-5">
                                            <h4 class="h4 mx-2" style="float: left;">Вам пришла заявка от '.$_login_id2["login"].'['.$key[0].']</h4> 
                                            <form action="friend_add/agree_friend_handler.php" method="post">
                                                <input value="'.$key[0].'" name="_get_value" hidden>
                                                <input type="submit" class="btn btn-primary h3 mx-2" value="Подтвердить" style="float:left;">
                                            </form>
                                            <form action="friend_add/disagree_friend_handler.php" method="post">
                                                <input value="'.$key[0].'" name="_get_value" hidden>
                                                <input type="submit" class="btn btn-secondary h3" value="Отклонить" style="float:left;">
                                            </form>
                                        </div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <hr>


        <div class="text-center bg-black text-white"><h1 class="h1 pb-md-2">Ваши друзья</h1></div>
        <div class="container-fluid border border-dark overflow-auto" style="height: 240px;">
            <div class="row">
                <div class="col-md-6">
                    <?php
                        foreach ($_get_friends as $key) {
                            $_n_key = 1;
                            if ($key[1] == $_SESSION['_object_id'])
                                $_n_key = 2;
                            $_login_user = $handle->query("SELECT `login` FROM `users` WHERE `id` = '$key[$_n_key]'")->fetch_assoc();
                            echo '<h4 class="h4 pt-1">'.$_login_user["login"].'</h4>';
                        }
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    foreach ($_get_friends as $key) {
                        $_n_key = 1;
                        if ($key[1] == $_SESSION['_object_id'])
                            $_n_key = 2;
                        $_login_user = $handle->query("SELECT `login` FROM `users` WHERE `id` = '$key[$_n_key]'")->fetch_assoc();
                        echo '<form action="friend_remove/remove_handler.php" method="post" class="pt-1">
                                <input value="'.$key[0].'" name="_get_value" hidden>
                                <input type="submit" class="btn btn-danger h3" value="Удалить из друзей">
                            </form>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <script src="../../js/bootstrap.bundle.min.js"></script>
    </body>
</html>
