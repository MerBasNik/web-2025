document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', (e) => {
        const lentaPost = e.target.closest('.lenta-post');
        let userId;
        let postId;
        if (lentaPost) {
            userId = parseInt(lentaPost.dataset.user);
            postId = parseInt(lentaPost.dataset.post);
        };

        const btn = e.target.closest('.lenta-post__photo-reaction');
        if (btn) {
            handleBtnLikes(userId, postId);
        }
    })   

    async function handleBtnLikes(userId, postId) {
        try {
            const formData = new FormData();
            formData.append('data', JSON.stringify({user_id: userId, post_id: postId,}));      
            const response = await fetch('likesApi.php', {
                method: 'POST',
                body: formData,
            });       
        
            const result = await response.json();

            if (result.success) {
                const likeCounter = document.getElementById(`lenta-post__photo-reaction-${userId}-${postId}`);
                if (likeCounter) {
                    const likeCounterText = likeCounter.querySelector('.reaction-text');
                    likeCounterText.textContent = result.likesCount;
                    if (likeCounter.classList.contains('active')) {
                        likeCounter.classList.remove('active')
                    } else {
                        likeCounter.classList.add('active')
                    }
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
});