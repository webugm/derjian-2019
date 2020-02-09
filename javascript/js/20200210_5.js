/*
1. todo list 5
2. 改善顯示介面
3. status true 顯示 (x)選項
   status false 顯示 ()選項   
4. 如果沒有資料，顯示「目前無資料」
5. 顯示資料，可以使用 迴圈for 來撈
6. 判斷有無資料，可用 if 
   

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