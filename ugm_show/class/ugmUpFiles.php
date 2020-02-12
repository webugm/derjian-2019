<?php
#---------------------------------
defined('WEB_PATH') || die("WEB root path not defined");
class ugmUpFiles {
	public $moduleName; //目錄名稱 「ugm_p」
	public $ugmUpFilesTblName; //資料表名稱creative_files_center

	public $ugmUpFilesDir; //檔案dir
	public $ugmUpFilesUrl; //檔案url
	public $ugmUpFilesImgDir; //圖片dir
	public $ugmUpFilesImgUrl; //圖片url
	public $ugmUpFilesThumbDir; //縮圖dir
	public $ugmUpFilesThumbUrl; //縮圖url

	public $col_name; //資料表欄位
	public $col_sn; //資料表欄位
	public $sort; //資料表欄位
	public $subdir; //子目錄

	public $file_dir = "file";
	public $image_dir = "";
	public $thumbs_dir = "thumbs";

	public $thumb_width = '120px'; #縮圖寬度
	public $thumb_height = '70px'; #縮圖高度
	public $thumb_bg_color = '#000000';
	public $thumb_position = 'center center';
	public $thumb_repeat = 'no-repeat';
	public $thumb_size = 'contain';
	public $multiple = false;
	#建構元(目錄名稱,子目錄,"/檔案","/圖片","/縮圖",$multiple)
	function __construct($moduleName, $subdir) {
		global $db;
		#設定專案名稱
		$this->set_moduleName($moduleName);
		#設定子目錄
		$this->set_subdir($subdir);
		#設定檔案目錄
		$this->set_file_dir();
		#設定檔案目錄
		$this->set_image_dir();
		#設定縮圖目錄
		$this->set_thumbs_dir();
	}

	//刪除實體檔案
	public function del_files($files_sn = "") {
		global $db;

		if (!empty($files_sn)) {
			$del_what = "`files_sn`='{$files_sn}'";
		} elseif (!empty($this->col_name) and !empty($this->col_sn)) {
			$del_what = "`col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}'";
		}

		$sql = "select * from `{$this->ugmUpFilesTblName}`  where $del_what";// die($sql);
		$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);

