<?php
//require_once '../../sqlConfig.php';
#取得檔案所在目錄：dirname(__FILE__);
#取得檔案上層目錄：dirname(dirname(__FILE__)); or dirname(__DIR__);
#取得檔案上二層目錄：dirname(dirname(dirname(__FILE__))); or dirname(dirname(__DIR__));

if (!file_exists(dirname(dirname(__DIR__))."/{$WEB['moduleName']}_sqlConfig.php")){
	$fp = file_get_contents("sqlConfig.txt");
	
	$fp = str_replace('{db_name}', $WEB['moduleName'], $fp);

  echo "<meta charset='UTF-8'>";
	echo "請將下方程式碼儲存「". str_replace("\\", "/", dirname(dirname(__DIR__))) . "/{$WEB['moduleName']}_sqlConfig.php」<br>";
	echo "並填入您的MYSQL資料庫的帳號、密碼、資料庫名稱。";
	echo "<hr>";
	echo '<link href="http://cdn.bootcss.com/prettify/r298/prettify.css" rel="stylesheet">';
	echo '<script src="http://cdn.bootcss.com/prettify/r298/prettify.js"></script>';
	echo "<pre class='prettyprint'>";
	echo htmlspecialchars($fp, ENT_QUOTES);
	echo "</pre>";
	exit;
}
include_once dirname(dirname(__DIR__))."/{$WEB['moduleName']}_sqlConfig.php";