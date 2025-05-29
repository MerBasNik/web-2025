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
                    url: canvas.toDataURL('image/jpeg'),
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

function handleShareButton() {
    const postText = document.getElementById('postText');
    const postData = {
        images: images.map(img => ({
            width: img.width,
            height: img.height,
            size: img.file.size,
            type: img.file.type
        })),
        postText: postText.value.trim(),
        createdAt: new Date().toISOString()
    };   
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
