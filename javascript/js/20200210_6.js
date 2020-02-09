/*
1. todo list 6
2. 如果全部完成，則切換為 全部未完成
3. 如果部份完成，則切換為 全部完成
   

*/

var todos = {
  todos : [],//屬性(property) 
  listTodo : function(){
    if(this.todos.length === 0){
      console.log("目前無資料！");
    }
    for(var i=0; i < this.todos.length; i++){
      if(this.todos[i].status === true){
        console.log("()",this.todos[i].text);
      }else{
        console.log("(x)",this.todos[i].text);
      }      
    }    
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
  },
  toggleAllTodo : function(){
    var todosCount = this.todos.length;
    var todosYes = 0;
    for(var i=0; i < todosCount; i++){
      if(this.todos[i].status === true){
        todosYes++;
      }
    }
    if(todosCount === todosYes){
      for(var i=0; i < todosCount; i++){
        this.todos[i].status = false;
      }
    }else{
      for(var i=0; i < todosCount; i++){
        this.todos[i].status = true;
      }
    }
    this.listTodo();
  }
}

/*
todos.listTodo()
todos.insertTodo("待辦事項1")
todos.insertTodo("待辦事項2")
todos.insertTodo("待辦事項3")
todos.insertTodo("待辦事項4")
todos.insertTodo("待辦事項5")
todos.listTodo()
todos.updateTodo(0,"買水果")
todos.toggleTodo(0)
todos.deleteTodo(0)
*/