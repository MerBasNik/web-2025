<?php
    require_once 'data_load.php';
    require_once 'validation.php';
    $users = tryLoadJsonData('data/users.json');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Logination</title>
</head>
<body>
    <div class="loginpage">
        <h1 class="loginpage__title">Войти</h1>
        <div class="loginpage__inner">
            <img class="loginpage__inner_img" src="/images/mainphoto.png" alt="logo" width="462" height="501">
            <form class="loginpage__inner_form form">
                <div class="form__mail">
                    <label class="form__label" for="email">Электропочта</label>
                    <input class="form__input" type="email" name="email" id="email" required>
                    <label class="form__label_lite" for="email">Введите электропочту в формате ****@******</label>
                </div>
                <div class="form__pass">
                    <label class="form__label" for="password">Пароль</label>
                    <input class="form__input" type="password" name="password" id="password" required>
                </div>
                <button class="form__button" type="submit">Продолжить</button>
            </form> 
        </div>
    </div>
</body>
</html>