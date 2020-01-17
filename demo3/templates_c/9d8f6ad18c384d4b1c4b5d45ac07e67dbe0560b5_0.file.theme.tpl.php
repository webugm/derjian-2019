<?php
/* Smarty version 3.1.34-dev-7, created on 2020-01-06 10:53:53
  from 'D:\0_course\xampp\xampp\htdocs\demo3\templates\theme.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e1303b10b4c14_56400511',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d8f6ad18c384d4b1c4b5d45ac07e67dbe0560b5' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\demo3\\templates\\theme.tpl',
      1 => 1578198020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tpl/user.tpl' => 1,
    'file:tpl/index.tpl' => 1,
  ),
),false)) {
function content_5e1303b10b4c14_56400511 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<title>Hello, world!</title> 
		
		<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<?php echo '<script'; ?>
   src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"><?php echo '</script'; ?>
>
		
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"><?php echo '</script'; ?>
>
		
  </head>
  <body>
    <div class="container-fluid">               
      <?php if ($_smarty_tpl->tpl_vars['WEB']->value['file_name'] == "user.php") {?>
        <?php $_smarty_tpl->_subTemplateRender("file:tpl/user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
      <?php } elseif ($_smarty_tpl->tpl_vars['WEB']->value['file_name'] == "index.php") {?> 
        <?php $_smarty_tpl->_subTemplateRender("file:tpl/index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
      <?php }?>
    </div>
  </body>
</html><?php }
}
