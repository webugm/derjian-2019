/*
1. todo list 3
2. 物件化
3. 定義物件 var object = {};
*/

var car = {
  color : "紅色",
  displayCar : function(){
    console.log("我的汽車顏色：",this.color);
  }
}
//car.color;
//car.displayCar();

var todos = {
  todos : ["待辦事項1","待辦事項2","待辦事項3"],//屬性(property) 
  listTodo : function(){
    console.log("清單：",this.todos);
  },//methods(方法)
  insertTodo : function(item){
    this.todos.push(item);
    this.listTodo();
  },
  updateTodo : function(index,item){
    this.todos[index] = item;
    this.listTodo();
  },
  deleteTodo : function(index){
    this.todos.splice(index,1);
    this.listTodo();
  }
}

/*
todos.listTodo()
todos.insertTodo("在德鍵上課")
todos.insertTodo("要戴口罩")
todos.updateTodo(2,"買水果")
todos.deleteTodo(3)
*/