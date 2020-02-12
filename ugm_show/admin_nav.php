<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
#佈景目錄
$WEB['theme_name'] = "admin";
#網頁標題
$WEB['theme_title'] = "選單管理";
#權限檢查
if(!$_SESSION['isAdmin'])redirect_header("index.php", 3000, "您沒有管理員權限！");

#引入選單物件
include_once WEB_PATH . "/class/ugmKind.php";
 
#取得主要資料庫
$tbl = "{$WEB['moduleName']}_kind";

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'opList', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');
$kind = system_CleanVars($_REQUEST, 'kind', 'menuTop', 'string');
 
#foreign key
$foreign = array(
  "menuTop" => array("title" => "上方選單","stopLevel"=>1),
  "menuFoot" => array("title" => "頁尾選單","stopLevel"=>1)
);

#---- 防呆
if (!in_array($kind, array_keys($foreign))) {
  $kind = "menuTop";
}

#實體化 類別物件
$stopLevel = $foreign[$kind]['stopLevel']; //層數
$moduleName = $WEB['moduleName'];          //專案名稱
//(資料表,分類，層數，父層)
$ugmKind = new ugmKind($tbl, $kind, $stopLevel,$moduleName);//
#---------------------------------
 
#程式流程
switch ($op) {
  //新增資料
  case "opAllInsert":
    $msg = opAllInsert();
    redirect_header($_SESSION['returnUrl'], 3000, $msg);
    exit;
  case "opUpdateSort": //更新排序
    echo opUpdateSort();
  exit;

  case "opSaveDrag": //移動選單儲存
    echo opSaveDrag();
  exit;

  #選單刪除
  case "opDelete" :
    $msg = opDelete($sn);
    redirect_header($_SESSION['returnUrl'], 3000, $msg);
    exit;

  //更新啟用狀態
  case "opUpdateEnable":
    $msg = opUpdateEnable();
    redirect_header($_SESSION['returnUrl'], 3, $msg);
    break;

  //更新啟用狀態
  case "opUpdateTarget":
    $msg = opUpdateTarget();
    redirect_header($_SESSION['returnUrl'], 3, $msg);
    break;
  #ajax拖曳排序
  case "op_ajax_update_sort":
    echo op_ajax_update_sort();
    exit;
    break;
   
  #新增(Create)
  case "opInsert":
    $msg = opInsert();
    redirect_header($_SESSION['returnUrl'], 3000, $msg);
    exit;

  #更新(Update)
  case "opUpdate":
    $msg = opUpdate($sn);
    redirect_header($_SESSION['returnUrl'], 3000, $msg);
    exit;
    break;
   
  #顯示單筆(Read)
  case "op_show":
    op_show($sn);
    break;
   
  #表單
  case "opForm":
    opForm($sn);
    break;
   
  #讀取(Read)
  default:
    $op = "opList";
    $_SESSION['returnUrl'] = getCurrentUrl();
    opList($kind);
    break;
}

/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);

/*---- 引入檔尾----*/
require_once 'foot.php';

