<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');

/* 程式流程 */
switch ($op){
	case "xxx" :
		$msg = xxx();
		header("location:index.php");//注意前面不可以有輸出
		exit;

	case "yyy" :
		$msg = yyy();
		header("location:index.php");//注意前面不可以有輸出
		exit;

	default:
		$op = "op_list";
		op_list();
		break;	
}

/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);

/*---- 程式結尾-----*/
$smarty->display('theme.tpl');

/*---- 函數區-----*/
function xxx(){
	//global $smarty;

}
function yyy(){
	//global $smarty;
}

function op_list(){
	global $smarty;
}

