document.querySelectorAll('.post-data').forEach(script => {
    const userId = parseInt(script.dataset.user);
    const postId = parseInt(script.dataset.post); 
    const images = JSON.parse(script.textContent);
    initSlider(userId, postId, images);
    checkTextOverflow(userId, postId);
});
        
// Инициализация слайдера для конкретного поста
function initSlider(userIndex, postIndex, imgs) {
    const slider = document.getElementById(`slider__container-${userIndex}-${postIndex}`);
    const counter = document.getElementById(`slider__counter-${userIndex}-${postIndex}`);
    
    // Очищаем слайдер
    slider.innerHTML = '';
    let images = [];
    images = imgs;
    images.forEach((image, imageIndex) => {
        const slide = document.createElement('div');
        slide.className = 'slider__item';
        slide.innerHTML = `<img class="slider__item-img" src="${image['image_url']}" alt="Изображение ${imageIndex + 1}">`;
        slider.appendChild(slide);
    });
    
    // Устанавливаем начальное положение
    slider.style.transform = 'translateX(0)';
    counter.textContent = `1/${images.length}`;
}           
            
document.addEventListener('click', (e) => {
    const lentaPost = e.target.closest('.lenta-post');
    let userId;
    let postId;
    if (lentaPost) {
        userId = parseInt(lentaPost.dataset.user);
        postId = parseInt(lentaPost.dataset.post);
    };

    const btn = e.target.closest('.control__button');
    if (btn) {
        const isNext = btn.classList.contains('right-button');
        navigateSlider(userId, postId, isNext);
    }
    const modalBtn = e.target.closest('.modal-control__button');
    if (modalBtn) {
        const isNext = modalBtn.classList.contains('right-button');
        navigateModalSlider(userId, postId, isNext);
    }
    const trigger = e.target.closest('.slider__container');
    if (trigger) {
        openModal(userId, postId);
    }
    const modalClose = e.target.closest('.modal-slider__close');
    if (modalClose) {
        closeModalHandler();
    }   
    const showMoreBtn = e.target.closest('.lenta-post__show-more-btn');
    if (showMoreBtn) {
        const postText = document.getElementById(`lenta-post__text-${userId}-${postId}`);
        if (postText.classList.contains('collapsed')) {
            postText.classList.remove('collapsed');
            showMoreBtn.textContent = 'свернуть';
        } else {
            postText.classList.add('collapsed');
            showMoreBtn.textContent = 'ещё';
        }
    }    
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModalHandler();
    }
});

function navigateSlider(userIndex, postIndex, isNext) {
    const slider = document.getElementById(`slider__container-${userIndex}-${postIndex}`);
    const counter = document.getElementById(`slider__counter-${userIndex}-${postIndex}`);
    
    if (!slider || !counter) return;
    
    const slides = slider.querySelectorAll('.slider__item');
    if (slides.length <= 1) return;
    
    let currentSlide = parseInt(slider.dataset.current || 0);
    const slidesCount = slides.length;
    
    // Вычисляем новый индекс
    currentSlide = isNext 
        ? (currentSlide + 1) % slidesCount
        : (currentSlide - 1 + slidesCount) % slidesCount;
    
    // Анимация перехода
    slider.style.transition = 'transform 0.3s ease';
    slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    slider.dataset.current = currentSlide;
    
    // Обновляем счетчик
    counter.textContent = `${currentSlide + 1}/${slidesCount}`;
}



// Открытие модального окна
function openModal(userId, postId) {
    const postData = document.querySelector(`.post-data[data-user="${userId}"][data-post="${postId}"]`);
    if (!postData) return;
    const currentModalImages = JSON.parse(postData.textContent);
    console.log(currentModalImages);
    
    initModalImages(currentModalImages, userId, postId);
    const modalSlider = document.getElementById(`modal-slider-${userId}-${postId}`);
    modalSlider.classList.add('modal-slider_active');
    modalSlider.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Закрытие модального окна
function closeModalHandler() {
    const modalSlider = document.querySelector(`.modal-slider_active`);
    modalSlider.classList.remove('modal-slider_active');
    modalSlider.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Рендер изображений в модальном окне
function initModalImages(currentModalImages, userIndex, postIndex) {
    const slider = document.getElementById(`slider__container-${userIndex}-${postIndex}`);
    const modalSlider = document.getElementById(`modal-slider__container-${userIndex}-${postIndex}`);
    const modalCounter = document.getElementById(`modal-slider__counter-${userIndex}-${postIndex}`);
    modalSlider.innerHTML = '';
    currentModalImages.forEach((image, imageIndex) => {
        const slide = document.createElement('div');
        slide.className = 'modal-slider__item';
        slide.innerHTML = `<img class="modal-slider__item-img" src="${image['image_url']}" alt="Изображение ${imageIndex + 1}">`;
        modalSlider.appendChild(slide);
    });
    // Устанавливаем начальное положение
    let currentSlide = parseInt(slider.dataset.current || 0);
    modalCounter.textContent = `${currentSlide + 1} из ${currentModalImages.length}`;
    modalSlider.style.transition = 'transform 0.3s ease';
    modalSlider.style.transform = `translateX(-${currentSlide * 100}%)`;
    modalSlider.dataset.current = currentSlide;   
}

function navigateModalSlider(userIndex, postIndex, isNext) {
    const counter = document.getElementById(`slider__counter-${userIndex}-${postIndex}`);
    const slider = document.getElementById(`slider__container-${userIndex}-${postIndex}`);
    const modalSlider = document.getElementById(`modal-slider__container-${userIndex}-${postIndex}`);
    const modalCounter = document.getElementById(`modal-slider__counter-${userIndex}-${postIndex}`);
    
    if (!modalSlider || !modalCounter) return;   
    const slides = modalSlider.querySelectorAll('.modal-slider__item');
    if (slides.length <= 1) return;

    let currentSlide = parseInt(modalSlider.dataset.current || 0);
    const slidesCount = slides.length;
    
    // Вычисляем новый индекс
    currentSlide = isNext 
        ? (currentSlide + 1) % slidesCount
        : (currentSlide - 1 + slidesCount) % slidesCount;
    
    // Анимация перехода
    modalSlider.style.transition = 'transform 0.3s ease';
    modalSlider.style.transform = `translateX(-${currentSlide * 100}%)`;
    slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    modalSlider.dataset.current = currentSlide;  
    slider.dataset.current = currentSlide;
    // Обновляем счетчик
    modalCounter.textContent = `${currentSlide + 1} из ${slidesCount}`;
    counter.textContent = `${currentSlide + 1}/${slidesCount}`;
}
            
// Проверяем, нужно ли показывать кнопку "ещё"
function checkTextOverflow(userIndex, postIndex) {
    const showMoreBtn = document.getElementById(`showMoreBtn-${userIndex}-${postIndex}`);               
    const postText = document.getElementById(`lenta-post__text-${userIndex}-${postIndex}`);
    // Получаем высоту текста в развернутом состоянии
    postText.classList.remove('collapsed');
    const fullHeight = postText.scrollHeight;
    
    // Получаем высоту текста в свернутом состоянии (2 строки)
    postText.classList.add('collapsed');
    const collapsedHeight = postText.clientHeight;
    
    // Если текст занимает больше 2 строк, показываем кнопку
    if (fullHeight > collapsedHeight) {
        showMoreBtn.style.display = 'inline-block';
    } else {
        showMoreBtn.style.display = 'none';
        postText.classList.remove('collapsed');
    }
}
