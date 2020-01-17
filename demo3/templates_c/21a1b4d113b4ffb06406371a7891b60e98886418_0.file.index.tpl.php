<?php
/* Smarty version 3.1.34-dev-7, created on 2020-01-06 10:53:53
  from 'D:\0_course\xampp\xampp\htdocs\demo3\templates\tpl\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e1303b11beef1_71323670',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '21a1b4d113b4ffb06406371a7891b60e98886418' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\demo3\\templates\\tpl\\index.tpl',
      1 => 1578290373,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e1303b11beef1_71323670 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 src="<?php echo @constant('_WEB_URL');?>
/class/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
<textarea  name="content" id="content"></textarea>
<?php echo '<script'; ?>
>
    CKEDITOR.replace('content'
);
<?php echo '</script'; ?>
>
<?php }
}
