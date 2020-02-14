<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
#權限檢查
if(!$_SESSION['admin'])redirect_header("index.php", '您沒有權限', 3000);

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'op_list', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');
// echo $op;die();
 
/* 程式流程 */
switch ($op){

  default:
    $op = "op_list";
    op_list();
    break;  
}
/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);
 
/*---- 程式結尾-----*/
$smarty->display('user.tpl');
 
/*---- 函數區-----*/


 
function op_list(){
  global $smarty,$db;
  $sql="SELECT *
        FROM `users`
        ";
  
  $result = $db->query($sql) or die($db->error() . $sql); 
  $rows=[];
  while($row = $result->fetch_assoc()){
    #過濾資料 數字 (int) 字串 htmlspecialchars($row['xxx'], ENT_QUOTES);
    # $row[''] = (int)$row[''];
    # $row[''] = htmlspecialchars($row[''], ENT_QUOTES);
    $row['uid'] = (int)$row['uid'];
    $row['uname'] = htmlspecialchars($row['uname'], ENT_QUOTES);
    $row['pass'] = htmlspecialchars($row['pass'], ENT_QUOTES);
    $row['name'] = htmlspecialchars($row['name'], ENT_QUOTES);
    $row['tel'] = htmlspecialchars($row['tel'], ENT_QUOTES);
    $row['email'] = htmlspecialchars($row['email'], ENT_QUOTES);
    $row['kind'] = (int)$row['uid'];
    $row['token'] = htmlspecialchars($row['token'], ENT_QUOTES);
    $rows[] = $row;
    $smarty->assign("rows",$rows);
  }     
}



