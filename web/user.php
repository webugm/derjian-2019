<?php
/* 引入檔頭，每支程都會引入 */
require_once 'head.php';

print_r($_POST);
die();

/*---- 程式結尾-----*/
$smarty->display('user.tpl');