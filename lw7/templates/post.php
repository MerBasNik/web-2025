<div class="lenta__item">
    <div class="lenta__item_header">
        <div class="lenta__item_info">
            <img class="lenta__item_ava" src="<?= htmlspecialchars($user['avatar']) ?>" alt="man" width="32">
            <p class="lenta__item_name"><?= htmlspecialchars($user['name']) ?></p>
        </div>
        <img src="images/icons/edit.png" alt="edit">
    </div>
    <div class="lenta__item--photo photo">
        <img class="photo" src="<?= htmlspecialchars($post['image']) ?>" alt="town" width="474">
        <div class="photo__reaction">
            <img src="images/icons/heart.png" alt="heart">
            <p><?= $post['likes'] ?></p>
        </div>
    </div>
    <p class="lenta__item_text"><?= htmlspecialchars($post['text']) ?></p>
    <p class="lenta__item_time"><?= formatPostTime($post['time']) ?></p>   
</div>