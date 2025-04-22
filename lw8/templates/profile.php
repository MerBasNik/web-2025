<div class="profilecontainer">
    <div class="profilecontainer__about profile-about">
        <img class="profile-about__ava" src="<?= htmlspecialchars($user['avatar']) ?>" alt="man" width="123">
        <div class="profile-about__info profile-info">
            <p class="profile-info__name"><?= htmlspecialchars($user['name']) ?></p>
            <p class="profile-info__main"><?= htmlspecialchars($user['about']) ?></p>
        </div>
        <div class="profile-about__post about-post" >
            <img class="about-post__img" src="/images/icons/image.png" alt="image" width="16">
            <p class="about-post__count"><?= htmlspecialchars($user['count_posts']) ?> поста</p>
        </div>
    </div>
    
    <div class="profilecontainer__posts profile-posts">
        <?php foreach ($filteredPosts as $post): ?>
            <div class="profile-posts__item profile-post">
                <a href="" class="profile-post__link">
                    <img class="profile-post__img" src="<?= htmlspecialchars($post['image']) ?>" alt="city" width="150">
                </a>
            </div>
        <?php endforeach; ?>      
    </div>
</div>