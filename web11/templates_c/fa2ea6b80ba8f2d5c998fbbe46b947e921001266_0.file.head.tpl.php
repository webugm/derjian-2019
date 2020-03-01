<?php
/* Smarty version 3.1.34-dev-7, created on 2020-02-28 14:53:44
  from 'D:\0_course\xampp\xampp\htdocs\web11\templates\tpl\head.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e58b8f88d3160_74793245',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa2ea6b80ba8f2d5c998fbbe46b947e921001266' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\web11\\templates\\tpl\\head.tpl',
      1 => 1582872818,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e58b8f88d3160_74793245 (Smarty_Internal_Template $_smarty_tpl) {
?>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav" >
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="index.php#page-top"><?php echo $_smarty_tpl->tpl_vars['WEB']->value['web_title'];?>
</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mainMenus']->value, 'mainMenu');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['mainMenu']->value) {
?>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo $_smarty_tpl->tpl_vars['mainMenu']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['mainMenu']->value['target']) {?> target="_blank"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['mainMenu']->value['title'];?>
</a>
            </li>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

          <?php if ($_SESSION['user']['kind'] === 1) {?>
                        <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="user.php">後台</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php?op=logout">登出</a>
            </li>
          <?php } elseif ($_SESSION['user']['kind'] === 0) {?> 
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php?op=logout">登出</a>
            </li> 
          <?php } else { ?>
                        <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php?op=login_form">登入</a>
            </li>
            
          <?php }?>

        </ul>
      </div>
    </div>
  </nav>
<?php }
}
