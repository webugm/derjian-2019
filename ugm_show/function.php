<?php
/**
 * Get variables passed by GET or POST method
 *
 * Comment by Taiwen Jiang (a.k.a. phppp): THE METHOD IS NOT COMPLETE AND NOT SAFE. YOU ARE ENCOURAGED TO USE PHP'S NATIVE FILTER_VAR OR FILTER_INPUT FUNCTIONS DIRECTLY BEFORE WE MIGRATE TO XOOPS 3.
 */

###############################
# 檢查users=> email 是否重覆
# Email存在 傳回 false
# 編輯 則將自己 排除
###############################
function checkEmail($email,$uid=''){
  global $db,$WEB;

  $valid = true;

  $andKey = $uid ? " and `uid` != '{$uid}'" :"";

  $sql= "select uid
         from `{$WEB['moduleName']}_users`
         where `email`='{$email}' {$andKey}
  ";
  $result = $db->query($sql);
  if($result){
    list($uid) = $result->fetch_row();
    if($uid){
      $valid = false;
    }
  }
  return $valid;
}

###############################
# 檢查users=> email 是否重覆
# Email存在 傳回 false
###############################
function ajaxCheckEmail(){
  global $db,$WEB;

  $valid = true;
  $_POST['email'] = $db->real_escape_string($_POST['email']);//因為ajax，所以不要轉向
  $_REQUEST['uid'] = isset($_REQUEST['uid'])?intval($_REQUEST['uid']):"";
  $andKey = $_REQUEST['uid'] ? " and `uid` != '{$_REQUEST['uid']}'" :"";
  $sql= "select uid
         from `{$WEB['moduleName']}_users`
         where `email`='{$_POST['email']}' {$andKey} 
  ";
  $result = $db->query($sql);
  
  if($result){
    list($uid) = $result->fetch_row();
    if($uid){
      $valid = false;
    }
  }

  echo json_encode(array(
    'valid' => $valid,
  ));

  // #ajax debug 
  // $myfile = fopen(WEB_PATH."/uploads/debug/debug.txt", "w") ;
  // $txt = $sql."\n";
  // fwrite($myfile, $txt);
  // fclose($myfile);

}

function system_CleanVars(&$global, $key, $default = '', $type = 'int')
{
  switch ($type) {
    case 'array':
      $ret = (isset($global[$key]) && is_array($global[$key])) ? $global[$key] : $default;
      break;
    case 'date':
      $ret = (isset($global[$key])) ? strtotime($global[$key]) : $default;
      break;
    case 'string':
      $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_MAGIC_QUOTES) : $default;
      break;
    case 'int': default:
      $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_NUMBER_INT) : $default;
      break;
  }
  if ($ret === false) {
    return $default;
  }
  return $ret;
}


//檢查並傳回欲拿到資料使用的變數
//$title = '' 則非必填
function db_CleanVars($var, $title = '', $filter = '')
{
  global $db;
  #寫入資料庫過濾
  $var = $db->real_escape_string($var);

  if($title){
    if($var === "")redirect_header(WEB_URL, 3000, $title . '為必填！');
  }

  if ($filter) {
    $var = filter_var($var, $filter);
    if (!$var) {
      redirect_header(WEB_URL, 3000, "不合法的{$title}");
    }
  }
  return $var;
}


###############################################################################
#  轉向函數
###############################################################################
function redirect_header($url = "", $time = 3000, $message = '已轉向！！',$error='') {
  $_SESSION['redirect'] = "\$.jGrowl(\"{$message}\", {  life:{$time} , position: 'center', speed: 'slow' });";
  $_SESSION['error'] = $error ? $message :"";
  $url = $error ? WEB_URL . "/message.php":$url;
  header("location:{$url}");
  exit;
}
###############################################################################
#  取得目前網址
###############################################################################
if (!function_exists("getCurrentUrl")) {
  function getCurrentUrl() {
    global $_SERVER;
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $params = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : "";
 
    $currentUrl = $protocol . '://' . $host . $script . $params;
    return $currentUrl;
  }
}
 
###############################################################################
#  獲得填報者ip
###############################################################################
if (!function_exists("getVisitorsAddr")) {
  function getVisitorsAddr() {
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
      $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
      $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
      $ip = $_SERVER["REMOTE_ADDR"];
    }
    return $ip;
  }
}

#####################################################################################
#  建立目錄
#####################################################################################
if (!function_exists("mk_dir")) {
  function mk_dir($dir = "") {
    #若無目錄名稱秀出警告訊息
    if (empty($dir)) {
      return;
    }
 
    #若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
      umask(000);
      //若建立失敗秀出警告訊息
      mkdir($dir, 0777);
    }
  }
}

#################################################
#  取得token form
#################################################
if (!function_exists("getTokenHTML")) {
  function getTokenHTML() {
    $_SESSION['token'] = substr(md5(uniqid(mt_rand(), 1)), 0, 8);//取得一個亂數

    if (version_compare(PHP_VERSION, '7.0.0') >= 0) {        
      $pass  = password_hash($_SESSION['token'], PASSWORD_DEFAULT);//加密
      return "<input type='hidden' name='token' id='token' value='{$pass}' />";//傳回隱藏token
    } else {
      return "<input type='hidden' name='token' id='token' value='{$_SESSION['token']}' />";//傳回隱藏token
    }
  }
}

#################################################
#  verify token 
#################################################
if (!function_exists("verifyToken")) {
  function verifyToken($hash) {

    if (version_compare(PHP_VERSION, '7.0.0') >= 0) {      
      if (password_verify($_SESSION['token'], $hash)) { //判斷token
        return ;
      }
    } else {
      if ($_SESSION['token'] == $hash){
        return ;
      }
    }
    redirect_header(WEB_URL, 3000, 'token 驗證失敗');
  }
}




