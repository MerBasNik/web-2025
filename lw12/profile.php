<?php
    require_once 'data_load.php';
    require_once 'validation.php';
    require_once 'post.php';

    $defaultUrl = 'home';
    $connection = connectDatabase();
    $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 1;

    $user = findUserInDatabase($connection, $userId);
    $postsId = findPostsByUserId($connection, $userId);
    foreach ($postsId as $postId) {
        $post = findPostInDatabase($connection, $postId);
        $filteredPosts[] = $post;
    };
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
                <li class="menu__item menu-item">
                    <a href="/home" class="menu-item__link">
                        <img class="menu-item__img" src="images/icons/home.png" alt="home">
                    </a>
                </li>
                <li class="menu__item menu-item">
                    <a href="/profile" class="menu-item__link">
                        <img class="menu-item__img" src="images/icons/user.png" alt="user">
                    </a>
                </li>
                <li class="menu__item menu-item">
                    <a href="" class="menu-item__link">
                        <img class="menu-item__img" src="images/icons/plus.png" alt="plus">
                    </a>
                </li>
            </ul>
        </nav>
        <?php 
            if (!$user) {
                header('Location: ' . $defaultUrl);
                exit();
            }
        ?>
        <?php include 'templates/profile.php' ?>
    </div>   
</body>
</html>