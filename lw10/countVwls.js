function countVowels(str) {
    if (typeof str != "string") {
        console.error('Введеные данные должны быть строкой');
        return 0;
    }

    const vowels = ["а", "е", "ё", "и", "о", "у", "ы", "э", "ю", "я"];
    let count = 0;
    const foundVowels = [];
    str = str.toLowerCase();
    console.log(`${str}`);
    for (const ch of str) {
        if (vowels.includes(ch)) {
            count++;
            foundVowels.push(ch);
        }
    }

    console.log(`${count} гласных: (${foundVowels.join(", ")})`);
}

countVowels("ПРИВЕТ, МИР!");
countVowels("ПрограммированиеABC");
countVowels("12345");
countVowels(123);
countVowels();
