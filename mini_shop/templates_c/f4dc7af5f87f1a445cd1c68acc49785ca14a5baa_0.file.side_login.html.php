<?php
/* Smarty version 3.1.29, created on 2020-01-06 07:28:02
  from "D:\0_course\xampp\xampp\htdocs\mini_shop\templates\side_login.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5e12d3724b9320_30998176',
  'file_dependency' => 
  array (
    'f4dc7af5f87f1a445cd1c68acc49785ca14a5baa' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\mini_shop\\templates\\side_login.html',
      1 => 1461056540,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e12d3724b9320_30998176 ($_smarty_tpl) {
?>
<form action="index.php" method="post" role="form" class="form-horizontal">
  <div class="form-group">
    <label class="col-md-4 control-label">帳號：</label>
    <div class="col-md-8">
      <input type="text" name="user_name" value="" class="form-control" placeholder="請輸入帳號">
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-4"></label>
    <div class="col-md-8">
      <input type="hidden" name="op" value="user_login">
      <button type="submit" name="button" class="btn btn-primary btn-block">登入</button>
    </div>
  </div>
</form><?php }
}
