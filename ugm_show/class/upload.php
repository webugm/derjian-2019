<?php
//此檔案是給 ck.php 用的，勿刪
require_once dirname(dirname(__FILE__)).'/head.php';
include_once dirname(__FILE__)."/upload/class.upload.php";
$mdir     = $_SESSION['DirName'];
$path     = WEB_PATH . "/uploads/{$mdir}/{$_GET['type']}/";
$url      = WEB_URL . "/uploads/{$mdir}/{$_GET['type']}/";
$type_arr = array('image', 'file', 'flash');

//判斷是否是非法調用
if (empty($_GET['CKEditorFuncNum'])) {
    mkhtml(1, "", "error");
}

$fn = $_GET['CKEditorFuncNum'];

if (!in_array($_GET['type'], $type_arr)) {
    mkhtml(1, "", "error");
}

$foo = new Upload($_FILES['upload']);
if ($foo->uploaded) {
    // save uploaded image with no changes
    $foo->Process($path);
    if ($foo->processed) {
        $msg = $url . $_FILES['upload']['name'];
        mkhtml($fn, $msg);
    } else {
        $msg = 'error : ' . $foo->error;
        mkhtml($fn, "", $msg);
    }
}

function mkhtml($fn, $fileurl, $message)
{
    $str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(' . $fn . ', \'' . $fileurl . '\', \'' . $message . '\');</script>';
    exit($str);
}
