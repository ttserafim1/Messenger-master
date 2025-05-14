<?php
    session_start();
?>
<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Thrower | Registration</title>
        <link rel="shortcut icon" href="../../img/avatar.png">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/forward.css">
    </head>
    <body>
        <?php
            require_once("../../elements/title.php");
        ?>
        <div class="container-fluid text-center">
            <div class="h1">Регистрация</div>
            <form action="../registration/registration_handler.php" method="post">
                <label class="form-label">Email</label>
                <input class="form-control" name="email" type="email" placeholder="Введите почту" required>
                <div class="text-danger"><?=$_SESSION["_registration_error_email"]?></div>
                <label class="form-label">Имя</label>
                <input class="form-control" name="name" type="text" placeholder="Введите ваше имя" required>
                <div class="text-danger"><?=$_SESSION["_registration_error_name"]?></div>
                <label class="form-label">Логин</label>
                <input class="form-control" name="login" type="text" placeholder="Введите логин" required>
                <div class="text-danger"><?=$_SESSION["_registration_error_username"]?></div>
                <label class="form-label">Пароль</label>
                <input class="form-control" name="password" type="password" placeholder="Введите пароль" required>
                <div class="text-danger"><?=$_SESSION["_registration_error_password"]?></div><br>
                <input type="submit" class="btn btn-primary" value="Зарегистрироваться">
            </form>
        </div>

        <hr>

        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/includer.js"></script>
    </body>
</html>
