<?php
    require_once 'data_load.php';
    require_once 'validation.php';
    $users = tryLoadJsonData('data/users.json');
    if (isset($users['error'])) {
        die("Ошибка загрузки данных: " . htmlspecialchars($users['error']));
    }

    $filterUserId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    $filteredPosts = [];
    if (isset($users['users']) && is_array($users['users'])) {
        $filteredUsers = array_filter($users['users'], function ($user) use ($filterUserId) {
            return !$filterUserId || $user['user_id'] == $filterUserId;
        });
 
        $filteredPosts = array_reduce($filteredUsers, function ($carry, $user) {
            if (isset($user['posts']) && is_array($user['posts'])) {
                return array_merge($carry, $user['posts']);
            }
            return $carry;
        }, []);
    } else {
        echo "Ошибка: Неверные данные пользователя.";
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Home</title>
</head>
<body>
    <div class="container">
        <nav class="menu">
            <ul class="menu__list">
                <li class="menu__list_item">
                    <a href="" class="menu__list_link">
                        <img src="images/icons/home.png" alt="home">
                    </a>
                </li>
                <li class="menu__list_item">
                    <a href="" class="menu__list_link">
                        <img src="images/icons/user.png" alt="user">
                    </a>
                </li>
                <li class="menu__list_item">
                    <a href="" class="menu__list_link">
                        <img src="images/icons/plus.png" alt="plus">
                    </a>
                </li>
            </ul>
        </nav>

        <div class="lenta">
            <?php foreach ($filteredPosts as $post): ?>
                <?php include 'templates/post.php' ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>