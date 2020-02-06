<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
 
/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'login_form', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');
// echo $op;die();
 
/* 程式流程 */
switch ($op){
  case "reg_form" :
    $msg = reg_form();
    break;

  case "reg" :
    $msg = reg();
    header("location:index.php");//注意前面不可以有輸出
    exit; 

  case "logout" :
    $msg = logout();
    header("location:index.php");//注意前面不可以有輸出
    exit; 

  case "login" :
    $msg = login();
    header("location:index.php");//注意前面不可以有輸出
    exit;
 
  default:
    $op = "login_form";
    login_form();
    break;  
}
 
/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);
 
/*---- 程式結尾-----*/
$smarty->display('user.tpl');
 
/*---- 函數區-----*/
function reg_form(){
  global $smarty; 
}

/*=======================
註冊函式(寫入資料庫)
=======================*/
function reg(){
  global $db;
  #過濾變數
  $_POST['uname'] = $db->real_escape_string($_POST['uname']);
  $_POST['pass'] = $db->real_escape_string($_POST['pass']);
  $_POST['chk_pass'] = $db->real_escape_string($_POST['chk_pass']);
  $_POST['name'] = $db->real_escape_string($_POST['name']);
  $_POST['tel'] = $db->real_escape_string($_POST['tel']);
  $_POST['email'] = $db->real_escape_string($_POST['email']);

  #加密
  if($_POST['pass'] == $_POST['chk_pass']){
    $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);//加密  
  }else{
    die("密碼不一致");
  }
  #寫入語法
  $sql="INSERT INTO `users` 
        (`uname`, `pass`, `name`, `tel`, `email`)  
        VALUES 
        ('{$_POST['uname']}', '{$_POST['pass']}', '{$_POST['name']}', '{$_POST['tel']}', '{$_POST['email']}');
  ";
  #寫入資料庫
  $db->query($sql) or die($db->error. $sql);
  $uid = $db->insert_id;
  return $uid;
}

function logout(){
  $_SESSION['admin']="";
  setcookie("name", "", time()- 3600 * 24 * 365); 
  setcookie("token", "", time()- 3600 * 24 * 365);
}

function login_form(){
  global $smarty; 
}

function login(){
  global $smarty;
  $name="admin";
  $pass="111111";
  $token="xxxxxx";

  if($name == $_POST['name'] and $pass == $_POST['pass']){
    $_SESSION['admin'] = true; 
    $_POST['remember'] = isset($_POST['remember']) ? $_POST['remember'] : "";
    
    if($_POST['remember']){
      setcookie("name", $name, time()+ 3600 * 24 * 365); 
      setcookie("token", $token, time()+ 3600 * 24 * 365); 
    }

    header("location:index.php");//注意前面不可以有輸出
  }else{      
    header("location:user.php");//注意前面不可以有輸出
  }
}
 



