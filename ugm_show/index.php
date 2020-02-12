<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
#佈景目錄
$WEB['theme_name'] = "creative";
#網頁標題
$WEB['theme_title'] = "首頁";


#引入上傳物件
include_once WEB_PATH."/class/ugmUpFiles.php";

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'opList', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');

/* 程式流程 */
switch ($op){
	default:
		$op = "opList";
		$count = 6;
		get_prod($count);
		break;	
}

/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);

/*---- 引入檔尾----*/
require_once 'foot.php';

/*---- 函數區-----*/

###############################
# 商品列表
###############################
function get_prod($count=0){
  global $smarty,$db,$WEB; 

  $limitKey = $count ?"limit {$count}":""; 

  #撈商品資料
  $sql = "select a.sn,a.title,b.title as kind_title
          from `{$WEB['moduleName']}_prod`      as a 
          left join `{$WEB['moduleName']}_kind` as b on a.kind = b.sn
          where a.`enable`='1'
          order by a.`sort` desc
          $limitKey
  ";//die($sql);

  $result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  #查詢筆數
  $count = $result->num_rows;

  #----單檔圖片上傳
  $moduleName = $WEB['moduleName']; //專案名稱
  $subdir = "prod"; //子目錄
  $ugmUpFiles = new ugmUpFiles($moduleName, $subdir);//實體化
  $col_name = "prod";
  #--------------------------------------------------
  $rows=[];
  while($row = $result->fetch_assoc()){
    #過濾資料
    $row['sn'] = intval($row['sn']);
    $row['title'] = htmlspecialchars($row['title'], ENT_QUOTES);
    $row['kind_title'] = htmlspecialchars($row['kind_title'], ENT_QUOTES);

    #----顯示商品縮圖
    $col_sn = $row['sn'];//商品流水號
    $thumb = false ;      //顯示縮圖
    $row['pic'] = $ugmUpFiles->get_rowPicSingleUrl($col_name,$col_sn,$thumb);

    $rows[] = $row;
  }
  $smarty->assign("prodRows", $rows);//送至樣板
}
