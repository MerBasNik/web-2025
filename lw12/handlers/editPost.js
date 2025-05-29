document.addEventListener('DOMContentLoaded', function() {
    const script = document.querySelector('.post-data');
    const postText = document.getElementById('postText');
    const shareBtn = document.getElementById('shareBtn');
    const fileInput = document.createElement('input');

    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.multiple = true;
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);

    let currentSlide = 0;
    let imagesArr = JSON.parse(script.textContent);
    let countUploadImg = imagesArr.length;
    initSlider(imagesArr);

    function initSlider(imgs) {
        const slider = document.getElementById(`slider__container`);
        const counter = document.getElementById(`sliderCounter`);

        slider.innerHTML = '';
        let images = [];
        images = imgs;
        images.forEach((image, imageIndex) => {
            const slide = document.createElement('div');
            slide.className = 'slider__item';
            slide.innerHTML = `<img class="slider__item-img" src="${image['image_url']}" alt="Изображение ${imageIndex + 1}">`;
            slider.appendChild(slide);
        });

        slider.style.transform = 'translateX(0)';
        counter.textContent = `1/${images.length}`;
    }

    function navigateSlider(isNext) {
        const slider = document.getElementById(`slider__container`);
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

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        if (countUploadImg <= 10) {
            handleFiles(files);
            fileInput.value = '';
        }  
    });

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.control__button');
        if (btn) {
            const isNext = btn.classList.contains('right-button');
            navigateSlider(isNext);
        }
        const shareBtn = e.target.closest('.post-create__share-btn');
        if (shareBtn) {
            handleShareButton();
        }
        const removeBtn = e.target.closest('.slider__remove-img');
        if (removeBtn) {
            removeImage();
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

    function removeImage() {
        const sliderContainer = document.getElementById(`slider__container`);
        if (imagesArr.length != 0) {
            imagesArr.splice(sliderContainer.dataset.current, 1);
            countUploadImg = countUploadImg - 1;
        }
        initSlider(imagesArr);
        if (imagesArr.length == 0) {
            const empryState = document.querySelector('.photos__empty-state');
            const addPhotosBtn = document.querySelector('.photos__add-more-photos');
            const slider = document.getElementById(`slider`);
            empryState.classList.remove('hidden');
            slider.classList.add('hidden');
            addPhotosBtn.classList.add('hidden');
            const sliderCounter = document.getElementById('sliderCounter'); 
            sliderCounter.classList.add('hidden');
            checkShareButton();
        }
    }

    async function handleShareButton() {
        const postText = document.getElementById('postText');
        const shareBtn = document.getElementById('shareBtn');
        const userId = document.getElementById('postContainer').dataset.user;
        const postId = document.getElementById('postContainer').dataset.post;

        shareBtn.disabled = true;
        shareBtn.textContent = 'Отправка...';  

        const postData = {
            post_id: postId,
            user_id: userId,
            text: postText.value.trim(),
            images: [],
            time: Math.floor(new Date().getTime() / 1000),
        };    

        const formData = new FormData();
        imagesArr.forEach((data, index) => {
            if (data['image_url'].length < 100) {
                postData.images.push(data['image_url']);
            } else {
                formData.append(`images[${index}]`, data['file']);
                console.log(data['file'])
            }
        });
        formData.append('data', JSON.stringify(postData));      

        const response = await fetch('editApi.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        document.querySelector('.lenta__item').innerHTML = `
            <div class="success-message">
                Пост успешно сохранен!
            </div>
        `;

        console.log('Новый пост:', postData, formData);
        alert('Пост успешно создан! (см. консоль)');
    };

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

                    imagesArr.push({
                        image_url: canvas.toDataURL(),
                        file: file,
                        width: width,
                        height: height
                    });

                    const emptyState = document.querySelector('.photos__empty-state');
                    const imagesContainer = document.querySelector('.photos__slider');
                    const addMorePhotos = document.querySelector('.add-more-photos');         
                    if (imagesArr.length === 1) {
                        emptyState.classList.add('hidden');
                        imagesContainer.classList.remove('hidden');
                        addMorePhotos.classList.remove('hidden');
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

    function updateSlider() {
        const slider = document.getElementById('slider__container');
        slider.innerHTML = '';
        imagesArr.forEach((image, imageIndex) => {
            const slide = document.createElement('div');
            slide.className = 'slider__item';

            slide.innerHTML = `<img class="slider__item-img" src="${image.image_url}" alt="Изображение ${imageIndex + 1}">`;
            slider.appendChild(slide);
        });
        const sliderCounter = document.getElementById('sliderCounter'); 

        if (imagesArr.length > 1) {
            sliderCounter.classList.remove('hidden');
            sliderCounter.textContent = `${currentSlide + 1}/${imagesArr.length}`;
        } else {
            sliderCounter.classList.add('hidden');
        }

        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    function checkShareButton() {
        if (imagesArr.length > 0 && postText.value.trim() !== '') {
            shareBtn.disabled = false;
        } else {
            shareBtn.disabled = true;
        }
    }
});