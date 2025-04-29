function mapAndFilter(arr) {
    const result = arr.map(num => num * 3).filter(num => num > 10);
    console.log(result)
}

mapAndFilter([1, 2, 3, 4, 5, 6, 7]);
mapAndFilter(['1', '2']);
mapAndFilter([]);
