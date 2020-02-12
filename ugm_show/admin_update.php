<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
#佈景目錄
$WEB['theme_name'] = "admin";
#網頁標題
$WEB['theme_title'] = "網站更新";

#權限檢查
if($_SESSION['group'] != "admin")redirect_header("index.php", 3000, "您沒有管理員權限！");

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'opList', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');

/* 程式流程 */
switch ($op){

	#預設動作
	default:
		$op = "opList";
		opList();
		redirect_header("admin.php", 3000, "更新完成！");
		exit;	
}

/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);

/*---- 引入檔尾----*/
require_once 'foot.php';

/*---- 函數區-----*/
###############################
# 
###############################
function opList(){
  global $db,$WEB;
 
  #檢查資料夾
  mk_dir(WEB_PATH . "/uploads");
  mk_dir(WEB_PATH . "/uploads/debug");
  mk_dir(WEB_PATH . "/uploads/prod");
 
  //-------- 資料表 ------
  #檢查資料表(users)
  if (!chk_isTable("{$WEB['moduleName']}_users")) {
    $sql = "
      CREATE TABLE `{$WEB['moduleName']}_users` (
        `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '使用者編號',
        `name` varchar(255) NOT NULL COMMENT '使用者姓名',
        `email` varchar(255) NOT NULL COMMENT '使用者Email',
        `pass` varchar(255) NOT NULL COMMENT '使用者密碼',
        `group` enum('user','admin') NOT NULL COMMENT '使用者群組',
        PRIMARY KEY (`uid`),
        UNIQUE KEY `email` (`email`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    createTable($sql);
  }
 
  #檢查資料表(ugm_p_prod)
  if (!chk_isTable("{$WEB['moduleName']}_prod")) {
    $sql = "
      CREATE TABLE `{$WEB['moduleName']}_prod` (
      `sn` int(10) unsigned NOT NULL auto_increment comment 'prod_sn',
      `kind` smallint(5) unsigned NOT NULL default 0 comment '分類',
      `title` varchar(255) NOT NULL default '' comment '名稱',
      `summary` text NULL comment '摘要',
      `content` text NULL comment '內容',
      `price` int(10) unsigned NOT NULL comment '價格',
      `amount` int(10) unsigned NOT NULL comment '數量',
      `enable` enum('1','0') NOT NULL default '1' comment '狀態',
      `choice` enum('1','0') NOT NULL default '0' comment '精選',
      `date` int(10) unsigned NOT NULL default 0 comment '建立日期',
      `sort` smallint(5) unsigned NOT NULL default 0 comment '排序',
      `counter` int(10) unsigned NOT NULL default 0 comment '人氣',
      `icon` varchar(255) NOT NULL default ''  comment '圖示',
      PRIMARY KEY  (`sn`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
    ";
    createTable($sql);
  }
 
  #檢查資料表(ugm_p_kind)
  if (!chk_isTable("{$WEB['moduleName']}_kind")) {
    $sql = "
      CREATE TABLE `{$WEB['moduleName']}_kind` (
      `sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sn',
      `ofsn` smallint(5) unsigned NOT NULL DEFAULT 0 COMMENT '父類別',
      `kind` varchar(255) NOT NULL DEFAULT '' COMMENT '分類',
      `title` varchar(255) NOT NULL DEFAULT '' COMMENT '標題',
      `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
      `enable` enum('1','0') NOT NULL DEFAULT '1' COMMENT '狀態',
      `url` varchar(255) NOT NULL DEFAULT '' COMMENT '網址',
      `target` enum('1','0') NOT NULL DEFAULT '0' COMMENT '外連',
      `col_sn` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'col_sn',
      `content` text NULL COMMENT '內容',
      PRIMARY KEY (`sn`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    createTable($sql);
  }
   
  #檢查資料表(ugm_p_files_center)
  if (!chk_isTable("{$WEB['moduleName']}_files_center")) {
    $sql = "
      CREATE TABLE `{$WEB['moduleName']}_files_center` (
      `files_sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
      `col_name` varchar(255) NOT NULL DEFAULT '' COMMENT '欄位名稱',
      `col_sn` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '欄位編號',
      `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
      `kind` enum('img','file') NOT NULL DEFAULT 'img' COMMENT '檔案種類',
      `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '檔案名稱',
      `file_type` varchar(255) NOT NULL DEFAULT '' COMMENT '檔案類型',
      `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '檔案大小',
      `description` text  NULL COMMENT '檔案說明',
      `counter` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '下載人次',
      `original_filename` varchar(255) NOT NULL DEFAULT '' COMMENT '檔案名稱',
      `hash_filename` varchar(255) NOT NULL DEFAULT '' COMMENT '加密檔案名稱',
      `sub_dir` varchar(255) NOT NULL DEFAULT '' COMMENT '檔案子路徑',
      PRIMARY KEY (`files_sn`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    createTable($sql);
  }
}

########################################
# 建立資料表
########################################
function createTable($sql) {
  global $db;
  $db->query($sql) or die(printf("Error: %s <br>" . $sql, $db->sqlstate));
  return true;
}
 
########################################
# 增加欄位
######################################## 
function addColumn($sql) {
  global $db;
  $db->query($sql) or die(printf("Error: %s <br>" . $sql, $db->sqlstate));
  return true;
}
 
########################################
# 檢查某欄位是否存在(欄名,資料表)
########################################
function chk_isColumn($col_name , $tbl_name) {
  global $db;
  if (!$col_name or !$tbl_name) {
    return;
  } 
  //SHOW COLUMNS FROM `show_kind` LIKE 'sn1'
  $sql = "SHOW COLUMNS FROM `{$tbl_name}` LIKE '{$col_name}'";
  $result = $db->query($sql) or die(printf("Error: %s <br>" . $sql, $db->sqlstate));
  if ($result->num_rows) {
    return true;//欄位存在
  }  
  return false; //欄位不存在
} 
########################################
# 檢查資料表是否存在(資料表)
########################################
function chk_isTable($tbl_name) {
  global $db;
  if (!$tbl_name) {
    return;
  } 
  $sql = "SHOW TABLES LIKE '{$tbl_name}'"; //die($sql); 
  $result = $db->query($sql) or die(printf("Error: %s <br>" . $sql, $db->sqlstate)); 
  if ($result->num_rows) {
    return true;//欄位存在
  }  
  return false; //欄位不存在
}
