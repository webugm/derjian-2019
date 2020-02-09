/*
1. todos list 2
2. 函數化
3. 
*/

var todos = ["待辦事項1","待辦事項2","待辦事項3"];

//查詢
function listTodo(){
  console.log(todos);
}

//新增
function insertTodo(item){
  todos.push(item);
  listTodo();
}

//更新
function updateTodo(index,item){
  todos[index] = item;
  listTodo();
}

//刪除
function deleteTodo(index,count){  
  todos.splice(index,count);
  listTodo();
}