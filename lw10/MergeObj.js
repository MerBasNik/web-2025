function mergeObjects(obj1, obj2) {
    if (typeof obj1 !== "object" || typeof obj2 !== "object") {
        console.error("Оба аргумента должны быть объектами");
    }

    console.log({
        ...obj1,
        ...obj2,
    });
}

mergeObjects({ a: 1, b: 2 }, { b: 3, c: 4 });
mergeObjects({ x: 10 }, { y: 20 });
mergeObjects({ name: "Alice" }, { name: "Bob", age: 25 });
mergeObjects({}, { key: "value" });
mergeObjects({ key: "value" }, {});
mergeObjects({ key: "value" });
mergeObjects();
