<div class="lenta__item lenta-post" data-user="<?= $user['user_id'] ?>" data-post="<?= $idPost ?>">
    <div class="lenta-post__header">
        <div class="lenta-post__info post-info">
            <img class="post-info__ava" src="<?= htmlspecialchars($user['avatar']) ?>" alt="avatarka" width="32">
            <p class="post-info__name"><?= htmlspecialchars($user['name']) ?></p>
        </div>
        <img src="images/icons/edit.png" alt="edit">
    </div>
    <div class="lenta-post__photos photos">
        <div class="photos__slider slider" id="slider-<?= $user['user_id'] ?>-<?= $idPost ?>">
            <div class="slider__container" id="slider__container-<?= $user['user_id'] ?>-<?= $idPost ?>" data-current="0"></div>
            <div class="slider__control control">
                <button class="control__button left-button">
                    <img src="./images/icons/arrow_left.png" alt="">
                </button>
                <button class="control__button right-button">
                    <img src="./images/icons/arrow_right.png" alt="">
                </button>
            </div>
            <div class="slider__counter" id="slider__counter-<?= $user['user_id'] ?>-<?= $idPost ?>"></div>
        </div>
        <div class="photos__modal-slider modal-slider" id="modal-slider-<?= $user['user_id'] ?>-<?= $idPost ?>">
            <div class="modal-slider__inner">
                <div class="modal-slider__close">
                    <button class="modal-slider__close-btn">
                        <img src="images/icons/cross.png" alt="">
                    </button>
                </div>
                <div class="modal-slider__container" id="modal-slider__container-<?= $user['user_id'] ?>-<?= $idPost ?>" data-current="0"></div>
                <div class="modal-slider__control modal-control">
                    <button class="modal-control__button control__button left-button">
                        <img src="./images/icons/arrow_left.png" alt="">
                    </button>
                    <button class="modal-control__button control__button right-button">
                        <img src="./images/icons/arrow_right.png" alt="">
                    </button>
                </div>
                <div class="modal-slider__counter" id="modal-slider__counter-<?= $user['user_id'] ?>-<?= $idPost ?>"></div>
            </div>
        </div> 
        <div class="lenta-post__photo-reaction">
            <img src="images/icons/heart.png" alt="heart">
            <p><?= $post['likes'] ?></p>
        </div>
    </div>
    <div class="lenta-post__text collapsed" id="lenta-post__text-<?= $user['user_id'] ?>-<?= $idPost ?>"><?= htmlspecialchars($post['text']) ?></div>
    <button class="lenta-post__show-more-btn" id="showMoreBtn-<?= $user['user_id'] ?>-<?= $idPost ?>" style="display: none;">ещё</button>
    <p class="lenta-post__time"><?= formatPostTime($post['time']) ?></p>   
</div>
