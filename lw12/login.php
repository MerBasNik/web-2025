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
    <link rel="stylesheet" href="/styles/validate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Logination</title>
</head>
<body>
    <div class="loginpage">
        <div class="loginpage-logo">
            <img class="loginpage-logo__img" src="/images/mainphoto.png" alt="logo" width="462" height="501">
            <h1 class="loginpage-logo__title">Войти</h1>
        </div>
        <form class="loginpage__form form" id="loginpage-form">
            <div class="form__mail">
                <label class="form__label" for="email">Электропочта</label>
                <input class="form__input" type="text" name="email" id="email">
                <label class="form__label_pass" for="email">Введите электропочту в формате user@example.com</label>
                <div class="error-message" id="emailError">Проверьте правильность email</div>
            </div>
            <div class="form__pass">
                <label class="form__label" for="password">Пароль</label>
                <div class="form-input">
                    <input class="form__input" type="text" name="password" id="password">
                    <span class="toggle-password" id="togglePassword" aria-label="Показать/скрыть пароль" role="button" tabindex="0">
                        <i class="fas fa-eye" id="togglePasswordEye"></i>
                    </span>
                </div> 
                <div class="error-message" id="passwordError">
                    Длина пароля минимум 8 символов. Пароль должен содержать минимум:
                    1 строчную и 1 заглавную латинские буквы,
                    1 цифры и 1 спецсимвол. Пробелы использовать нельзя
                </div>
            </div>
            <button class="form__button" type="submit" id="loginBtn">Продолжить</button>
        </form> 
    </div>
    <script src="handlers/validate.js"></script>
</body>
</html>