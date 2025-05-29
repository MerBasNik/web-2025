<div class="lenta__item lenta-post" data-user="<?= $userId ?>" data-post="<?= $idPost ?? 0 ?>">
    <div class="lenta-post__header_new header-new hidden">
        <h2>Новый пост</h2>
        <button class="header-new__close-btn">
            <a href="/home?user_id=<?= $userId ?>"><img src="images/icons/arrow_left_new_post.png" alt=""></a>
        </button>
    </div>
    <div class="lenta-post__header_edit header-edit hidden">
        <h2>Редактировать пост</h2>
        <button class="header-edit__close-btn">
            <a href="/home?user_id=<?= $userId ?>" ><img src="images/icons/arrow_left_new_post.png" alt=""></a>
        </button>
    </div>
    <div class="lenta-post__main-header">
        <div class="lenta-post__info post-info">
            <img class="post-info__ava" src="<?= htmlspecialchars($user['avatar']) ?>" alt="avatarka" width="32">
            <p class="post-info__name"><?= htmlspecialchars($user['name']) ?></p>
        </div>
        <a href="/editPost?user_id=<?= $userId ?>&post_id=<?= $idPost ?>" class="lenta-post__edit">
            <img src="images/icons/edit.png" alt="edit">
        </a>
    </div>
    <div class="lenta-post__photos photos">
        <div class="photos__empty-state empty-state hidden" id="emptyState">
            <img src="images/icons/new_photo_template.png" alt="">
            <button class="empty-state__add-photo-btn" id="addPhotoBtn">Добавить фото</button>
        </div>
        <div class="photos__slider slider" id="slider-<?= $userId ?>-<?= $idPost ?>">
            <div class="slider__container" id="slider__container-<?= $userId ?>-<?= $idPost ?>" data-current="0"></div>
            <div class="slider__control control">
                <button class="control__button left-button">
                    <img src="./images/icons/arrow_left.png" alt="">
                </button>
                <button class="control__button right-button">
                    <img src="./images/icons/arrow_right.png" alt="">
                </button>
            </div>
            <div class="slider__counter" id="slider__counter-<?= $userId ?>-<?= $idPost ?>"></div>
        </div>
        <div class="photos__modal-slider modal-slider" id="modal-slider-<?= $userId ?>-<?= $idPost ?>">
            <div class="modal-slider__inner">
                <div class="modal-slider__close">
                    <button class="modal-slider__close-btn">
                        <img src="images/icons/cross.png" alt="">
                    </button>
                </div>
                <div class="modal-slider__container" id="modal-slider__container-<?= $userId ?>-<?= $idPost ?>" data-current="0"></div>
                <div class="modal-slider__control modal-control">
                    <button class="modal-control__button control__button left-button">
                        <img src="./images/icons/arrow_left.png" alt="">
                    </button>
                    <button class="modal-control__button control__button right-button">
                        <img src="./images/icons/arrow_right.png" alt="">
                    </button>
                </div>
                <div class="modal-slider__counter" id="modal-slider__counter-<?= $userId ?>-<?= $idPost ?>"></div>
            </div>
        </div> 
        <div class="lenta-post__photo-reaction">
            <img src="images/icons/heart.png" alt="heart">
            <p><?= $post['likes'] ?></p>
        </div>
    </div>
    <div class="lenta-post__text collapsed" id="lenta-post__text-<?= $userId ?>-<?= $idPost ?>"><?= htmlspecialchars($post['text']) ?></div>
    <button class="lenta-post__show-more-btn" id="showMoreBtn-<?= $userId ?>-<?= $idPost ?>" style="display: none;">ещё</button>
    <p class="lenta-post__time"><?= formatPostTime($post['time']) ?></p>  

    <div class="lenta-post__add-more-photos add-more-photos hidden">
        <img class="add-more-photos__img hidden" id="addMorePhotosImg" src="images/icons/plus_square.png" alt="" width="16">
        <button class="add-more-photos__btn hidden" id="addMorePhotosBtn">Добавить фото</button>
    </div>                 
    <div class="lenta-post__textarea hidden">
        <textarea placeholder="Добавьте подпись..." id="postTextarea"></textarea>
    </div>
    <button class="lenta-post__share-btn hidden" id="shareBtn" disabled>Поделиться</button>  
</div>