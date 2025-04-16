<?php
    require_once 'data_load.php';
    require_once 'validation.php';
    $defaultUrl = 'home';
    $users = tryLoadJsonData('data/users.json');
    if (isset($users['error'])) {
        die("Ошибка загрузки данных: " . htmlspecialchars($users['error']));
    }
    $user = findUserById($users, 1);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Profile</title>
</head>
<body>
    <div class="container">
        <nav class="menu">
            <ul class="menu__list">
                <li class="menu__list_item">
                    <a href="" class="menu__list_link">
                        <img src="/images/icons/home.png" alt="home">
                    </a>
                </li>
                <li class="menu__list_item">
                    <a href="" class="menu__list_link">
                        <img src="/images/icons/user.png" alt="user">
                    </a>
                </li>
                <li class="menu__list_item">
                    <a href="" class="menu__list_link">
                        <img src="/images/icons/plus.png" alt="plus">
                    </a>
                </li>
            </ul>
        </nav>
        <?php 
            $userId = null;
            if (isset($_GET['id'])) {
                $userId = filter_var($_GET['id'], FILTER_VALIDATE_INT, [
                    'options' => ['min_range' => 1]
                ]);
            }
            $user = findUserById($users, $userId);
            if (!$user) {
                header('Location: ' . $defaultUrl);
                exit();
            }
        ?>
        <?php include 'templates/profile.php' ?>
    </div>   
</body>
</html>