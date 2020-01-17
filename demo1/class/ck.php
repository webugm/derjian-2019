<?php
defined('_WEB_URL') || die("WEB root path not defined");

class CKEditor {
	public $DirName;
	public $ColName;
	public $CustomConfigurationsPath;
	public $ToolbarSet = "my";
	public $Width = '100%';
	public $Height = 300;
	public $Value;
	public $ContentsCss = array();
	public $demopublickey = "";

	//建構函數
	public function __construct($DirName = "", $ColName = "", $Value = "") {
		//$xoopsModuleConfig  = TadToolsXoopsModuleConfig();
		$this->DirName = $DirName;
		$this->ColName = $ColName;
		$this->Value = $Value;
		// if (!empty($xoopsModuleConfig['uploadcare_publickey'])) {
		// 	$this->set_demopublickey($xoopsModuleConfig['uploadcare_publickey']);
		// }

	}

	//設定自定義設定檔
	public function setCustomConfigurationsPath($path = "") {
		$this->CustomConfigurationsPath = $path;
	}

	//設定自定義工具列
	public function setToolbarSet($ToolbarSet = "") {
		$this->ToolbarSet = $ToolbarSet;
	}

	//設定自定義設寬度
	public function setWidth($Width = "") {
		$this->Width = $Width;
	}

	//設定自定義設高度
	public function setHeight($Height = "") {
		$this->Height = $Height;
	}

	//新增樣式
	public function setContentCss($ContentsCss = "") {
		$this->ContentsCss[] = $ContentsCss;
	}
	public function set_demopublickey($demopublickey = "") {
		$this->demopublickey = $demopublickey;
	}

	//產生編輯器
	public function render() {
		global $xoTheme;

		$_SESSION['DirName'] = $this->DirName;

		// before being fed to the textarea of CKEditor
		$content = str_replace('&', '&amp;', $this->Value);
		$content = str_replace('[', '&#91;', $content);

		$other_css = '';
		if ($this->ContentsCss) {
			$other_css = ",'" . implode("','", $this->ContentsCss) . "'";
		}

		$editor = "
				<script type='text/javascript' src='" . _WEB_URL . "/class/ckeditor/ckeditor.js'></script>
              <textarea name='{$this->ColName}' id='editor_{$this->ColName}' class='ckeditor_css'>{$content}</textarea>

              <script type='text/javascript'>

              CKEDITOR.replace('editor_{$this->ColName}' , {
                skin : 'moono' ,
                width : '{$this->Width}' ,
                height : '{$this->Height}' ,
                language : 'zh-TW' ,
                toolbar : '{$this->ToolbarSet}' ,
                contentsCss : ['" . _WEB_URL . "/class/bootstrap3/css/bootstrap.css','" . _WEB_URL . "/class/ckeditor/plugins/fontawesome/font-awesome/css/font-awesome.min.css'{$other_css}],

								extraPlugins: 'syntaxhighlight,oembed,eqneditor,imagerotate,fakeobjects,widget,lineutils,widgetbootstrap,widgettemplatemenu,pagebreak,fontawesome,codemirror,quicktable',

                filebrowserBrowseUrl : '" . _WEB_URL . "/class/elFinder/elfinder.php?type=file&mod_dir=" . $this->DirName . "',
                filebrowserImageBrowseUrl : '" . _WEB_URL . "/class/elFinder/elfinder.php?type=image&mod_dir=" . $this->DirName . "',
                filebrowserFlashBrowseUrl : '" . _WEB_URL . "/class/elFinder/elfinder.php?type=flash&mod_dir=" . $this->DirName . "',
                filebrowserUploadUrl : '" . _WEB_URL . "/class/upload.php?type=file&mod_dir=" . $this->DirName . "',
                filebrowserImageUploadUrl : '" . _WEB_URL . "/class/upload.php?type=image&mod_dir=" . $this->DirName . "',
                filebrowserFlashUploadUrl : '" . _WEB_URL . "/class/upload.php?type=flash&mod_dir=" . $this->DirName . "',
                qtRows: 10, // Count of rows
                qtColumns: 10, // Count of columns
                qtBorder: '1', // Border of inserted table
                qtWidth: '100%', // Width of inserted table
                qtStyle: { 'border-collapse' : 'collapse' },
                qtClass: 'table table-bordered table-hover table-condensed', // Class of table
                qtCellPadding: '0', // Cell padding table
                qtCellSpacing: '0', // Cell spacing table
                qtPreviewBorder: '1px double black', // preview table border
                qtPreviewSize: '15px', // Preview table cell size
                qtPreviewBackground: '#c8def4' // preview table background (hover)
              } );
              </script>
                <script>CKEDITOR.dtd.\$removeEmpty['span'] = false;</script>
              ";

		return $editor;
	}

}
/*
	$DirName = "ck";
	mk_dir(_WEB_PATH . "/uploads/{$DirName}");
	mk_dir(_WEB_PATH . "/uploads/{$DirName}/image");
	mk_dir(_WEB_PATH . "/uploads/{$DirName}/flash");
	include_once _WEB_PATH . "/class/ck.php";
	$fck = new CKEditor($DirName, "content", $row['content']);
	$fck->setHeight(350);
	$row['content'] = $fck->render();
*/
