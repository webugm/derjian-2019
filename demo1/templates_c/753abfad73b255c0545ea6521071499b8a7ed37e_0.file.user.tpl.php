<?php
/* Smarty version 3.1.34-dev-7, created on 2020-01-05 05:20:30
  from 'D:\0_course\xampp\xampp\htdocs\demo1\templates\tpl\user.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e11640e710046_95398681',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '753abfad73b255c0545ea6521071499b8a7ed37e' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\demo1\\templates\\tpl\\user.tpl',
      1 => 1578198004,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e11640e710046_95398681 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['op']->value == "login_form") {?> 
  <style>
    .form-signin {
      width: 100%;
      max-width: 400px;
      padding: 15px;
      margin: 0 auto;
    }    
  </style>
  <?php if ($_SESSION['admin']) {?>
    <div>
      已經登入
    </div>
  <?php } else { ?>
    <div class="container mt-5">
      <form class="form-signin" action="<?php echo $_SERVER['SCRIPT_NAME'];?>
" method="post">
        <h1 class="h3 mb-3 font-weight-normal">會員登入</h1>
        <div class="mb-3">
          <label for="uname" class="sr-only">Email 信箱</label>
          <input type="uname"  name="uname" class="form-control" placeholder="請輸入Email" required="" autofocus="">
        </div>
        <div class="mb-3">
          <label for="pass" class="sr-only">密碼</label>
          <input type="password"  name="pass"  id="pass" class="form-control" placeholder="請輸入密碼" required="">
        </div>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" name="remember" value="1"> 記住我
          </label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">
          會員登入
        </button>
        <input type="hidden" name="op" value="login">
        <div>
          您還沒還沒註冊嗎？請 <a href="#">點選此處註冊您的新帳號</a>。
        </div>
      </form>

      
    </div>
  <?php }
}?>
   <?php }
}
