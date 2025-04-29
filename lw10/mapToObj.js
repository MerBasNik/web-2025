function mapObject(obj, callback) {
    const result = {};

    for (const key in obj) {
        if (obj.hasOwnProperty(key)) {
            result[key] = callback(obj[key]);
        }
    }

    console.log(result);
}

mapObject({ a: 1, b: 2, c: 3 }, x => x * 2);
mapObject({}, x => x * 2);
mapObject({ a: 4 }, x => x ** 2);
