<?php
#引入smarty物件
require_once WEB_PATH . '/class/smarty/libs/Smarty.class.php';
#實體化
$smarty = new Smarty;
#指定左標籤定義符
$smarty->left_delimiter = "<{"; //指定左標籤
#指定左標籤定義符
$smarty->right_delimiter = "}>"; //指定右標籤
#指定編譯文件存放目錄
$smarty->compile_dir = WEB_PATH . '/templates_c/';
#指定配置文件存放目錄
$smarty->config_dir = WEB_PATH . '/configs/';
#暫存路徑
$smarty->cache_dir = WEB_PATH . '/cache/';
