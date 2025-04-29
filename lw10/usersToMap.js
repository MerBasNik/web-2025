function GetUsersNames(users) {
    const names = users.map((user) => user.name);
    console.log(names);
}

GetUsersNames([
    { id: 1, name: "Alice" },
    { id: 2, name: "Bob" },
    { id: 3, name: "Charlie" },
]);
GetUsersNames([{}]);
GetUsersNames([]);
