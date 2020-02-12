<?php
#---------------------------------
defined('WEB_PATH') || die("WEB_PATH root path not defined");
class ugmKind {
	protected $tbl; //資料表
	protected $kind; //類別
	protected $stopLevel; //層數
	protected $ofsn = 0; //父類別
	protected $moduleName; //專案名稱

	function __construct($tbl, $kind,$stopLevel=1,$moduleName="") {
		$this->set_tbl($tbl);
		$this->set_kind($kind);
		$this->set_stopLevel($stopLevel);
		$this->set_ofsn(0);
		$this->set_moduleName($moduleName);
	}
	#--------- 設定類 --------------------
	#設定資料表
	public function set_tbl($value) {
		$this->tbl = $value;
	}
	#設定類別
	public function set_kind($value) {
		$this->kind = $value;
	}
	#設定層數
	public function set_stopLevel($value) {
		$this->stopLevel = $value;
	}
	#設定父類別
	public function set_ofsn($value) {
		$this->ofsn = $value;
	}
	#設定專案名稱
	public function set_moduleName($value) {
		if(!$value){
			$value = basename(dirname(__DIR__));
		}
		$this->moduleName = $value;
	}
	//--------- 取得類 ------------*/
	#取得資料表
	public function get_tbl() {
		return $this->tbl;
	}
	#取得分類
	public function get_kind() {
		return $this->kind;
	}
	#取得層數
	public function get_stopLevel() {
		return $this->stopLevel;
	}
	#取得父類別
	public function get_ofsn() {
		return $this->ofsn;
	}

	#get
	################################################################
	#  取得外鍵下拉選單 的 選項
	#  傳入：($kind_arr, $width = 3)
	#  回傳：ForeignKeyForm
	################################################################
	public function get_foreignOption($foreign, $default="") {
	  # ----得到Foreign key選單 ----------------------------
	  $foreignOption = "";
	  foreach ($foreign as $key => $value) {
	    $selected = "";
	    if ($default == $key) {
	      $selected = " selected";
	    }
	    $foreignOption .= "<option value='{$key}'{$selected}>{$value['title']}</option>";
	  }
	  return $foreignOption;
	}

	################################################################
	#  取得類別body的陣列
	################################################################
	public function get_listArr($ofsn=0,$level=1,$enable=0) {
		global $db;
		
		$andKey = $enable ? " and `enable`='{$enable}'":"";

		#檢查目前階層是否大於層次
		if ($level > $this->stopLevel) {
			return;
		}

		#設定下層
		$downLevel = $level + 1;

		$sql = "select * from `{$this->tbl}`
            where `ofsn`='{$ofsn}' and `kind`='{$this->kind}'{$andKey} 
            order by sort"; //die($sql);

		$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);

