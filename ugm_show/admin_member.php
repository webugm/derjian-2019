<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
#佈景目錄
$WEB['theme_name'] = "admin";
#網頁標題
$WEB['theme_title'] = "會員管理";

#權限檢查
if($_SESSION['group'] != "admin")redirect_header("index.php", 3000, "您沒有管理員權限！");

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'opList', 'string');
$uid = system_CleanVars($_REQUEST, 'uid', '', 'int');

/* 程式流程 */
switch ($op){
	#ajax檢查email是否重覆
	case "ajaxCheckEmail" :
		ajaxCheckEmail();
		exit;

	#ajax檢查email是否重覆
	case "opDeleteTmp" :
		$msg = opDeleteTmp();
		redirect_header($_SESSION['returnUrl'], 3000, $msg);
		exit;

	#新增會員
	case "signup" :
		$msg = signup();
		redirect_header("admin_member.php", 3000, $msg);
		exit;
	#更新會員	
	case "opUpdate" :
		$msg = opUpdate($uid);
		redirect_header("admin_member.php", 3000, $msg);
		exit;

	#刪除會員
	case "opDelete" :
		$msg = opDelete($uid);
		redirect_header($_SESSION['returnUrl'], 3000, $msg);
		exit;

	#會員表單
	case "opForm" :
		$msg = opForm($uid);
		break;

	#預設動作
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
# 刪除會員
###############################
function opDelete($uid){
	global $db,$WEB;

	#撈會員資料
	$sql = "delete 
					from `{$WEB['moduleName']}_users`
					where `uid`='{$uid}'
	";

	$db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
	return "刪除成功！";
}
###############################
# 會員編輯表單
###############################
function opForm($uid){
	global $smarty,$db;

	#用uid取得個人會員資料
	$row = getUserBYuid($uid) or redirect_header("message.php", 3000, "無此會員({$uid})資料");

	#編輯表單不用過濾
	$smarty->assign("row", $row);

	#取得 token code	
	$token = getTokenHTML();
	$smarty->assign("token", $token);
}


###############################
# 用uid取得個人會員資料
###############################
function getUserBYuid($uid){
	global $smarty,$db,$WEB;

	#撈會員資料
	$sql = "select *
					from `{$WEB['moduleName']}_users`
					where `uid`='{$uid}'
	";
	$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
	$row = $result->fetch_assoc();
	return $row;
}
#################################################
#  新增
#################################################
function opUpdate($uid){
	global $db,$WEB;
	#驗證token
	verifyToken($_POST['token']);
	
	#過濾
	$_POST['uid'] = db_CleanVars($_POST['uid'], "uid");
	$_POST['name'] = db_CleanVars($_POST['name'], "姓名");
	$_POST['email'] = db_CleanVars($_POST['email'], "email", FILTER_VALIDATE_EMAIL);
	$_POST['pass'] = db_CleanVars($_POST['pass'], "");
	$_POST['confirmPass'] = db_CleanVars($_POST['confirmPass'], "");
	$_POST['group'] = db_CleanVars($_POST['group'], "群組");

	#檢查email是否存在
	if(!checkEmail($_POST['email'],$_POST['uid']))redirect_header($_SESSION['returnUrl'], 3000, "這個email已經有人使用了");
	#檢查密碼是否一致
	if($_POST['pass'] != $_POST['confirmPass'])redirect_header($_SESSION['returnUrl'], 3000, "密碼不一致");

	if($_POST['pass']){
		#密碼加密
		$_POST['pass']  = password_hash($_POST['pass'], PASSWORD_DEFAULT);

		#更新資料庫
		$sql = "update `{$WEB['moduleName']}_users` set
						`email` = '{$_POST['email']}',
						`pass` = '{$_POST['pass']}',
						`name` = '{$_POST['name']}',
						`group` = '{$_POST['group']}'
						where `uid` = '{$_POST['uid']}'
						"; //die($sql);

	}else{
		
		#更新資料庫
		$sql = "update `{$WEB['moduleName']}_users` set 
						`email` = '{$_POST['email']}',
						`name` = '{$_POST['name']}',
						`group` = '{$_POST['group']}'
						where `uid` = '{$_POST['uid']}'
						"; //die($sql);
	}
	$db->query($sql) or redirect_header("", 3000, $db->error."\n".$sql ,ture);

	return "編輯會員成功！！";
}

#################################################
#  新增
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

	return "新增會員成功！！";
}
###############################
# 會員列表
###############################
function opList(){
	global $smarty,$db,$WEB;

	#撈會員資料
	$sql = "select *
					from `{$WEB['moduleName']}_users`
					order by `group` desc,`uid`
	";
	$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
	#查詢筆數
	$count = $result->num_rows;
	$rows=[];
	while($row = $result->fetch_assoc()){
		#過濾資料
		$row['uid'] = intval($row['uid']);
		$row['name'] = htmlspecialchars($row['name'], ENT_QUOTES);
		$row['email'] = htmlspecialchars($row['email'], ENT_QUOTES);
		$row['group'] = htmlspecialchars($row['group'], ENT_QUOTES);
		$row['group'] = $row['group'] == "admin" ? "管理員":"會員";
		$rows[] = $row;
	}
	$smarty->assign("rows", $rows);

	#新增會員表單	
	$token = getTokenHTML();
	$smarty->assign("token", $token);

}
