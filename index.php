<?php
    session_start();

    if ($_SESSION["_is_agreed"]) {
        echo "Вы уже вошли.<br>";
        echo '<a href="../dialog/main.php">Вернуться назад</a>';
        exit;
    }

    $title = "Thrower";
    require_once("elements/begin.php");
?>
<header>
    <div class="container-fluid bg-black">
        <div class="row">
            <div class="col-md-2">
                <h2 class="text-white">Thrower</h2>
            </div>
            <div class="col-md-8 p-1">
                <div class="btn-group">
                    <a href="#_contacts_" class="btn btn-primary active" aria-current="page">Контакты</a>
                    <a href="#_about_" class="btn btn-secondary">О нас</a>
                    <a href="#_anymore_" class="btn btn-secondary">Дополнительная информация</a>
                </div>
            </div>
        </div>
    </div>
</header>

<main>

    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h2>Войти в аккаунт</h2>
                <form action="post/login_handler.php" method="post">
                    <label class="form-label">Имя аккаунта</label>
                    <input class="form-control" name="username" type="text" placeholder="Введите логин" required>
                    <label class="form-label">Пароль</label>
                    <input class="form-control" name="password" type="password" placeholder="Введите пароль" required>
                    <div class="text-danger"><?=$_SESSION["_post_error"]?></div><br>
                    <input type="submit" class="btn btn-primary" value="Продолжить">
                    <a href="post/registration/registration_page.php" class="btn btn-light">Регистрация</a>
                </form>
                <label class="text-success"><?=$_SESSION["_was_registered"]?></label>
            </div>
            <div class="col-6 text-center">
                <h1>Почему именно мы?</h1>
                <p>Мы ориетируемся на вас, и именно вы являетесь главным звеном здесь.</p><br>
                <div class="p">Данный сайт был создан нами, чтобы вы могли спокойно переписываться</div>
                <div class="p">С вашими друзьями и знакомыми, и он вам идеально подходит.</div><br>
                <div class="p">Наш минималистичный и простой дизайн встречается редко</div>
                <div class="p">И именно на этом мы делаем опору.</div><br>
                <div class="h3">Добро пожаловать!</div>
            </div>
        </div>
    </div>

    <hr>

    <h1 class="h1 text-center bg-black text-white" id="_contacts_">Контакты и информация</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 text-center">
                <h2 class="h2">Мы есть в многих соц. сетях</h2><br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="a h5">VK</a>
                            - здесь мы бываем часто<br>
                            <a href="#" class="a h5">Одноклассники</a>
                            - да-да, здесь кто-то бывает :)
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="a h5">Instagram</a>
                            - здесь не реже<br>
                            <a href="#" class="a h5">Телеграм</a>
                            - мы с вами на одной волне
                        </div>
                    </div>
                </div><br><br>
                <h4 class="h5">Вы можете следить за нашей работой в соц.сетях!</h4>
            </div>
            <div class="col-md-6 text-center p-4", id="_about_">
                <h2 class="h2">О нас</h2>
                <div class="p">Мы те - кто подняли себя сами</div>
                <div class="p">И мы те - кто работает для вас.</div>
                <div class="p">Доверяя нам, вы доверяете сами себе, ведь <b>наша</b> работа</div>
                <div class="h3">Идеальна.</div>
            </div>
        </div>
    </div>

    <hr>

    <h1 class="h1 text-center bg-black text-white" id="_anymore_">Дополнительная информация</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="p">Данный проект был создан одним человеком и создан лишь для практики</div>
                <div class="p">Ничего из перечисленного не нужно воспринимать всерьез</div>
            </div>
            <div class="col-md-6">
                <div class="p">Контакты автора:</div>
                <div class="p">VK - vk.com/wfsmeruxa</div>
                <div class="p">BH - https://www.blast.hk/members/422424/</div>
            </div>
        </div>
    </div>

    <hr>

</main>

<?php
  require_once("elements/end.php");
?>