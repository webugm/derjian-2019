<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
#佈景目錄
$WEB['theme_name'] = "admin";

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'opList', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');


/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);


#指定模版存放目錄
$smarty->template_dir = WEB_PATH . '/templates/' . $WEB['theme_name'] . "/";
#定義模板URL 
$smarty->assign("xoImgUrl", WEB_URL . '/templates/' . $WEB['theme_name']."/"); 
$smarty->assign("xoAppUrl", WEB_URL."/"); 
#除錯開關 
$smarty->assign("debug", false);

/*---- 程式結尾-----*/
$smarty->display('message.tpl');