###########################################################
#  批次編輯資料
###########################################################
function opAllInsert() {
  global $db, $ugmKind;
  foreach ($_POST['title'] as $sn => $title) {
    $title = db_CleanVars($title, "標題");//選單名稱
    $sn = db_CleanVars($sn, "流水號");//sn
    $url = db_CleanVars($_POST['url'][$sn], "");//網址
    $sql = "update `".$ugmKind->get_tbl()."` set
            `title` = '{$title}' ,
            `url` = '{$url}'
            where sn='{$sn}'";
   
    $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  }
  return "更新所有選單完成！";
}
###########################################
#  自動更新排序
###########################################
function opUpdateSort() {
  global $db, $ugmKind;

  $sort = 1;
  foreach ($_POST['tr'] as $sn) {
    if (!$sn) {
      continue;
    }

    $sql = "update `{$ugmKind->get_tbl()}` set 
            `sort`='{$sort}' 
            where `sn`='{$sn}'";

    $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
    $sort++;
  }
  return "排序完成！！";
}
###########################################
#  移動選單儲存
###########################################
function opSaveDrag() {
  global $db,$ugmKind;
  $ofsn = intval($_POST['ofsn']); //目的
  $sn = intval($_POST['sn']); //來源

  $kind = $ugmKind->get_kind(); //關鍵字
  $tbl = $ugmKind->get_tbl(); //資料表
  $stopLevel = $ugmKind->get_stopLevel(); //層次
  //$ofsn = $ugmKind->get_ofsn(); //父層  

  //return $ugmKind->chk_kind_level_down($sn);
   #檢查選單層次
  $thisLevel = $ugmKind->get_thisLevel($sn);
  $downLevel = $ugmKind->get_downLevel($sn);
  $ofsnLevel = $ugmKind->get_thisLevel($ofsn);

  if (!$sn) {
    #根目錄不可移動
    die("根目錄不可移動 (" . date("Y-m-d H:i:s") . ")");
  } elseif ($ofsn == $sn) {
    #自己移至自己
    die("不能自己移至自己(" . date("Y-m-d H:i:s") . ")");
  } elseif ($ofsnLevel + $downLevel >= $stopLevel) {
    #自己往底層移動或自己底下層數+目的所在層數 > 選單層數
    die("子選單太多，請先將子選單移動！(" . date("Y-m-d H:i:s") . ")");
  }

  $sql = "update `{$tbl}`
          set 
          `ofsn`='{$ofsn}' 
          where `sn`='{$sn}'";

  $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  return "移動選單完成！";
}
###############################
# 刪除選單
###############################
function opDelete($sn){
  global $db,$ugmKind;

  $kind = $ugmKind->get_kind(); //關鍵字
  $tbl = $ugmKind->get_tbl(); //資料表
  $stopLevel = $ugmKind->get_stopLevel(); //層次
  $ofsn = $ugmKind->get_ofsn(); //父層 

  #檢查選單層次
  $downLevel = $ugmKind->get_downLevel($sn);
  if($downLevel)redirect_header($_SESSION['returnUrl'], 3000, "尚有子選單，無法刪除！");

  #刪除商品資料
  $sql = "delete 
          from `{$tbl}`
          where `sn`='{$sn}'
  ";
  $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
 
  return "刪除成功！";
}
###########################################
#  更新啟用
###########################################
function opUpdateEnable() {
  global $db,$ugmKind;
  #過瀘資料
  $_GET['sn'] = db_CleanVars($_GET['sn'], "sn");
  $_GET['enable'] = db_CleanVars($_GET['enable'], "啟用");
  /****************************************************************/
  //更新
  $sql = "update " . $ugmKind->get_tbl() . " set  
          `enable` = '{$_GET['enable']}' 
          where `sn`='{$_GET['sn']}'";
  $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  return "更新啟用狀態成功！";
}

