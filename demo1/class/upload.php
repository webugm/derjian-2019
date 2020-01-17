<?php
//此檔案是給 ck.php 用的，勿刪
require_once dirname(__DIR__) . '/head.php';
if (!$_SESSION['admin']) {
  exit;
}

require_once __DIR__ . '/upload/class.upload.php';

$type = strip_tags(system_CleanVars($_REQUEST, 'type', '', 'string'));
$CKEditorFuncNum = system_CleanVars($_REQUEST, 'CKEditorFuncNum', 0, 'int');

$mdir = "ck";
$path = _WEB_PATH . "/uploads/{$mdir}/{$type}/";
$url = _WEB_URL . "/uploads/{$mdir}/{$type}/";
$type_arr = ['image', 'file', 'flash'];

$image_max_width = 640;
$image_max_height = 640;

//判斷是否是非法調用
if (empty($CKEditorFuncNum)) {
    mkhtml(1, '', "{$type} -{$CKEditorFuncNum} error");
}

if (strpos($_SERVER['HTTP_REFERER'], _WEB_URL) !== 0) {
    mkhtml(1, '', "{$type} -{$CKEditorFuncNum} error");
}

$fn = $CKEditorFuncNum;

if (!in_array($type, $type_arr)) {
    mkhtml(1, '', "{$type} -{$CKEditorFuncNum} error");
}

$foo = new Upload($_FILES['upload']);
if ($foo->uploaded) {
    $path_parts = pathinfo($_FILES['upload']['name']);
    $foo->file_new_name_body = $path_parts['filename'];
    $foo->image_resize = true;
    $foo->image_ratio = true;
    $foo->image_x = $image_max_width;
    $foo->image_y = $image_max_height;

    // save uploaded image with no changes
    $foo->process($path);
    if ($foo->processed) {
        // die($foo->file_dst_name);
        chmod($path . $_FILES['upload']['name'], 0777);
        $msg = $url . $_FILES['upload']['name'];
        mkhtml($fn, $msg);
    } else {
        $msg = 'error : ' . $foo->error;
        mkhtml($fn, '', $msg);
    }
}

function mkhtml($fn, $fileurl, $message)
{
    $str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(' . $fn . ', \'' . $fileurl . '\', \'' . $message . '\');</script>';
    exit($str);
}
