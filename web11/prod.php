<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';
 
if($_SESSION['user']['kind'] !== 1)redirect_header("index.php", '您沒有權限', 3000);

/* 過濾變數，設定預設值 */
$op = system_CleanVars($_REQUEST, 'op', 'op_list', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');
// echo $op;die();
 
/* 程式流程 */
switch ($op){
  case "op_delete" :
    $msg = op_delete($sn);
    redirect_header("user.php", $msg, 3000);
    exit;

  case "op_update" :
    $msg = op_insert($sn);
    redirect_header("prod.php", $msg, 3000);
    exit;

  case "op_insert" :
    $msg = op_insert();
    redirect_header("prod.php", $msg, 3000);
    exit;

  case "op_form" :
    $msg = op_form($sn);
    break;
 
  default:
    $op = "op_list";
    op_list();
    break;  
}
/*---- 將變數送至樣版----*/
$smarty->assign("WEB", $WEB);
$smarty->assign("op", $op);
 
/*---- 程式結尾-----*/
$smarty->display('admin.tpl');
 
/*---- 函數區-----*/
function op_delete($sn){
  global $db; 
  $sql="DELETE FROM `prods`
        WHERE `sn` = '{$sn}'
  ";
  $db->query($sql) or die($db->error() . $sql);
  #刪除實體檔案
  return "會員資料刪除成功";
}
function delFilesByKindColsnSort($kind,$col_sn,$sort=1){
  global $db;
  #刪除舊有圖片(實體檔、資料表)
  $file_name = getPordPic($kind,$col_sn,$sort,false);
  if(file_exists($file_name)){
    unlink($file_name);
  }
  
  $sql="DELETE FROM `files`
        WHERE `kind`='{$kind}' and `col_sn`='{$col_sn}' and `sort`='{$sort}'
  ";
  $db->query($sql) or die($db->error() . $sql); 
}

function op_insert($sn=""){
  global $db;
  
  $_POST['sn'] = db_filter($_POST['sn'], ''); 
  $_POST['title'] = db_filter($_POST['title'], '標題');
  $_POST['date'] = db_filter($_POST['date'], '');//日期
  $_POST['date'] = strtotime($_POST['date']);

  $_POST['enable'] = db_filter($_POST['enable'], '狀態');
  $_POST['kind_sn'] = db_filter($_POST['kind_sn'], '類別');
  $_POST['price'] = db_filter($_POST['price'], '');//價格
  $_POST['sort'] = db_filter($_POST['sort'], '');//排序
  $_POST['counter'] = db_filter($_POST['counter'], '');//計數器  
  $_POST['content'] = db_filter($_POST['content'], '');//內容
  
  if($sn){
    $sql="UPDATE  `prods` SET
                  `kind_sn` = '{$_POST['kind_sn']}',
                  `title` = '{$_POST['title']}',
                  `content` = '{$_POST['content']}',
                  `price` = '{$_POST['price']}',
                  `enable` = '{$_POST['enable']}',
                  `date` = '{$_POST['date']}',
                  `sort` = '{$_POST['sort']}',
                  `counter` = '{$_POST['counter']}'
                  WHERE `sn` = '{$_POST['sn']}'
    ";
    $db->query($sql) or die($db->error() . $sql);
    
    $msg = "商品資料編輯成功";
  }else{
    $sql="INSERT INTO `prods` 
          (`kind_sn`, `title`, `content`, `price`, `enable`, `date`, `sort`, `counter`)
          VALUES 
          ('{$_POST['kind_sn']}', '{$_POST['title']}', '{$_POST['content']}', '{$_POST['price']}', '{$_POST['enable']}', '{$_POST['date']}', '{$_POST['sort']}', '{$_POST['counter']}') 
    ";//die($sql);

    $db->query($sql) or die($db->error() . $sql);
    $sn = $db->insert_id;

    $msg = "商品資料新增成功";
  }
  
  #上傳檔案
  if($_FILES['prod']['name']){
    if ($_FILES['prod']['error'] === UPLOAD_ERR_OK){
      if($_POST['sn']){
        #刪除舊有圖片(實體檔、資料表)
        $file_name = getPordPic("prod",$_POST['sn'],1,false);
        if(file_exists($file_name)){
          unlink($file_name);
        }
        
        $sql="DELETE FROM `files`
              WHERE `kind`='prod' and `col_sn`='{$_POST['sn']}' and `sort`='1'
        ";
        $db->query($sql) or die($db->error() . $sql);        
      }

      $_FILES['prod']['name'] = db_filter($_FILES['prod']['name'], 'name');
      $_FILES['prod']['type'] = db_filter($_FILES['prod']['type'], 'type');
      $_FILES['prod']['size'] = db_filter($_FILES['prod']['size'], 'size');
      //$_FILES['prod']['tmp_name']= db_filter($_FILES['prod']['tmp_name'], 'tmp_name');
      
      $rand = substr(md5(uniqid(mt_rand(), 1)), 0, 5);//取得一個5碼亂數
      #//取得上傳檔案的副檔名
      $ext = pathinfo($_FILES["prod"]["name"], PATHINFO_EXTENSION); 
      $ext = strtolower($ext);//轉小寫
      
      //判斷檔案種類
      if ($ext == "jpg" or $ext == "jpeg" or $ext == "png" or $ext == "gif") {
        $file_kind = "img";
      } else {
        $file_kind = "file";
      }      
      
      $sub_dir = "/prod";
      $new_filename = $rand ."_". $sn .".".$ext;      
      
      #檢查上傳資料夾
      mk_dir(_WEB_PATH."/uploads");
      mk_dir(_WEB_PATH."/uploads{$sub_dir}");

      # 將檔案移至指定位置
      $uploaded = move_uploaded_file($_FILES['prod']['tmp_name'], _WEB_PATH . "/uploads{$sub_dir}/" . $new_filename );

      if($uploaded){
        $sql="INSERT INTO `files` 
              (`kind`, `col_sn`, `sort`, `file_kind`, `file_name`, `file_type`, `file_size`, `description`, `counter`, `name`, `download_name`, `sub_dir`)
              VALUES 
              ('prod', '{$sn}', '1', '{$file_kind}', '{$_FILES['prod']['name']}', '{$_FILES['prod']['type']}', '{$_FILES['prod']['size']}', '', '0', '{$new_filename}', '','{$sub_dir}');
        ";//die($sql);    
        $db->query($sql) or die($db->error() . $sql);
      }       
    } else {
      die("檔案上傳失敗：" . $_FILES['prod']['error']);
    }

  }

  return $msg;

}
/*=====================
  取得商品排序最大值
=====================*/
function getProdsSort(){
  global $db;
  $sql="SELECT max(`sort`)+1 as sort
        FROM `prods`
  ";//die($sql);
  
  $result = $db->query($sql) or die($db->error() . $sql);
  $row = $result->fetch_assoc(); 
  return $row['sort'];
}

/*=====================
  用sn取得商品資料
=====================*/
function getProdsBySn($sn){
  global $db;
  $sql="SELECT *
        FROM `prods`
        WHERE `sn` = '{$sn}'
  ";//die($sql);
  
  $result = $db->query($sql) or die($db->error() . $sql);
  $row = $result->fetch_assoc(); 
  return $row;
}

function op_form($sn=""){
  global $smarty,$db;

  if($sn){
    $row = getProdsBySn($sn) or die("sn錯誤");
    $row['op'] = "op_update";    
    $row['prod'] = getPordPic("prod",$row['sn'],1);
  }else{
    $row['op'] = "op_insert";
    $row['prod'] = "";
  }

  #初始值
  $row['sn'] = isset($row['sn']) ? $row['sn'] : "";
  $row['kind_sn'] = isset($row['kind_sn']) ? $row['kind_sn'] : "1";
  $row['title'] = isset($row['title']) ? $row['title'] : "";
  $row['content'] = isset($row['content']) ? $row['content'] : "";
  $row['price'] = isset($row['price']) ? $row['price'] : "";
  $row['enable'] = isset($row['enable']) ? $row['enable'] : "1";

  $row['date'] = isset($row['date']) ? $row['date'] : strtotime("now");  
  $row['date'] = date("Y-m-d H:i",$row['date']);//格式化

  $row['sort'] = isset($row['sort']) ? $row['sort'] : getProdsSort();
  $row['counter'] = isset($row['counter']) ? $row['counter'] : 0;
  

  #送變數至樣板
  $smarty->assign("row",$row);
}

function getPordPic($kind,$col_sn,$sort=1,$url=true){
  global $db;
  $sql = "SELECT *
          FROM `files`
          WHERE `kind`='{$kind}' and `col_sn`='{$col_sn}' and `sort`='{$sort}'
  ";//die($sql);
  $result = $db->query($sql) or die($db->error() . $sql);
  $row = $result->fetch_assoc();
  if($row){  
    if($url){
      $file_name = _WEB_URL . "/uploads{$row['sub_dir']}/".$row['name'];
    }else{
      $file_name = _WEB_PATH . "/uploads{$row['sub_dir']}/".$row['name'];
    }
  }else{
    $file_name = "";
  }
  return $file_name;
}

function op_list(){
  global $smarty,$db;
  
  $sql = "SELECT *
          FROM `prods`
  ";//die($sql);

  $result = $db->query($sql) or die($db->error() . $sql);
  $rows=[];//array();
  $kind = "prod";
  while($row = $result->fetch_assoc()){
    $row['sn'] = (int)$row['sn'];//整數
    $row['kind_sn'] = (int)$row['kind_sn'];//整數
    $row['title'] = htmlspecialchars($row['title']);//字串
    $row['price'] = (int)$row['price'];//整數
    $row['enable'] = (int)$row['enable'];//整數
    $row['counter'] = (int)$row['counter'];//整數
    $row['pord'] = getPordPic($kind,$row['sn'],1);

    $rows[] = $row;
  }
  $smarty->assign("rows",$rows);  

}



