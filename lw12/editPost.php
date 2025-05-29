<?php
    require_once 'data_load.php';
    require_once 'validation.php';
    require_once 'post.php';

    $defaultUrl = 'home';
    $connection = connectDatabase();
    $userId = isset($_GETId) ? (int)$_GETId : 1;
    $postId = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 1;

    $user = findUserInDatabase($connection, $userId);
    $post = findPostInDatabase($connection, $postId);
    $post_images = findPostImagesByPostId($connection, $postId); 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="styles/addNewPost.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/home.css">
</head>
<body>
    <div class="post-container" id="postContainer" data-user="<?= $userId ?>" data-post="<?= $postId ?>">
        <div class="post__header">
            <h2>Редактировать пост</h2>
            <button class="post__header-close-btn">
                <a href="/home?user_id=<?= $userId ?>" ><img src="images/icons/arrow_left_new_post.png" alt=""></a>
            </button>
        </div>
        <div class="lenta__item lenta-post">     
            <div class="lenta-post__photos photos">
                <div class="photos__empty-state empty-state hidden" id="emptyState">
                    <img src="images/icons/new_photo_template.png" alt="">
                    <button class="empty-state__add-photo-btn" id="addPhotoBtn">Добавить фото</button>
                </div>
                <div class="photos__slider slider" id="slider">
                    <button class="slider__remove-img">
                        <img src="./images/icons/cross.png" alt="">
                    </button>
                    <div class="slider__container" id="slider__container" data-current="0"></div>
                    <div class="slider__control control">
                        <button class="control__button left-button">
                            <img src="./images/icons/arrow_left.png" alt="">
                        </button>
                        <button class="control__button right-button">
                            <img src="./images/icons/arrow_right.png" alt="">
                        </button>
                    </div>
                    <div class="slider__counter" id="sliderCounter"></div>
                    
                </div>
                <div class="photos__modal-slider modal-slider" id="modal-slider">
                    <div class="modal-slider__inner">
                        <div class="modal-slider__close">
                            <button class="modal-slider__close-btn">
                                <img src="images/icons/cross_modal.png" alt="">
                            </button>
                        </div>
                        <div class="modal-slider__container" id="modal-slider__container-<?= $userId ?>-<?= $postId ?>" data-current="0"></div>
                        <div class="modal-slider__control modal-control">
                            <button class="modal-control__button control__button left-button">
                                <img src="./images/icons/arrow_left.png" alt="">
                            </button>
                            <button class="modal-control__button control__button right-button">
                                <img src="./images/icons/arrow_right.png" alt="">
                            </button>
                        </div>
                        <div class="modal-slider__counter" id="modal-slider__counter-<?= $userId ?>-<?= $postId ?>"></div>
                    </div>
                </div>
                <div class="lenta-post__text hidden" id="lenta-post__text"></div>   
                <div class="photos__add-more-photos add-more-photos">
                    <img class="add-more-photos__img" id="addMorePhotosImg" src="images/icons/plus_square.png" alt="" width="16">
                    <button class="add-more-photos__btn" id="addMorePhotosBtn">Добавить фото</button>
                </div>              
                
                <div class="post-create__text">
                    <textarea placeholder="Добавьте подпись..." id="postText"><?= htmlspecialchars($post['text']) ?></textarea>
                </div>
                
                <button class="post-create__share-btn" id="shareBtn">Сохранить</button>
            </div> 
        </div> 
    </div>

    <script type="application/json" class="post-data">
        <?= json_encode($post_images) ?>
    </script>
    <script src="handlers/editPost.js"></script>
</body>
</html>