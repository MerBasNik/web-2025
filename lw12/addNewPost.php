<?php
    require_once 'data_load.php';
    require_once 'validation.php';
    require_once 'post.php';

    $defaultUrl = 'home';
    $connection = connectDatabase();
    $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 1;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New post</title>
    <link rel="stylesheet" href="styles/addNewPost.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <div class="post-container" id="postContainer" data-user="<?= $userId ?>">
        <div class="post__header">
            <h2>Новый пост</h2>
            <button class="post__header-close-btn">
                <a href="/home?user_id=<?= $userId ?>"><img src="images/icons/arrow_left_new_post.png" alt=""></a>
            </button>
        </div>
        <div class="post__create post-create">    
            <div class="post-create__images-area images-area">
                <div class="images-area__empty-state empty-state" id="emptyState">
                    <img src="images/icons/new_photo_template.png" alt="">
                    <button class="empty-state__add-photo-btn" id="addPhotoBtn">Добавить фото</button>
                </div>
                
                <div class="images-area__container hidden" id="imagesContainer">
                    <div class="images-area__slider slider" id="slider" data-current="0"></div>                  
                    <div class="images-area__control control">
                        <button class="control__btn left-button">
                            <img src="./images/icons/arrow_left.png" alt="">
                        </button>
                        <button class="control__btn right-button">
                            <img src="./images/icons/arrow_right.png" alt="">
                        </button>
                    </div>                  
                    <div class="images-area__counter hidden" id="sliderCounter"></div>
                </div>
            </div>
                
            <div class="post-create__add-more-photos add-more-photos">
                <img class="add-more-photos__img hidden" id="addMorePhotosImg" src="images/icons/plus_square.png" alt="" width="16">
                <button class="add-more-photos__btn hidden" id="addMorePhotosBtn">Добавить фото</button>
            </div>              
            
            <div class="post-create__text">
                <textarea placeholder="Добавьте подпись..." id="postText"></textarea>
            </div>
            
            <button class="post-create__share-btn" id="shareBtn" disabled>Поделиться</button>           
        </div>
    </div>
    <script src="handlers/addNewPost.js"></script>
</body>
</html>