###########################################
#  更新外連
###########################################
function opUpdateTarget() {
  global $db,$ugmKind;
  #過瀘資料
  $_GET['sn'] = db_CleanVars($_GET['sn'], "sn");
  $_GET['target'] = db_CleanVars($_GET['target'], "外連");
  /****************************************************************/
  //更新
  $sql = "update " . $ugmKind->get_tbl() . " set  
          `target` = '{$_GET['target']}' 
          where `sn`='{$_GET['sn']}'";
  $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  return "更新外連狀態成功！";
}
###########################################################
#  新增資料
###########################################################
function opInsert() {
  global $db, $ugmKind;
  #驗證token
  verifyToken($_POST['token']);

  $kind = $ugmKind->get_kind(); //關鍵字
  $tbl = $ugmKind->get_tbl(); //資料表
  $stopLevel = $ugmKind->get_stopLevel(); //層次
  $ofsn = $ugmKind->get_ofsn(); //父層

  $_POST['title'] = db_CleanVars($_POST['title'], "選單名稱");//選單名稱
  $_POST['url'] = db_CleanVars($_POST['url'], "");//網址
  $_POST['kind'] = db_CleanVars($_POST['kind'], "kind");//分類
  $_POST['enable'] = db_CleanVars($_POST['enable'], "啟用");//狀態
  $_POST['target'] = db_CleanVars($_POST['target'], "外連");//狀態
  $_POST['sn'] = db_CleanVars($_POST['sn'], "");//sn
  $_POST['ofsn'] = db_CleanVars($_POST['ofsn'], "ofsn");//ofsn
  //-------------------------------------------------------*/

  #取得排序-----------------------------#
  $sql = "select max(sort) as max_sort
          from `{$tbl}`
          where ofsn='{$_POST['ofsn']}' and kind='{$_POST['kind']}'";

  $result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
          
  list($sort) = $row = $result->fetch_row();
  $sort++;

  #---------寫入-------------------------
  $sql = "insert into `{$tbl}`
          (`ofsn` ,`title` , `enable` , `sort`,`kind`,`url`,`target`)
          values
          ('{$_POST['ofsn']}' , '{$_POST['title']}' ,'{$_POST['enable']}' ,'{$sort}','{$_POST['kind']}','{$_POST['url']}' , '{$_POST['target']}')";
  $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  //取得最後新增資料的流水編號
  //$_POST['sn'] = $db->insert_id;
  return "新增選單->{$_POST['title']} 成功！";
} 
#################################
# 更新資料
#################################
function opUpdate($sn) {
  global $db,$ugmKind;

  #驗證token
  verifyToken($_POST['token']);

  $kind = $ugmKind->get_kind(); //關鍵字
  $tbl = $ugmKind->get_tbl(); //資料表
  $stopLevel = $ugmKind->get_stopLevel(); //層次
  $ofsn = $ugmKind->get_ofsn(); //父層  
  
  #過濾
  $_POST['title'] = db_CleanVars($_POST['title'], "選單名稱");//選單名稱
  $_POST['url'] = db_CleanVars($_POST['url'], "");//網址
  $_POST['kind'] = db_CleanVars($_POST['kind'], "kind");//分類
  $_POST['enable'] = db_CleanVars($_POST['enable'], "啟用");//狀態
  $_POST['target'] = db_CleanVars($_POST['target'], "外連");//狀態
  $_POST['sn'] = db_CleanVars($_POST['sn'], "sn");//sn
  $_POST['ofsn'] = db_CleanVars($_POST['ofsn'], "ofsn");//ofsn

  #檢查選單層次
  $thisLevel = $ugmKind->get_thisLevel($sn);
  $downLevel = $ugmKind->get_downLevel($sn);
  $ofsnLevel = $ugmKind->get_thisLevel($_POST['ofsn']);
  if($_POST['ofsn'] == $_POST['sn'])redirect_header($_SESSION['returnUrl'], 3000, "不能設定自己為父選單");
  if($ofsnLevel + $downLevel >= $stopLevel)redirect_header($_SESSION['returnUrl'], 3000, "子選單太多，請先將子選單移動，再更新！");

  $sql = "update `{$tbl}` set
          `ofsn`  = '{$_POST['ofsn']}',
          `title`  = '{$_POST['title']}',
          `kind`  = '{$_POST['kind']}',
          `enable`  = '{$_POST['enable']}',
          `url`  = '{$_POST['url']}',
          `target`  = '{$_POST['target']}'
          where sn='{$_POST['sn']}'";
  $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  return "編輯選單->{$_POST['title']} 成功！";
}

