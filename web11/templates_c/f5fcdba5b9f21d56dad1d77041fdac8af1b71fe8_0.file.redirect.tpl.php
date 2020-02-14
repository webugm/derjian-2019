<?php
/* Smarty version 3.1.34-dev-7, created on 2020-02-14 20:48:47
  from 'D:\0_course\xampp\xampp\htdocs\web11\templates\tpl\redirect.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e46f99f68c120_53071030',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f5fcdba5b9f21d56dad1d77041fdac8af1b71fe8' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\web11\\templates\\tpl\\redirect.tpl',
      1 => 1581673522,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e46f99f68c120_53071030 (Smarty_Internal_Template $_smarty_tpl) {
?>
    <?php if ($_smarty_tpl->tpl_vars['redirect']->value) {?>
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['xoAppUrl']->value;?>
class/sweetalert2/sweetalert2.min.css">
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['xoAppUrl']->value;?>
class/sweetalert2/sweetalert2.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
      window.onload = function(){
        Swal.fire({
          //position: 'top-end',
          icon: 'success',
          title: "<?php echo $_smarty_tpl->tpl_vars['message']->value;?>
",
          showConfirmButton: false,
          timer: <?php echo $_smarty_tpl->tpl_vars['time']->value;?>

        })
      }    
    <?php echo '</script'; ?>
>
  <?php }
}
}