		while ($row = $result->fetch_assoc()) {
		
			$del_sql = "delete  from `{$this->ugmUpFilesTblName}`  where files_sn='{$row['files_sn']}'"; 
			$db->query($del_sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);


			if ($row['kind'] == "img") {
				unlink($this->ugmUpFilesImgDir.$row['file_name']);
				unlink($this->ugmUpFilesThumbDir.$row['file_name']);
			} else {
				unlink($this->ugmUpFilesDir.$row['file_name']);
			}

		}
	}
	//上傳
	public function upload_file($name,$col_name,$col_sn,$multiple=false,$main_width, $thumb_width) {
		global $db;
		$this->col_name = $col_name;
		$this->col_sn = $col_sn;
		$this->multiple = $multiple;
		$main_width = $main_width ? $main_width :1280;
		$thumb_width = $thumb_width ? $thumb_width :120;

		//引入上傳物件
		include_once WEB_PATH . "/class/upload/class.upload.php";

		//取消上傳時間限制
		set_time_limit(0);
		//設置上傳大小
		//ini_set('memory_limit', '80M');
		ini_set('memory_limit', '-1');

		#---------------------------------------
		//刪除勾選檔案
		if (!empty($_POST["del_{$this->col_name}"])) {
			foreach ($_POST["del_{$this->col_name}"] as $del_files_sn) {
				$this->del_files($del_files_sn);
			}
		}
		#---------------------------------------

		$files = array();
		foreach ($_FILES[$name] as $k => $l) {
			foreach ($l as $i => $v) {
				if (!array_key_exists($i, $files)) {
					$files[$i] = array();
				}
				$files[$i][$k] = $v; //$file[0][name]=xxx.jpg
			}
		}

		//處理檔案上傳，檢查是否有上傳$_FILES[$name]['name'][0]
		if ($files) {
			#有上傳
			foreach ($files as $file) {
				
				//自動排序
				if (empty($this->sort)) {
					$this->sort = $this->auto_sort();
				}

				//取得檔案
				$file_handle = new upload($file, "zh_TW");

				if ($file_handle->uploaded) {
					
					#單檔上傳，先刪舊檔--------------------
					if (!$this->multiple) {
						$this->del_files();
					}
					#---------------------------------------
					//取得副檔名
					$ext = strtolower($file_handle->file_src_name_ext);

					//判斷檔案種類
					if ($ext == "jpg" or $ext == "jpeg" or $ext == "png" or $ext == "gif") {
						$kind = "img";
					} else {
						$kind = "file";
					}

					$file_handle->file_safe_name = false;//會把檔名的空白改為「_」
					$file_handle->file_overwrite = true;//強制覆寫相同檔名
					$file_handle->no_script = false;

    			$rand = substr(md5(uniqid(mt_rand(), 1)), 0, 5);//取得一個5碼亂數
          $new_filename = $rand ."_".$this->col_sn;

					$file_handle->file_new_name_body = $new_filename;//重新設定新檔名
					//print_r($file_handle);die();

					//若是圖片才縮圖 且 $main_width != -1
					if ($kind == "img" and $main_width != "-1") {
						if ($file_handle->image_src_x > $main_width) {
							$file_handle->image_resize = true;                 //要重設圖片大小
							$file_handle->image_x = $main_width;         //設定寬度為 $main_width
							$file_handle->image_ratio_y = true;                // 按比例縮放高度
							//$file_handle->image_convert = 'png';             //轉檔為png格式，方便管理
						}
					}

					$path = ($kind == "img") ? $this->ugmUpFilesImgDir : $this->ugmUpFilesDir;

					$file_handle->process($path);//檔案搬移到目的地
					$file_handle->auto_create_dir = true;
					#------------------------------------------------------

					//若是圖片才製作小縮圖
					if ($kind == "img") {
						$file_handle->file_safe_name = false;
						$file_handle->file_overwrite = true;

						$file_handle->file_new_name_body = $new_filename;
						//echo  $this->$thumb_width;die();

						if ($file_handle->image_src_x > $thumb_width) {
							$file_handle->image_resize = true;
							$file_handle->image_x = $thumb_width;
							$file_handle->image_ratio_y = true;
						}
						$file_handle->process($this->ugmUpFilesThumbDir);
						$file_handle->auto_create_dir = true;
					}
					#------------------------------------------------------

					#------------------------------------------------------
					//上傳檔案
					if ($file_handle->processed) {
						$file_handle->clean();
				
						$sql = "insert into `{$this->ugmUpFilesTblName}`  
										(`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`counter`,`original_filename`,`sub_dir`,`hash_filename`) 
										values
										('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}.{$ext}','{$file['type']}','{$file['size']}','{$file['name']}',0,'{$file['name']}','{$this->subdir}','')"; //die($sql);

						$db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);

					}else{
						redirect_header("", 3000,  "Error:" . $file_handle->error ,true);
					}
				}
				$this->sort = "";
			}

		}

	}

	//列出檔案
	public function list_show_file($del_form = false) {
		global $db;
		$sql = "select * 
						from `{$this->ugmUpFilesTblName}`
            where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}'
            order by sort"; //die($sql);
		$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
		$rows = "";
		while ($row = $result->fetch_assoc()) {
			
			if ($row['kind'] == "file") {
				$thumb_pic = WEB_URL . "/class/upload/downloads.png";
			} else {
				$thumb_pic = $this->ugmUpFilesThumbUrl.$row['file_name'];
			}

			$move = $this->multiple ? "<p><i class='glyphicon glyphicon-move'></i>&nbsp;sort:&nbsp;{$row['sort']}</p>\n" : "";
			#顯示
			$del_checkbox = $del_form ? "
				<p>\n
          <input type='checkbox' name='del_{$this->col_name}[]' value='{$row['files_sn']}' id='del_{$row['files_sn']}'>\n
          <label class='checkbox-inline' for='del_{$row['files_sn']}'>刪除</label>\n
        </p>\n
			" : "";
			$width = $this->multiple ?"3":"12";

			$rows .= "
        <li class='col-sm-{$width}' id='li_{$row['files_sn']}'>
          <div class='thumbnail'>
          	$move
            <img src='{$thumb_pic}' alt='' class='img-responsive'>
            $del_checkbox
          </div>
        </li>";
		}

		$files = "";
		if ($rows) {
			#有撈到資料
			$sortable = $this->multiple ? "
				<link rel='stylesheet' href='" . WEB_URL . "/class/jquery-ui/jquery-ui.min.css' type='text/css' />
				<script src='" . WEB_URL . "/class/jquery-ui/jquery-ui.min.js' type='text/javascript'></script>
	      <script type='text/javascript'>
	        $(document).ready(function(){

	          $('#sort_{$this->col_name}').sortable({ opacity: 0.6, cursor: 'move', update: function() {
	              public order = $(this).sortable('serialize') +
	                          '&op=op_ajax_update_sort&tbl=creative_files_center&key=files_sn&name=li'
	                          ;
	              //alert(order);
	              $.post(
	                '" . $_SERVER['PHP_SELF'] . "',
	                order,
	                function(theResponse){
	                  $('#{$this->col_name}_save_msg').html(theResponse);
	              });
	          }
	          });

	        });
	      </script>
	      <div id='{$this->col_name}_save_msg'></div>
    	" : "";

			$files = "
	      $sortable
	      <div class='row' style='margin-top:5px;'>
	        <ul class='thumbnails' id='sort_{$this->col_name}' style='list-style-type: none;'>
	          $rows
	        </ul>
	      </div>
	    ";
		}

		return $files;
	}	

	//顯示記錄單一網址
	public function get_rowPicSingleUrl($col_name,$col_sn,$thumb) {
		global $db;
		$sql = "select * 
						from `{$this->ugmUpFilesTblName}`
            where `col_name`='{$col_name}' and `col_sn`='{$col_sn}'
            order by sort
            limit 1
            "; //die($sql);
		$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
		$row = $result->fetch_assoc();
		if ($row['kind'] == "file") {
				$thumb_pic = WEB_URL . "/class/upload/downloads.png";
		}else{
			if($thumb){
				$thumb_pic = $this->ugmUpFilesThumbUrl.$row['file_name'];
			}else{					
				$thumb_pic = $this->ugmUpFilesImgUrl.$row['file_name'];
			}			
		}
		return $thumb_pic;
	}

	//表單列出舊圖
	private function upformShow() {
		global $db;
		$sql = "select * 
						from `{$this->ugmUpFilesTblName}`
            where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}'
            order by sort"; //die($sql);
		$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
		$rows = "";
		while ($row = $result->fetch_assoc()) {
			
			if ($row['kind'] == "file") {
				$thumb_pic = WEB_URL . "/class/upload/downloads.png";
			} else {
				$thumb_pic = $this->ugmUpFilesThumbUrl.$row['file_name'];
			}

			$move = $this->multiple ? "<p><i class='glyphicon glyphicon-move'></i>&nbsp;sort:&nbsp;{$row['sort']}</p>\n" : "";
			#顯示
			$del_checkbox = "
				<p>\n
          <input type='checkbox' name='del_{$this->col_name}[]' value='{$row['files_sn']}' id='del_{$row['files_sn']}'>\n
          <label class='checkbox-inline' for='del_{$row['files_sn']}'>刪除</label>\n
        </p>\n
			";
			$width = $this->multiple ?"3":"12";

			$rows .= "
        <li class='col-sm-{$width}' id='li_{$row['files_sn']}'>
          <div class='thumbnail'>
          	$move
            <img src='{$thumb_pic}' alt='' class='img-responsive'>
            $del_checkbox
          </div>
        </li>";
		}

		$files = "";
		if ($rows) {
			#有撈到資料
			$sortable = $this->multiple ? "
				<link rel='stylesheet' href='" . WEB_URL . "/class/jquery-ui/jquery-ui.min.css' type='text/css' />
				<script src='" . WEB_URL . "/class/jquery-ui/jquery-ui.min.js' type='text/javascript'></script>
	      <script type='text/javascript'>
	        $(document).ready(function(){

	          $('#sort_{$this->col_name}').sortable({ opacity: 0.6, cursor: 'move', update: function() {
	              public order = $(this).sortable('serialize') +
	                          '&op=op_ajax_update_sort&tbl=creative_files_center&key=files_sn&name=li'
	                          ;
	              //alert(order);
	              $.post(
	                '" . $_SERVER['PHP_SELF'] . "',
	                order,
	                function(theResponse){
	                  $('#{$this->col_name}_save_msg').html(theResponse);
	              });
	          }
	          });

	        });
	      </script>
	      <div id='{$this->col_name}_save_msg'></div>
    	" : "";

			$files = "
	      $sortable
	      <div class='row' style='margin-top:5px;'>
	        <ul class='thumbnails' id='sort_{$this->col_name}' style='list-style-type: none;'>
	          $rows
	        </ul>
	      </div>
	    ";
		}

		return $files;
	}

	#上傳表單
	public function upform($name='pic',$col_name,$col_sn="",$multiple=false,$accept = "image/*") {
		$this->col_name = $col_name;
		$this->col_sn = $col_sn;
		$this->multiple = $multiple;

		$accept = $accept ? "accept='{$accept}'" : ""; // image/* ,
		$multiple = $multiple ? "multiple='multiple'" : "";
		$show = "";
		if ($col_sn) {
			$show = $this->upformShow();
		}
		$main = "
    <input type='file' name='{$name}[]' $multiple $accept class='form-control'><br>{$show}
    ";
		return $main;
	}

	#設定專案名稱
	public function set_moduleName($moduleName = "") {
		$this->moduleName = $moduleName;		
		#設定資料表
		$this->ugmUpFilesTblName = "{$moduleName}_files_center";
	}

	#設定路徑
	public function set_path() {
		$file_dir = $this->file_dir ?"{$this->file_dir}/":"";
		$image_dir = $this->image_dir ?"{$this->image_dir}/":"";
		$thumbs_dir = $this->thumbs_dir ?"{$this->thumbs_dir}/":"";

		$this->ugmUpFilesDir = WEB_PATH . "/uploads/{$this->subdir}/{$file_dir}";
		$this->ugmUpFilesUrl = WEB_URL . "/uploads/{$this->subdir}/{$file_dir}";
		$this->ugmUpFilesImgDir = WEB_PATH . "/uploads/{$this->subdir}/{$image_dir}";
		$this->ugmUpFilesImgUrl = WEB_URL . "/uploads/{$this->subdir}/{$image_dir}";
		$this->ugmUpFilesThumbDir = WEB_PATH . "/uploads/{$this->subdir}/{$thumbs_dir}";
		$this->ugmUpFilesThumbUrl = WEB_URL . "/uploads/{$this->subdir}/{$thumbs_dir}";
	}

	#設定子目錄
	public function set_subdir($value="") {
		$this->subdir = $value ? $value : $this->subdir;
		$this->set_path();
	}

	#設定檔案目錄
	public function set_file_dir($value="") {
		$this->file_dir = $value ? $value : $this->file_dir;
		$this->set_path();
	}

	#設定圖片目錄
	public function set_image_dir($value="") {
		$this->image_dir = $value ? $value : $this->image_dir;
		$this->set_path();
	}

	#設定縮圖目錄
	public function set_thumbs_dir($value="") {
		$this->thumbs_dir = $value ? $value : $this->thumbs_dir;
		$this->set_path();
	}

	//設定欄名，sn,sort
	public function set_col($col_name = "", $col_sn = "", $sort = "") {
		$this->col_name = $col_name;
		$this->col_sn = $col_sn;
		$this->sort = $sort;
	}

	//自動編號
	public function auto_sort() {
		global $db;

		$sql = "select max(sort) from `{$this->ugmUpFilesTblName}`  where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}'";//die($sql);

		$result = $db->query($sql) or die(printf("Error: %s <br>" . $sql, $db->sqlstate));
		list($max) = $result->fetch_row();
		return ++$max;
	}

	private function delete_directory($dirname) {
		if (is_dir($dirname)) {
			$dir_handle = opendir($dirname);
		}

		if (!$dir_handle) {
			return false;
		}

		while ($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname . "/" . $file)) {
					unlink($dirname . "/" . $file);
				} else {
					delete_directory($dirname . '/' . $file);
				}

			}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}

}

/*------------------------------------------------------
#引入
include_once WEB_PATH."/class/ugmUpFiles.php";


(目錄名稱,"/子目錄","/檔案","/圖片","/縮圖",$multiple)
$multiple = false
$ugmUpFiles=new ugmUpFiles("ugm_p","/prod/pic","/file","/image","/image/thumbs",$multiple);
<input type="file" name="cover" maxlength="1" accept="image/*" class="span12">
------------------------------------------------------- */