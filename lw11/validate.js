const loginForm = document.getElementById('loginpage-form');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const emailError = document.getElementById('emailError');
const passwordError = document.getElementById('passwordError');
const loginBtn = document.getElementById('loginBtn');

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[^\s]{8,}$/;
    return re.test(password);
}

function resetErrors() {
    emailInput.classList.remove('error');
    passwordInput.classList.remove('error');
    emailError.style.display = 'none';
    passwordError.style.display = 'none';
}

loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    let isValid = true;
    
    resetErrors();
    if (!validateEmail(email)) {
        emailInput.classList.add('error');
        emailError.style.display = 'block';
        isValid = false;
    }
    
    if (!validatePassword(password)) {
        passwordInput.classList.add('error');
        passwordError.style.display = 'block';
        isValid = false;
    }

    if (isValid) {
        console.log('Вход выполнен:', { email, password });
        alert('Вход выполнен успешно!');
    } else {
        console.log('Ошибка входа: неверный email или пароль');
        alert('Ошибка: неверный email или пароль');
    }
});


emailInput.addEventListener('input', function() {
    if (this.classList.contains('error')) {
        this.classList.remove('error');
        emailError.style.display = 'none';
    }
});

passwordInput.addEventListener('input', function() {
    if (this.classList.contains('error')) {
        this.classList.remove('error');
        passwordError.style.display = 'none';
    }
});

const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');
const togglePasswordEye = document.getElementById('togglePasswordEye'); 
togglePassword.addEventListener('click', function (e) {
if (password.getAttribute('type') === 'password') {
    password.setAttribute('type', 'text'); 
    togglePassword.setAttribute('aria-label', 'Скрыть пароль');
} else {
    password.setAttribute('type', 'password');
    togglePassword.setAttribute('aria-label', 'Показать пароль');
}
togglePasswordEye.classList.toggle('fa-eye-slash');
});
