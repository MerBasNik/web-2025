<?php
    require_once 'data_load.php';
    require_once 'validation.php';
    require_once 'post.php';
    $defaultUrl = 'home';

    $connection = connectDatabase();
    $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;

    $users = [];
    $filteredPosts = [];
    if (!$userId) {
        $usersId = findUsersInDatabase($connection);
        foreach ($usersId as $userId) {
            $user = findUserInDatabase($connection, $userId);
            $users[] = $user;
        }
    } else {
        $user = findUserInDatabase($connection, $userId);
        if ($user) {
            $users[] = $user;
            $postsId = findPostsByUserId($connection, $user['user_id']);
            foreach ($postsId as $postId) {
                $post = findPostInDatabase($connection, $postId);
                $filteredPosts[] = $post;
            };
        } else {
            header('Location: ' . $defaultUrl);
            exit();
            throw new Exception("Пользователя с таким ID в бд нет");
        }
    };
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
    <script src="slider.js" defer></script>
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

        <div class="lenta">
        <?php foreach ($users as $user): ?>
            <?php
                $userPosts = [];
                $postsId = findPostsByUserId($connection, $user['user_id']);
                foreach ($postsId as $postId) {
                    $post = findPostInDatabase($connection, $postId);
                    $userPosts[] = $post;
             }?> 
                <?php foreach ($userPosts as $postIndex => $post): ?>
                    <?php 
                        $idPost = $postIndex + 1;
                        $post_images = findPostImagesByPostId($connection, $idPost); 
                    ?>
                    <script type="application/json" class="post-data" 
                        data-user="<?= htmlspecialchars($user['user_id']) ?>" 
                        data-post="<?= htmlspecialchars($idPost) ?>">
                        <?= json_encode($post_images) ?>
                    </script>
                    <?php include 'templates/post.php'; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>