<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
#佈景目錄
$WEB['theme_name'] = "admin";
#網頁標題
$WEB['theme_title'] = "商品管理";

#權限檢查
if(!$_SESSION['isAdmin'])redirect_header("index.php", 3000, "您沒有管理員權限！");

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'opList', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');
$kind = system_CleanVars($_REQUEST, 'kind', '', 'int');

#引入上傳物件
include_once WEB_PATH."/class/ugmUpFiles.php";
#引入類別物件
include_once WEB_PATH . "/class/ugmKind.php";


#實體化 類別物件
$kind_tbl = "{$WEB['moduleName']}_kind";   //類別資料表
$kind_key = "prod";                        //商品類別 - 資料表 - 關鍵字 
$stopLevel = 1;                            //商品類別 - 層數(需與 admin_kind.php配合)
$moduleName = $WEB['moduleName'];          //專案名稱
//(資料表,分類，層數，父層)
$ugmKind = new ugmKind($kind_tbl, $kind_key, $stopLevel,$moduleName);
#---------------------------------

/* 程式流程 */
switch ($op){
  #商品新增
  case "opInsert" :
    $msg = opInsert();
    redirect_header($_SESSION['returnUrl'], 3000, $msg);
    exit;

  #商品更新
  case "opUpdate" :
    $msg = opUpdate($sn);
    redirect_header($_SESSION['returnUrl'], 3000, $msg);
    exit;

  #商品刪除
  case "opDelete" :
    $msg = opDelete($sn);
    redirect_header($_SESSION['returnUrl'], 3000, $msg);
    exit;

  #商品表單
  case "opForm" :
    $msg = opForm($sn);
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
# 刪除商品
###############################
function opDelete($sn){
  global $db,$ugmKind,$WEB;

  #刪除商品資料
  $sql = "delete 
          from `{$WEB['moduleName']}_prod`
          where `sn`='{$sn}'
  ";
  $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);  

  #----單檔圖片(刪除)，需 global $ugmKind,$WEB;
  $moduleName = $WEB['moduleName'];                  //專案名稱
  $subdir = $ugmKind->get_kind();                    //子目錄
  $ugmUpFiles = new ugmUpFiles($moduleName, $subdir);//實體化

  $col_name = $ugmKind->get_kind();                  //資料表關鍵字
  $col_sn = $sn;                                     //商品流水號
  $ugmUpFiles->set_col($col_name,$col_sn);           //指定處理標的
  $ugmUpFiles->del_files();                          //刪除檔案
  #-----------------------------------
 
  return "刪除成功！";
}

#################################################
#  商品更新
#################################################
function opUpdate($sn){
  global $db,$ugmKind,$WEB;
  if(!$sn) redirect_header($_SESSION['returnUrl'], 3000, "商品編號錯誤！");
  
  #驗證token
  verifyToken($_POST['token']);

  #過濾
  $_POST['title'] = db_CleanVars($_POST['title'], "商品名稱");
  $_POST['kind'] = db_CleanVars($_POST['kind'], "類別");
  $_POST['price'] = db_CleanVars($_POST['price'], "");//商品價格
  $_POST['amount'] = db_CleanVars($_POST['amount'], "");//商品數量
  $_POST['enable'] = db_CleanVars($_POST['enable'], "啟用");
  $_POST['choice'] = db_CleanVars($_POST['choice'], "精選");
  $_POST['date'] = db_CleanVars($_POST['date'], "建立日期");
  $_POST['date'] = strtotime($_POST['date']);

  $_POST['sort'] = db_CleanVars($_POST['sort'], "排序");
  $_POST['icon'] = db_CleanVars($_POST['icon'], "");//圖示
  $_POST['summary'] = db_CleanVars($_POST['summary'], "");//商品摘要
  $_POST['content'] = db_CleanVars($_POST['content'], "");//商品內容

  #更新資料庫
  $sql = "update `{$WEB['moduleName']}_prod` set 
          `title` = '{$_POST['title']}',
          `kind` = '{$_POST['kind']}',
          `price` = '{$_POST['price']}',
          `amount` = '{$_POST['amount']}',
          `enable` = '{$_POST['enable']}',
          `choice` = '{$_POST['choice']}',
          `date` = '{$_POST['date']}',
          `sort` = '{$_POST['sort']}',
          `icon` = '{$_POST['icon']}',
          `summary` = '{$_POST['summary']}',
          `content` = '{$_POST['content']}'
          where `sn` = '{$sn}'"; //die($sql);
  
  $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);


  #----單檔圖片(上傳)，需 global $ugmKind,$WEB;
  $moduleName = $WEB['moduleName'];                  //專案名稱
  $subdir = $ugmKind->get_kind();                    //子目錄
  $ugmUpFiles = new ugmUpFiles($moduleName, $subdir);//實體化

  $col_name = $ugmKind->get_kind();                  //資料表關鍵字
  $col_sn = $sn;                                     //商品流水號
  $name = "pic";                                     //欄位名稱
  $multiple = false;                                 //單檔 or 多檔上傳
  $main_width = "1280";                              //大圖壓縮尺吋，-1則不壓縮
  $thumb_width = "120";                              //小圖壓縮尺吋
  $ugmUpFiles->upload_file($name,$col_name,$col_sn,$multiple,$main_width,$thumb_width);
  #-----------------------------------
  return "編輯商品成功！！";
  
}

