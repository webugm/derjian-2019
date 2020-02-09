/*
1. todo list 4
2. 加上一個選項，完成、未完成
3. ()選項1
   ()選項2
   ()選項3
4. 改變某個選項值 為 true || false
   如果是 true => false
   如果是 false => true

*/

var todos = {
  todos : [],//屬性(property) 
  listTodo : function(){
    console.log("()",this.todos);
  },//methods(方法)
  insertTodo : function(item){
    this.todos.push({
      text : item,
      status : false
    });
    this.listTodo();
  },
  updateTodo : function(index,item){
    this.todos[index].text = item;
    this.listTodo();
  },
  deleteTodo : function(index){
    this.todos.splice(index,1);
    this.listTodo();
  },
  toggleTodo : function(index){    
    this.todos[index].status = !this.todos[index].status;
    this.listTodo();
  }
}

/*
todos.listTodo()
todos.insertTodo("在德鍵上課")
todos.insertTodo("要戴口罩")
todos.insertTodo("中午要吃什麼")
todos.updateTodo(0,"買水果")
todos.toggleTodo(0)
todos.deleteTodo(0)
*/