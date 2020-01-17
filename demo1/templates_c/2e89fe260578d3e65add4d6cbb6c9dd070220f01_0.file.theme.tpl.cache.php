<?php
/* Smarty version 3.1.34-dev-7, created on 2020-01-05 03:14:48
  from 'D:\0_course\xampp\xampp\htdocs\demo1\templates\theme.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e11469830dac9_47587628',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2e89fe260578d3e65add4d6cbb6c9dd070220f01' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\demo1\\templates\\theme.tpl',
      1 => 1578189657,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e11469830dac9_47587628 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '12701206005e114697ad9cf7_50345837';
?>
<!doctype html>
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
    <h1><?php echo $_SESSION['admin'];?>
</h1>
    <?php if ($_smarty_tpl->tpl_vars['op']->value == "login_form") {?> 
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
              <input type="pass"  name="pass"  id="pass" class="form-control" placeholder="請輸入密碼" required="">
            </div>

            <div class="checkbox mb-3">
              <label>
                <input type="checkbox" name="remember" value="remember-me"> 記住我
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
      <?php }?>
    <?php }?>
   
  </body>
</html><?php }
}
