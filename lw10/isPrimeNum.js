function isPrimeNumber(param) {
    if (typeof param != "number" && !Array.isArray(param)) {
        console.error('введенные данные должны быть числом или массивом чисел');
        return false;
    }

    if (typeof param == "number") {
        if (isPrime(param)) {
            console.log(`${param} - простое число`);
        } else {
            console.log(`${param} - не простое число`);
        }
    } else if (Array.isArray(param)) {
        let n = param.length;
        for (let i = 0; i < n; i++) {
            if (typeof param[i] == "number") {
                if (isPrime(param[i])) {
                  console.log(`${param[i]} - простое число`);
                } else {
                  console.log(`${param[i]} - не простое число`);
                }
            } else {
                console.log(`${param[i]} - это не число`);
            }
        }
    }
}

function isPrime(num) {
    if (num < 2) {
        return false;
    }
    for (let i = 2; i <= Math.sqrt(num); i++) {
        if (num % i == 0) {
            return false;
        }
    }
    return true;
}

isPrimeNumber(10);
isPrimeNumber([9]);
isPrimeNumber([2, 3, 4, 5, 6, 7]);
isPrimeNumber("text");
isPrimeNumber(["text"]);
isPrimeNumber();
isPrimeNumber([0]);
