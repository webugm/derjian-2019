<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
#佈景目錄
$WEB['theme_name'] = "admin";
#網頁標題
$WEB['theme_title'] = "後台管理";


/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'opList', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');

/* 程式流程 */
switch ($op){
	case "opDeleteTmp" :	
		#權限檢查
		if(!$_SESSION['isAdmin'])redirect_header("index.php", 3000, "您沒有管理員權限！");
		$msg = opDeleteTmp();
		redirect_header($_SESSION['returnUrl'], 3000, $msg);
		exit;

	case "signup" :
		$msg = signup();
		redirect_header("index.php", 3000, $msg);
		exit;

	case "ajaxCheckEmail" :
		ajaxCheckEmail();
		exit;

	case "login" :
		$msg = login();
		$target = $_SESSION['isAdmin'] ? "admin.php":"index.php";
		redirect_header($target, 3000, $msg);
		exit;

	case "logout" :
		$msg = logout();
		redirect_header("index.php", 3000, $msg);
		exit;

	case "loginForm" :
		loginForm();
		break;

	case "signupForm" :
		signupForm();
		break;

	default:
		$op = "opList";
		$_SESSION['returnUrl'] = getCurrentUrl();
		opList();
		break;	
}

/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);

/*---- 引入檔尾----*/
require_once 'foot.php';
/*---- 函數區-----*/

###############################
# 清理暫存
###############################
function opDeleteTmp(){
	global $smarty;
	$files = glob($smarty->compile_dir.'*'); // 得到所有編譯檔
	foreach($files as $file){ // iterate files
	  if(is_file($file) and basename($file) !="index.html"){
	    unlink($file); // 刪除檔案
	  }
	}
	return "清理暫存成功！";
}


#################################################
#  註冊
#################################################
function signup(){
	global $db,$WEB;
	#驗證token
	verifyToken($_POST['token']);
	#過濾
	$_POST['name'] = db_CleanVars($_POST['name'], "姓名");
	$_POST['email'] = db_CleanVars($_POST['email'], "email", FILTER_VALIDATE_EMAIL);
	$_POST['pass'] = db_CleanVars($_POST['pass'], "密碼");
	$_POST['confirmPass'] = db_CleanVars($_POST['confirmPass'], "確認密碼");

	#檢查email是否存在
	if(!checkEmail($_POST['email']))redirect_header(WEB_URL, 3000, "這個email已經有人使用了");
	#檢查密碼是否一致
	if($_POST['pass'] != $_POST['confirmPass'])redirect_header(WEB_URL, 3000, "密碼不一致");

	#密碼加密
	$_POST['pass']  = password_hash($_POST['pass'], PASSWORD_DEFAULT);

	#寫進資料庫
	$sql = "insert into `{$WEB['moduleName']}_users` 
	      (`email`,`pass`,`name`) values
	      ('{$_POST['email']}','{$_POST['pass']}','{$_POST['name']}')"; //die($sql);
	$db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
	$uid = $db->insert_id;
	if($uid == 1){		
		#第一次註冊為管理員
		$sql = "update `{$WEB['moduleName']}_users` set 
						`group` = 'admin'
						where `uid` = '{$uid}'
						"; //die($sql);
		$db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
	}
	return "註冊成功！！";
}

#################################################
#  註冊表單
#################################################
function signupForm(){
	global $smarty;
	$token = getTokenHTML();
	$smarty->assign("token", $token);
}


#################################################
#  登入表單
#################################################
function loginForm(){
	global $smarty;
	$token = getTokenHTML();
	$smarty->assign("token", $token);
}

#################################################
#  登入
#################################################
function login(){
	global $db,$WEB;
	#驗證token
	verifyToken($_POST['token']);
	#過濾
	$_POST['email'] = db_CleanVars($_POST['email'], "email", FILTER_VALIDATE_EMAIL);
	$_POST['pass'] = db_CleanVars($_POST['pass'], "密碼");

	#撈出使用者
	
  $sql    = "SELECT * 
  					 FROM `{$WEB['moduleName']}_users` 
  					 where `email`='{$_POST['email']}'";
  $result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  
  $row = $result->fetch_assoc();

  if (password_verify($_POST['pass'], $row['pass'])) {
    $_SESSION['group'] = $row['group'];
    $_SESSION['name']  = htmlspecialchars($row['name'], ENT_QUOTES);
    $_SESSION['uid']   = intval($row['uid']);
    $_SESSION['email'] = htmlspecialchars($row['email'], ENT_QUOTES);
    $_SESSION['isUser'] = true;
    $_SESSION['isAdmin'] = $_SESSION['group'] == "admin" ? true : false;
  } else {  	
    $_SESSION['isUser'] = false;
    $_SESSION['isAdmin'] = false;
  	redirect_header(WEB_URL, 3000, "登入失敗！");
  }
	return "登入成功！";
}

###############################
#  登出
###############################
function logout(){
	unset($_SESSION['group']);
	unset($_SESSION['name']);
	unset($_SESSION['uid']);
	unset($_SESSION['email']);		
  $_SESSION['isUser'] = false;
  $_SESSION['isAdmin'] = false;
	return '您已登出！';
}

###############################
# 預設
###############################
function opList(){
	global $smarty;
}
