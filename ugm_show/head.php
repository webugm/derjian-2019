<?php
/*
1. head.php為前台每個程式都會引入的檔案
2. 所有檔案都必須執行的流程，請放到這裡
 */
session_start(); //啟用 $_SESSION,前面不可以有輸出
error_reporting(E_ALL);@ini_set('display_errors', true); //設定所有錯誤都顯示
$http = 'http://';
if (!empty($_SERVER['HTTPS'])) {
	$http = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
}
#網站實體路徑(不含 /)
define('WEB_PATH', str_replace("\\", "/", dirname(__FILE__)));
#網站URL(不含 /)
define('WEB_URL', $http . $_SERVER["HTTP_HOST"] . str_replace($_SERVER["DOCUMENT_ROOT"], "", WEB_PATH));
#--------- WEB -----
#程式檔名(含副檔名)
$WEB['file_name'] = basename($_SERVER['PHP_SELF']); //index.php
//basename(__FILE__)
$WEB['moduleName'] = basename(__DIR__);//ugm_p
$WEB['version'] = "1.0";
// echo __DIR__."<br>";
// echo __FILE__;die();
#除錯
$WEB['debug'] = 0;
#--------- WEB END -----

#
/*---- 必須引入----*/
#引入樣板引擎
require_once WEB_PATH.'/smarty.php';
#引入資料庫設定
require_once WEB_PATH.'/sqlConfig.php';
#引入函數檔
require_once WEB_PATH . '/function.php';


#判斷是否登入	
$_SESSION['isUser'] = isset($_SESSION['isUser']) ? $_SESSION['isUser'] :false;
$_SESSION['isAdmin'] = isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] :false;
$smarty->assign("isUser", $_SESSION['isUser']);
$smarty->assign("isAdmin", $_SESSION['isAdmin']);

#轉向頁面
$_SESSION['redirect']=isset($_SESSION['redirect'])?$_SESSION['redirect']:"";
$redirectFile = WEB_PATH."/class/jGrowl/redirect_header.tpl";
$smarty->assign("redirect", $_SESSION['redirect']);
$smarty->assign("redirectFile", $redirectFile);

$_SESSION['error'] = isset($_SESSION['error'])?$_SESSION['error']:"";
#只有管理員才能看錯誤訊息
$_SESSION['error'] = $_SESSION['isAdmin']?$_SESSION['error']:"程式發生錯誤，請聯絡管理員！";
$smarty->assign("error", $_SESSION['error']);

$_SESSION['redirect']=$_SESSION['error']="";

#網站名稱
$WEB['siteName'] = "台南社區大學10602";