<div class="lenta__item lenta-item">
    <div class="lenta-item__header">
        <div class="lenta-item__info lenta-info">
            <img class="lenta-info__ava" src="<?= htmlspecialchars($user['avatar']) ?>" alt="avatarka" width="32">
            <p class="lenta-info__name"><?= htmlspecialchars($user['name']) ?></p>
        </div>
        <img src="images/icons/edit.png" alt="edit">
    </div>
    <div class="lenta-item__photo">
        <img class="lenta-item__img" src="<?= htmlspecialchars($post['image']) ?>" alt="img_post" width="474">
        <div class="lenta-item__photo-reaction">
            <img src="images/icons/heart.png" alt="heart">
            <p><?= $post['likes'] ?></p>
        </div>
    </div>
    <p class="lenta-item__text"><?= htmlspecialchars($post['text']) ?></p>
    <p class="lenta-item__time"><?= formatPostTime($post['time']) ?></p>   
</div>