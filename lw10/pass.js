function generatePass(length) {
    if (length < 8) {
        console.error('Пароль должен быть не менее 8 символов');
        return;
    }

    const lowercase = 'abcdefghijklmnopqrstuvwxyz';
    const uppercase = lowercase.toUpperCase();
    const numbers = '0123456789';
    const specials = '!@#$%^&*()_+-=[]{}|;:,.<>?';

    const allChars = lowercase + uppercase + numbers + specials;
    
    let pass = [
        getRandomChar(lowercase),
        getRandomChar(uppercase),
        getRandomChar(numbers),
        getRandomChar(specials),
    ];
    
    while (pass.length < length) {
        pass.push(getRandomChar(allChars));
    }

    const password = shuffleArray(pass).join('');

    console.log(`Пароль длиной ${length}: ${password}`);
}

function getRandomChar(charSet) {
    const randomIndex = Math.floor(Math.random() * charSet.length);
    return charSet[randomIndex];
}

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

generatePass(12); 
generatePass(8); 
generatePass(7); 