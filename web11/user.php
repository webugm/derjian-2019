<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
 
/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'op_form', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');
// echo $op;die();
 
/* 程式流程 */
switch ($op){ 
  case "login" :
    $msg = login();
    header("location:index.php");//注意前面不可以有輸出
    exit;
 
  case "logout" :
    $msg = logout();
    header("location:index.php");//注意前面不可以有輸出
    exit;

  default:
    $op = "op_form";
    op_form();
    break;  
}
 
/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);
 
/*---- 程式結尾-----*/
$smarty->display('user.tpl');
 
/*---- 函數區-----*/
function op_form(){
  global $smarty;
 
}
function login(){
  global $smarty;
  $name="admin";
  $pass="111111";
  $token="xxxxxx";

  if($name == $_POST['name'] and $pass == $_POST['pass']){
    $_SESSION['admin'] = true; 
    if($_POST['remember']){      
      setcookie("name", $name, time()+3600 * 24 * 365);
      setcookie("token", $token, time()+3600 * 24 * 365);
      setcookie("login",true,time()+3600 * 24 * 365);
    }  
    header("location:index.php");//注意前面不可以有輸出
  }else{      
    header("location:user.php");//注意前面不可以有輸出
  }
}

/*===========

===========*/
function logout(){
  $_SESSION['admin'] = false;     
  setcookie("name", "", time()-3600 * 24 * 365);
  setcookie("token", "", time()-3600 * 24 * 365);
  setcookie("login","",time()-3600 * 24 * 365);
} 

function op_list(){
  global $smarty;
}



