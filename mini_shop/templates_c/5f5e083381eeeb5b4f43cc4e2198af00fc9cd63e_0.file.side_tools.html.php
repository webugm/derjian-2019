<?php
/* Smarty version 3.1.29, created on 2020-01-06 07:28:11
  from "D:\0_course\xampp\xampp\htdocs\mini_shop\templates\side_tools.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5e12d37b359707_09462688',
  'file_dependency' => 
  array (
    '5f5e083381eeeb5b4f43cc4e2198af00fc9cd63e' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\mini_shop\\templates\\side_tools.html',
      1 => 1461056624,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e12d37b359707_09462688 ($_smarty_tpl) {
?>
<div class="alert alert-success">
  <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
您好！歡迎光臨<?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>

</div>
<a href="index.php" class="btn btn-block btn-primary">回首頁</a>
<a href="tool.php?op=goods_form" class="btn btn-block btn-success">發布商品</a>
<a href="index.php?op=user_logout" class="btn btn-block btn-danger">登出</a><?php }
}