		#--------------------------------------------------------------------
		$rows = [];
		while ($row = $result->fetch_assoc()) {
			//以下會產生這些變數： $sn , $ofsn , $title , $enable  ,$sort
			$row['sn'] = intval($row['sn']);
			$row['enable'] = intval($row['enable']);
			$row['target'] = intval($row['target']);
			$row['title'] = htmlspecialchars($row['title'], ENT_QUOTES); 
			$row['url'] = htmlspecialchars($row['url'], ENT_QUOTES);
			$row['level'] = $level;
			#取得底下有幾層
			$row['downLevel'] = $this->get_downLevel($row['sn']);
			
			$row['sub'] = $this->get_listArr($row['sn'], $downLevel);

			//移動圖示
			$icon['move_i'] = ($this->stopLevel == $row['downLevel'])?false:true;
			//資料夾圖示(最後一層沒有)
			$icon['folder_i'] = $this->stopLevel > $level ? true : false;
			//增加類別圖示
			$icon['add_downLevel_i'] = $this->stopLevel > $level ? true : false;
			//排序圖示
			$icon['sort_i'] = true;

			$row['icon'] = $icon;

			$rows[] = $row;
		}
		return $rows;
	}

	#確認底下有幾層
	#get_downLevel
	public function get_downLevel($sn,$downLevel=0) {
		global $db;

		if ($downLevel > $this->stopLevel) {
			return $downLevel;
		}
		$level = $downLevel+1;
		$sql = "select sn
            from `{$this->tbl}`
            where ofsn='{$sn}'"; // return $sql;
		$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);

		while ($row = $result->fetch_assoc()) {
			$downLevel_tmp = $this->get_downLevel($row['sn'], $level);
			$downLevel = ($downLevel_tmp > $downLevel) ? $downLevel_tmp : $downLevel;
		}
		return $downLevel;
	}

	################################################################
	#  取得類別body的html
	#  data-tt-id 本身
	#  data-tt-parent-id 父層
	################################################################
	public function get_listHtml($list, $listBodys,$width="width:65%;") {
		$html = "";
		foreach ($list as $item => $row) {
			$html .= $this->get_rowHtml($listBodys, $row,$width);
			if ($row['sub']) {
				$html .= $this->get_listHtml($row['sub'], $listBodys,$width);
			}
		}
		return $html;
	}

	################################################################
	#  取得類別body的html
	#  data-tt-id 本身
	#  data-tt-parent-id 父層
	################################################################
	public function get_rowHtml($listBodys,$row,$width="width:65%;") {		
		#row自己的層數
		$level = $this->get_thisLevel($row['sn']);
		//style='letter-spacing: 0;'
		$html = "
			<tr id='tr_{$row['sn']}' data-tt-id='{$row['sn']}' data-tt-parent-id='{$row['ofsn']}' level='{$row['level']}' downLevel='{$row['downLevel']}' sn='{$row['sn']}' class='level{$row['level']}' >\n";		

		foreach ($listBodys as $k => $format){
			if($k == "title"){
				#新增子類別
				$addLevelButton = ($this->stopLevel > $level) ? "
          <a href='?op=opForm&ofsn={$row['sn']}&kind={$row['kind']}' title='IN ({$row['title']}) 建立子類別' class='btn btn-primary btn-xs'>
          	<i class='fa fa-plus' aria-hidden='true'></i>          
          </a>" : "";

				#移動
				$moveButton = ($row['icon']['move_i']) ? "
            <img src='" . WEB_URL . "/class/treeTable/images/move_s.png' class='folder' alt='用來搬移此分類到其他分類之下，請拖曳之，到目的地分類。' title='用來搬移此分類到其他分類之下，請拖曳之，到目的地分類。'>
          " : "";

				#資料夾
				$folderButton = ($row['icon']['folder_i']) ? "<span class='folder'></span>" : "";

				#一般input
				$html .= "  <td class='text-{$format['align']}' style='vertical-align: middle;'>
                      {$folderButton}{$moveButton}
                      <input type='text' name='{$k}[{$row['sn']}]' value='{$row[$k]}' id='{$k}_{$row['sn']}' class='{$k}'  style='{$width} padding: 2px 6px;'>{$addLevelButton}
                    </td>";

			}elseif($k == "url"){	#一般input
				$html .= "  <td class='text-{$format['align']}' style='vertical-align: middle;'>                      
                      <input type='text' name='{$k}[{$row['sn']}]' value='{$row[$k]}' id='{$k}_{$row['sn']}' class='{$k}'  style='width:100%; padding: 2px 6px;'>
                    </td>";

			}elseif($k == "pic"){

			  #----單檔圖片上傳
			  $moduleName = $this->moduleName; //專案名稱
			  $subdir = $this->kind; //子目錄
			  $col_name = $this->kind;//資料表關鍵字
			  $col_sn = $row['sn'];//商品流水號
			  $thumb = true ; //顯示縮圖
			  $ugmUpFiles = new ugmUpFiles($moduleName, $subdir);//實體化
			  $row['pic'] = $ugmUpFiles->get_rowPicSingleUrl($col_name,$col_sn,$thumb);
			  #-----------------------------------
				
				$html .= "  <td class='text-{$format['align']}' style='vertical-align: middle;'>                      
                      <img src='{$row['pic']}' style='width:80px;' class='img-responsive'>
                    </td>";

			}elseif($k == "target"){

				if ($row[$k] == 1) {
					#啟用
					$target_0 = "本站";
					$html .= "  <td class='text-{$format['align']}' style='vertical-align: middle;'><a href='?op=opUpdateTarget&sn={$row['sn']}&{$k}=0&kind=" . $this->get_kind() . "' title='{$target_0}' atl='{$target_0}'><i class='fa fa-check' aria-hidden='true'></i></a></td>";
				} else {
					#停用
					$target_1 = "外連";
					$html .= "  <td class='text-{$format['align']}' style='vertical-align: middle;'><a href='?op=opUpdateTarget&sn={$row['sn']}&{$k}=1&kind=" . $this->get_kind() . "' title='{$target_1}' atl='{$target_1}'><i class='fa fa-times' aria-hidden='true'></i></a></td>";
				}

			}elseif($k == "enable"){				

				if ($row[$k] == 1) {
					#啟用
					$enable_0 = "停用";
					$html .= "  <td class='text-{$format['align']}' style='vertical-align: middle;'><a href='?op=opUpdateEnable&sn={$row['sn']}&{$k}=0&kind=" . $this->get_kind() . "' title='{$enable_0}' atl='{$enable_0}'><i class='fa fa-check' aria-hidden='true'></i></a></td>";

				} else {
					#停用
					$enable_1 = "啟用";
					$html .= "  <td class='text-{$format['align']}' style='vertical-align: middle;'><a href='?op=opUpdateEnable&sn={$row['sn']}&{$k}=1&kind=" . $this->get_kind() . "' title='{$enable_1}' atl='{$enable_1}'><i class='fa fa-times' aria-hidden='true'></i></a></td>";

				}

			}elseif($k == "function"){
				$html .= "  <td class='text-{$format['align']}' style='vertical-align: middle;'>\n";
				$html .= "<i class='fa fa-sort' aria-hidden='true' style='cursor: s-resize;' title='可直接拉動排序'></i> ";
				foreach ($format['btn'] as $btnV) {
					if ($btnV == "view") {

					} elseif ($btnV == "edit") {
						$html .= "<a href='?op=opForm&sn={$row['sn']}&kind=" . $this->get_kind() . "' class='btn btn-success btn-xs'>編輯</a> ";

					} elseif ($btnV == "del") {
						$html .= "<button type='button' class='btn btn-xs btn-danger btnDel'>刪除</button> ";

					}
				}
				$html .= "  </td>\n";

			}
		}
		$html .= "</tr>\n";
		return $html;

	}

	###########################################################
	#  用流水號 得到自己的層數
	###########################################################
	public function get_thisLevel($sn, $level = 1) {
		global $db;

		if($sn=="0" and $level == "1")return "0";
		if ($level > $this->stopLevel)return $level;

		$sql = "select ofsn
            from `{$this->tbl}`
            where sn='{$sn}'"; // die($sql);

	  $result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);	          
	  list($ofsn) = $result->fetch_row();  

		if (!$ofsn) {
			return $level;
		}

		return $this->get_thisLevel($ofsn, ++$level);
	}

	#以流水號取得某筆分類資料
	public function get_rowBYsn($sn) {
		global $db;
		if (empty($sn)) {
			return;
		}

		$sql = "select * from `$this->tbl` where sn='{$sn}'"; //die($sql);
		$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);	 
		$row = $result->fetch_assoc();
		return $row;
	}

	#######################################################
	#  取得父類別選單->選項(後台類別表單用)
	#  $default：外部傳進來預設值
	#  $enable：1 停用不顯示
	#######################################################
	public function get_ofsnOption($default, $ofsn = 0, $level = 1, $indent = "", $enable = 0) {
		global $db;

		if ($level >= $this->stopLevel) {
			return;
		}

		$andKey = $enable ? " and `enable='{$enable}'`":"";

		$downLevel = $level + 1;
		$indent .= "&nbsp;&nbsp;&nbsp;&nbsp;";
		$sql = "select * 
						from `{$this->tbl}`
            where ofsn='{$ofsn}' and kind='{$this->kind}'{$andKey}
            order by sort"; //die($sql);

		$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
		$options = "";
		while ($row = $result->fetch_assoc()) {
			$selected = ($default == $row['sn']) ? " selected" : "";
			$options .= "<option value='{$row['sn']}'{$selected}>{$indent}{$row['title']}</option>\n";
			$options .= $this->get_ofsnOption($default, $row['sn'], $downLevel, $indent, $enable);
		}
		return $options;
	}


	#######################################################
	#(類別表單用、每層都可以選)
	# enable=0 可選
	# $in_sn => 選到的類別
	# $ofsn =>大類
	# $stopLevel => 層數	# 
	#######################################################
	public function get_kindOption($in_sn,$enable=false,$ofsn = 0, $stopLevel = 0, $level = 1, $indent = "") {
		global $db;
		#層數預設值
		$stopLevel = $stopLevel ? $stopLevel : $this->stopLevel;
		if ($level > $stopLevel) {
			return;
		}

		$downLevel = $level + 1;
		$andKey = $this->kind ? " and `kind`='{$this->kind}'" : "";
		$andEnable = $enable ? " and `enable`='{$enable}'" :"";
		$downIndent = $indent . "&nbsp;&nbsp;&nbsp;&nbsp;";

		$sql = "select * from `{$this->tbl}`
            where ofsn='{$ofsn}' {$andKey}{$andEnable}
            order by sort"; //die($sql) ;
		$result = $db->query($sql) or redirect_header("", 3000,  $db->error."\n".$sql,true);
		$main = "";
		while ($row =  $result->fetch_assoc()) {
			//以下會產生這些變數： $sn , $ofsn , $title , $enable  ,$sort,$kind
			$selected = ($in_sn == $row['sn']) ? " selected" : "";
			$main .= "<option value='{$row['sn']}' {$selected}>{$indent}{$row['title']}</option>";
			if ($level != $stopLevel) {
				$main .= $this->get_kindOption($in_sn,$enable, $row['sn'], $stopLevel, $downLevel, $downIndent);
			}
		}
		return $main;
	}


}