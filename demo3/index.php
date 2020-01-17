<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');

/* 程式流程 */
switch ($op){
	case "login" :
		
		$smarty->clearAllCache();
		$msg = login();
		header("location:index.php");//注意前面不可以有輸出
		exit;

	case "logout" :
		unset($_SESSION['admin']);
		setcookie( "token", "", time()- 60 * 60 );
		// clear the entire cache
		$smarty->clearAllCache();
		header("location:index.php");//注意前面不可以有輸出
		exit;

	default:
		$op = "opList";
		opList();
		break;	
}

/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);

/*---- 程式結尾-----*/
$smarty->display('theme.tpl');

/*---- 函數區-----*/
function login(){
	global $smarty,$rowData;
	$_POST['uname'] = filter_var($_POST['uname'], FILTER_VALIDATE_EMAIL);
	$_POST['pass'] = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
	$_POST['remember'] = $_POST['remember'] ? true : false;

	//remember-me
	if($_POST['uname'] == $rowData['uname'] and $_POST['pass'] == $rowData['pass']){
		$_SESSION['admin'] = true;
		if($_POST['remember']){
			setcookie( "token", $rowData['token'], time()+ 60 * 60 ); 
		}
		//setcookie( "admin", true, time()+ 60 * 60 ); //變數為admin，變數值為true，存活時間一小時(3600秒) 

	}else{		
		$_SESSION['admin'] = false;
	}
	//die($_SESSION['admin']);

}
function yyy(){
	global $smarty;
}

function opList(){
	global $smarty;

	//echo dirname(dirname(__DIR__));die();


}