#################################################
#  商品新增
#################################################
function opInsert(){
  global $db,$ugmKind,$WEB;
  #驗證token
  verifyToken($_POST['token']);

  #過濾
  $_POST['title'] = db_CleanVars($_POST['title'], "商品名稱");
  $_POST['kind'] = db_CleanVars($_POST['kind'], "類別");
  $_POST['price'] = db_CleanVars($_POST['price'], "");//商品價格
  $_POST['amount'] = db_CleanVars($_POST['amount'], "");//商品數量
  $_POST['enable'] = db_CleanVars($_POST['enable'], "啟用");
  $_POST['choice'] = db_CleanVars($_POST['choice'], "精選");
  $_POST['date'] = db_CleanVars($_POST['date'], "建立日期");
  $_POST['date'] = strtotime($_POST['date']);

  $_POST['sort'] = db_CleanVars($_POST['sort'], "排序");
  $_POST['icon'] = db_CleanVars($_POST['icon'], "");//圖示
  $_POST['summary'] = db_CleanVars($_POST['summary'], "");//商品摘要
  $_POST['content'] = db_CleanVars($_POST['content'], "");//商品內容

  #寫進資料庫
  $sql = "insert into `{$WEB['moduleName']}_prod`
        (`title`,`kind`,`price`,`amount`,`enable`,`choice`,`date`,`sort`,`icon`,`summary`,`content`) values
        ('{$_POST['title']}','{$_POST['kind']}','{$_POST['price']}','{$_POST['amount']}','{$_POST['enable']}','{$_POST['choice']}','{$_POST['date']}','{$_POST['sort']}','{$_POST['icon']}','{$_POST['summary']}','{$_POST['content']}')"; //die($sql);
  
  $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  $sn = $db->insert_id;

  #----單檔圖片(上傳)，需 global $ugmKind,$WEB;
  $moduleName = $WEB['moduleName'];                  //專案名稱
  $subdir = $ugmKind->get_kind();                    //子目錄
  $ugmUpFiles = new ugmUpFiles($moduleName, $subdir);//實體化

  $col_name = $ugmKind->get_kind();                  //資料表關鍵字
  $col_sn = $sn;                                     //商品流水號
  $name = "pic";                                     //欄位名稱
  $multiple = false;                                 //單檔 or 多檔上傳
  $main_width = "1280";                              //大圖壓縮尺吋，-1則不壓縮
  $thumb_width = "120";                              //小圖壓縮尺吋
  $ugmUpFiles->upload_file($name,$col_name,$col_sn,$multiple,$main_width,$thumb_width);
  #-----------------------------------

  return "新增商品成功！！";
  
}
###############################
# 商品列表
###############################
function opList(){
  global $smarty,$db,$kind,$ugmKind,$WEB; 

  # ----得到foreign key選單 
  $enable=true;
  $foreignOption = $ugmKind->get_kindOption($kind,$enable);
  $foreignForm = "
    <div class='row' style='margin-bottom:10px;'>
      <div class='col-sm-3'>
        <select name='kind' id='kind' class='form-control' onchange=\"location.href='?kind='+this.value\">
          <option value=''>全部</>
          $foreignOption
        </select>
      </div>
    </div>
  ";
  $smarty->assign('foreignForm', $foreignForm);
  $smarty->assign('kind',$kind);
  $whereKey = $kind ?"where `kind`='{$kind}'":"";
  


  #撈商品資料
  $sql = "select *
          from `{$WEB['moduleName']}_prod`
          $whereKey
          order by `sort` desc
  ";//die($sql);

  #----請插入在$sql 與 $result 之間
  include_once WEB_PATH."/class/PageBar.php";
  $pageCount = 10;
  $pageList = 10;
  $PageBar = getPageBar($db, $sql, $pageCount, $pageList);
  $bar     = $PageBar['bar'];
  $sql     = $PageBar['sql'];
  $total   = $PageBar['total'];
  $bar = ($total > $pageCount) ?$bar:"";
  $smarty->assign("bar", $bar);//送至樣板
  #---------------------------------------------------------

  $result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  #查詢筆數
  $count = $result->num_rows;

  #----單檔圖片上傳
  $moduleName = $WEB['moduleName']; //專案名稱
  $subdir = $ugmKind->get_kind(); //子目錄
  $ugmUpFiles = new ugmUpFiles($moduleName, $subdir);//實體化
  $col_name = $ugmKind->get_kind();//資料表關鍵字
  #--------------------------------------------------
  $rows=[];
  while($row = $result->fetch_assoc()){
    #過濾資料
    $row['sn'] = intval($row['sn']);
    $row['kind'] = intval($row['kind']);
    $row['title'] = htmlspecialchars($row['title'], ENT_QUOTES);    
    //$row['summary'] = htmlspecialchars($row['summary'], ENT_QUOTES);    
    //$row['content'] = htmlspecialchars($row['content'], ENT_QUOTES);    
    $row['price'] = intval($row['price']);
    $row['amount'] = intval($row['amount']);
    $row['enable'] = intval($row['enable'])?"<i class='fa fa-check' aria-hidden='true'></i>":"<i class='fa fa-times' aria-hidden='true'></i>";

    $row['choice'] = intval($row['choice'])?"<i class='fa fa-check' aria-hidden='true'></i>":"<i class='fa fa-times' aria-hidden='true'></i>";
    $row['date'] = intval($row['date']);
    $row['date'] = date("Y-m-d",$row['date']);//格式化
    $row['sort'] = intval($row['sort']);
    $row['counter'] = intval($row['counter']);
    $row['icon'] = htmlspecialchars($row['icon'], ENT_QUOTES);

    #----顯示商品縮圖
    $col_sn = $row['sn'];//商品流水號
    $thumb = true ;      //顯示縮圖
    $row['pic'] = $ugmUpFiles->get_rowPicSingleUrl($col_name,$col_sn,$thumb);
    $row['pic'] = "<img src='{$row['pic']}' style='width:80px;' class='img-responsive'>";    
    $row['function'] = "
      <a href='?op=opForm&sn={$row['sn']}' class='btn btn-success btn-xs'>編輯</a>\n
      <button  type='button' class='btn btn-danger btn-xs btnDel'>刪除</button>      
    ";

    $rows[] = $row;
  }
  $smarty->assign("rows", $rows);//送至樣板

  #列表資訊
  $addButton = "<a href='?op=opForm' class='btn btn-primary btn-xs'>新增</a>";  
  $thead = array(
    "pic" => array("content" => "縮圖","attr"=>["class" => "text-center","style"=>"width:6%;"]),
    "date" => array("content" => "日期","attr"=>["class" => "text-center col-sm-1"]),
    "title" => array("content" => "標題","attr"=>["class" => "text-center col-sm-3"]),
    "sort" => array("content" =>"排序", "attr"=>["class" => "text-center","style" => "width:4%;"]),
    "choice" => array("content" =>"精選", "attr"=>["class" => "text-center","style" => "width:2%;"]),
    "enable" => array("content" =>"啟用", "attr"=>["class" => "text-center","style" => "width:2%;"]),
    "function" => array("content" => $addButton,"attr"=>["class" => "text-center col-sm-1"]),
  );  
  $smarty->assign("thead", $thead);

  $tbody = array(
    "pic" => array("attr"=>["class" => "text-center"]),
    "date" => array("attr"=>["class" => "text-center"]),
    "title" => array("attr"=>["class" => "text-left"]),
    "sort" => array("attr"=>["class" => "text-center"]),
    "choice" => array("attr"=>["class" => "text-center"]),
    "enable" => array("attr"=>["class" => "text-center"]),
    "function" => array("attr"=>["class" => "text-center"], "btn" => array("edit", "del")), //瀏覽、編輯、刪除
  );
  
  $smarty->assign("tbody", $tbody);
}
###############################
# 商品表單
###############################
function opForm($sn=""){
  global $db,$smarty,$ugmKind,$WEB;
  if($sn){
    #編輯
    $row = getProd($sn);
    $row['op'] = "opUpdate";
  }else{
    #新增
    $row =array();
    $row['op'] = "opInsert";
  }

  $row['sn'] = isset($row['sn']) ? $row['sn']: "";
  $row['kind'] = isset($row['kind']) ? $row['kind']: ""; 
  # true : enable = 1 才顯示
  $row['kind_options'] = $ugmKind->get_kindOption($row['kind'],true);
  $row['title'] = isset($row['title']) ? $row['title']: "";
  $row['summary'] = isset($row['summary']) ? $row['summary']: "";
  $row['content'] = isset($row['content']) ? $row['content']: "";
  $row['price'] = isset($row['price']) ? $row['price']: 0;
  $row['amount'] = isset($row['amount']) ? $row['amount']: 0;  
  $row['enable'] = isset($row['enable']) ? $row['enable']: "1";
  $row['choice'] = isset($row['choice']) ? $row['choice']: "0";
  #目前日期时间戳記 1970 00:00:00 GMT 的秒數
  $now = strtotime("now");//得到目前網頁伺服器的「时间戳記」
  $row['date'] = isset($row['date']) ? $row['date']: $now;
  $row['date'] = date("Y-m-d",$row['date']);//格式化

  $row['sort'] = isset($row['sort']) ? $row['sort']: getProdMaxSort();
  $row['icon'] = isset($row['icon']) ? $row['icon']: "fa-facebook";

  #----單檔圖片(表單)，需 global $ugmKind,$WEB;
  $moduleName = $WEB['moduleName'];                  //專案名稱
  $subdir = $ugmKind->get_kind();                    //子目錄
  $ugmUpFiles = new ugmUpFiles($moduleName, $subdir);//實體化

  $col_name = $ugmKind->get_kind();                  //資料表關鍵字
  $col_sn = $row['sn'];                              //商品流水號
  $name = "pic";                                     //欄位名稱
  $multiple = false;                                 //單檔 or 多檔上傳
  $accept = "image/*";                               //可接受副檔名
  $row['pic'] = $ugmUpFiles->upform($name,$col_name,$col_sn,$multiple,$accept);
  #-----------------------------------
  $DirName = 'ck';                  //專案名稱
  mk_dir(WEB_PATH . "/uploads/{$DirName}");
  mk_dir(WEB_PATH . "/uploads/{$DirName}/image");
  mk_dir(WEB_PATH . "/uploads/{$DirName}/flash");
  include_once WEB_PATH . "/class/ck.php";
  $fck = new CKEditor($DirName, "content", $row['content']);
  $fck->setHeight(200);
  $row['content'] = $fck->render();

  $smarty->assign("row", $row);
  
  #-----防止偽造表單
  $token = getTokenHTML();
  $smarty->assign("token", $token);
}

###############################
# 商品單筆資訊
###############################
function getProd($sn){
  global $db,$WEB;
  #撈資料
  $sql = "select *
          from `{$WEB['moduleName']}_prod`
          where `sn`='{$sn}'
  ";
  $result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  $row = $result->fetch_assoc();  
  return $row;
}

###############################
# 取得商品最大sort值
###############################
function getProdMaxSort(){
  global $db,$WEB;
  $sql="select max(`sort`)
        from `{$WEB['moduleName']}_prod`
  ";
  $result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
  list($sort) = $result->fetch_row();
  return ++$sort;
}