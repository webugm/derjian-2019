/*
1. todos list 1
2. 對資料做 新增、編輯、查詢、刪除
3. 官網：https://developer.mozilla.org/zh-TW/docs/Web/JavaScript
4. 相關指令 https://developer.mozilla.org/zh-TW/docs/Web/JavaScript/Reference/Global_Objects/Array
*/
var todos = ["待辦事項1","待辦事項2","待辦事項3"];

//查詢
console.log(todos);

//新增
todos.push("待辦事項4");
console.log(todos);

//更新
todos[0] = "更新";
console.log(todos);

//刪除
todos.splice(2,1);
console.log(todos);