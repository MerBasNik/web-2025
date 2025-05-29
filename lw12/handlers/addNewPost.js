document.addEventListener('DOMContentLoaded', function() {
    const postText = document.getElementById('postText');
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.multiple = true;
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);
    let countUploadImg = 0;
    let images = [];
    let currentSlide = 0;

    function checkShareButton() {
        if (images.length > 0 && postText.value.trim() !== '') {
            shareBtn.disabled = false;
        } else {
            shareBtn.disabled = true;
        }
    }

    function updateSlider() {
        const slider = document.getElementById('slider');
        slider.innerHTML = '';
        images.forEach((image, imageIndex) => {
            const slide = document.createElement('div');
            slide.className = 'slider__item';
            slide.innerHTML = `<img class="slider__item-img" src="${image.url}" alt="Изображение ${imageIndex + 1}">`;
            slider.appendChild(slide);
        });
        const sliderCounter = document.getElementById('sliderCounter'); 
        if (images.length > 1) {
            sliderCounter.classList.remove('hidden');
            sliderCounter.textContent = `${currentSlide + 1}/${images.length}`;
        } else {
            sliderCounter.classList.add('hidden');
        }

        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    function handleFiles(files) {
        if (files.length === 0) return;

        Array.from(files).forEach(file => {
            if (!file.type.match('image.*')) return; 
            countUploadImg = countUploadImg + 1;    
            const reader = new FileReader();    
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    let width = img.width;
                    let height = img.height;

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    images.push({
                        url: canvas.toDataURL(),
                        file: file,
                        width: width,
                        height: height
                    });

                    const emptyState = document.getElementById('emptyState');
                    const imagesContainer = document.getElementById('imagesContainer');
                    const addMorePhotosImg = document.getElementById('addMorePhotosImg');
                    const addMorePhotosBtn = document.getElementById('addMorePhotosBtn');           
                    if (images.length === 1) {
                        emptyState.classList.add('hidden');
                        imagesContainer.classList.remove('hidden');
                        addMorePhotosBtn.classList.remove('hidden');
                        addMorePhotosImg.classList.remove('hidden');
                    }

                    updateSlider();
                    navigateSlider(true);
                    checkShareButton();
                };
                img.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    }

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        if (countUploadImg <= 10) {
            handleFiles(files);
            fileInput.value = '';
        }  
    });

    postText.addEventListener('input', (e) => {
        checkShareButton(postText);
    });

    async function handleShareButton() {
        const postText = document.getElementById('postText');
        const shareBtn = document.getElementById('shareBtn');
        const userId = document.getElementById('postContainer').dataset.user;

        shareBtn.disabled = true;
        shareBtn.textContent = 'Отправка...';  

        const postData = {
            user_id: userId,
            text: postText.value.trim(),
            images: images,
            time: Math.floor(new Date().getTime() / 1000),
            likes: 0
        };    

        const formData = new FormData();
        formData.append('data', JSON.stringify(postData));

        images.forEach((img, index) => {
            formData.append(`images[${index}]`, img.file);
        });

        const response = await fetch('addApi.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        document.querySelector('.post-create').innerHTML = `
            <div class="success-message">
                Пост успешно сохранен!
            </div>
        `;

        console.log('Новый пост:', postData);
        alert('Пост успешно создан! (см. консоль)');
    };

    function navigateSlider(isNext) {
        const slider = document.getElementById(`slider`);
        const counter = document.getElementById(`sliderCounter`);

        if (!slider || !counter) return;

        const slides = slider.querySelectorAll('.slider__item');
        if (slides.length <= 1) return;

        let currentSlide = parseInt(slider.dataset.current || 0);
        const slidesCount = slides.length;

        currentSlide = isNext 
            ? (currentSlide + 1) % slidesCount
            : (currentSlide - 1 + slidesCount) % slidesCount;

        slider.style.transition = 'transform 0.3s ease';
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        slider.dataset.current = currentSlide;
        counter.textContent = `${currentSlide + 1}/${slidesCount}`;
    }

    document.addEventListener('click', (e) => {
        const shareBtn = e.target.closest('.post-create__share-btn');
        if (shareBtn) {
            handleShareButton();
        }
        const btn = e.target.closest('.control__btn');
        if (btn) {
            const isNext = btn.classList.contains('right-button');
            navigateSlider(isNext);
        }
        const addPhotoBtn = e.target.closest('.empty-state__add-photo-btn');
        if (addPhotoBtn) {
            fileInput.click()
        }
        const addMorePhotosBtn = e.target.closest('.add-more-photos__btn');
        if (addMorePhotosBtn) {
            fileInput.click()
        }    
    });
});


