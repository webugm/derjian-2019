<?php
#指定模版存放目錄
$smarty->template_dir = WEB_PATH . '/templates/' . $WEB['theme_name'] . "/";
#定義模板URL 
$smarty->assign("xoImgUrl", WEB_URL . '/templates/' . $WEB['theme_name']."/"); 
$smarty->assign("xoAppUrl", WEB_URL."/"); 
#除錯開關 
$smarty->assign("debug", false);

#前台
if($WEB['theme_name'] != "admin"){

  # ----得到上方選單 ----------------------------  	
	#引入類別物件
	include_once WEB_PATH . "/class/ugmKind.php";
	#實體化 類別物件
	$tblKey = "{$WEB['moduleName']}_kind";     //選單資料表
	$kindKey = "menuTop";											 //選單關鍵字	
	$stopLevel = 1;                            //層數
	$moduleName = $WEB['moduleName'];          //專案名稱
	//(資料表,分類，層數，父層)
	$ugmKind = new ugmKind($tblKey, $kindKey, $stopLevel,$moduleName);//
	#---------------------------------
	$enable = true;
  $menuTop = $ugmKind->get_listArr(0,1,$enable);
	$smarty->assign("menuTop", $menuTop);
	#-----------------------------------------------
}



/*---- 程式結尾-----*/
$smarty->display('theme.tpl');
/*---- 程式結尾-----*/