###############################################################################
#  編輯表單
###############################################################################
function opForm($sn = "") {
  global $db,$smarty,$ugmKind;

  $kind = $ugmKind->get_kind(); //關鍵字
  $tbl = $ugmKind->get_tbl(); //資料表
  $stopLevel = $ugmKind->get_stopLevel(); //層次
  $ofsn = $ugmKind->get_ofsn(); //父層

  //----------------------------------*/
  $_GET['ofsn'] = !isset($_GET['ofsn']) ? 0 : intval($_GET['ofsn']);

  //抓取預設值
  if (!empty($sn)) {
    $row = $ugmKind->get_rowBYsn($sn); 
    $pre = "編輯";
    $row['op'] = "opUpdate";
    //print_r($row);die();
  } else {
    $row = array();
    $pre = "新增";
    $row['op'] = "opInsert";
  }

  $row['formTitle'] = $pre . "選單";
  $row['stopLevel'] = $stopLevel;
  //預設值設定
  //設定「kind_sn」欄位預設值
  $row['sn'] = (!isset($row['sn'])) ? "" : $row['sn'];

  //設定「ofsn」欄位預設值
  $row['ofsn'] = (!isset($row['ofsn'])) ? $_GET['ofsn'] : $row['ofsn'];

  if ($stopLevel > 1) {
    $row['ofsnOption'] = $ugmKind->get_ofsnOption($row['ofsn']);
  }

  //設定「title」欄位預設值
  $row['title'] = (!isset($row['title'])) ? "" : $row['title'];

  //設定「url」欄位預設值
  $row['url'] = (!isset($row['url'])) ? "" : $row['url'];

  //設定「enable」欄位預設值
  $row['enable'] = (!isset($row['enable'])) ? "1" : $row['enable'];

  //設定「target」欄位預設值
  $row['target'] = (!isset($row['target'])) ? "0" : $row['target'];

  //設定「kind」欄位預設值
  $row['kind'] = (!isset($row['kind'])) ? $ugmKind->get_kind() : $row['kind'];

  
  $smarty->assign('row', $row);  
  
  #防止偽造表單
  $token = getTokenHTML();
  $smarty->assign("token", $token);
}
#################################
# 列表程式
#################################
function opList($kind) {
  global $db,$smarty,$foreign,$ugmKind;
  # 預設Foreign key=> system
  # 
  # ----得到foreign key選單 
  $foreignOption = $ugmKind->get_foreignOption($foreign,$kind);
  $foreignForm = "
    <div class='row' style='margin-bottom:10px;'>
      <div class='col-sm-3'>
        <select name='kind' id='kind' class='form-control' onchange=\"location.href='?kind='+this.value\">
          $foreignOption
        </select>
      </div>
    </div>
  ";
  $smarty->assign('foreignForm', $foreignForm);
  $smarty->assign('kind', $kind);
  # ----得到陣列 ----------------------------
  $list = $ugmKind->get_listArr();
  

  $listTitles = array(
    "title" => array("content" => "標題","attr"=>["class" => "text-center col-sm-5"]),
    "url" => array("content" => "網址","attr"=>["class" => "text-center col-sm-3"]),
    "target" => array("content" => "外連","attr"=>["class" => "text-center","style" => "width:2%;"]),
    "enable" => array("content" =>"啟用", "attr"=>["class" => "text-center","style" => "width:2%;"]),
    "function" => array("content" => "功能","attr"=>["class" => "text-center ","style" => "width:10%;"]),
  );

  $smarty->assign("listTitles", $listTitles);

  #內容---------------------------------------------------------#
  $listBodys = array(
    "title" => array("align" => "left"),
    "url" => array("align" => "left"),
    "target" => array("align" => "center"),
    "enable" => array("align" => "center"),
    "function" => array("align" => "center", "btn" => array("edit", "del")), //瀏覽、編輯、刪除
  );

  $listHtml = $ugmKind->get_listHtml($list, $listBodys,"width:55%;");
  $smarty->assign("listHtml", $listHtml);
 
  return;
}