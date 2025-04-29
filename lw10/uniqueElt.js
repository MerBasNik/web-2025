function countElements(arr) {
    if (!Array.isArray(arr)) {
        console.error('введеные данные должны быть массивом');
        return {};
    }

    const result = {};

    for (const elt of arr) {
        const key = String(elt);
        if (result.hasOwnProperty(key)) {
            result[key]++;
        } else {
            result[key] = 1;
        }
    }

    return console.log(result);
}

countElements(["a", "b", "a", 1, 2, "1", "2", 2]);
countElements([10, "10", true, false, null, undefined]);
countElements([]);
countElements("");
