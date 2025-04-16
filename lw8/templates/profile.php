<div class="profilecontainer">
    <div class="profilecontainer__about">
        <img class="profilecontainer__about_ava" src="<?= htmlspecialchars($user['avatar']) ?>" alt="man" width="123">
        <div class="profilecontainer__about_info info">
            <p class="info__name"><?= htmlspecialchars($user['name']) ?></p>
            <p class="info__main"><?= htmlspecialchars($user['about']) ?></p>
        </div>
        <div class="profilecontainer__about_posts aboutpost" >
            <img class="aboutpost__img" src="/images/icons/image.png" alt="image" width="16">
            <p class="aboutpost__count"><?= htmlspecialchars($user['count_posts']) ?> поста</p>
        </div>
    </div>
    
    <div class="profilecontainer__posts">
        <?php foreach ($filteredPosts as $post): ?>
            <div class="profilecontainer__posts_item post">
                <a href="" class="post__link">
                    <img class="profilecontainer__posts_img" src="<?= htmlspecialchars($post['image']) ?>" alt="city" width="150">
                </a>
            </div>
        <?php endforeach; ?>      
    </div>
</div>