<?php
/* Smarty version 3.1.29, created on 2020-01-06 07:28:22
  from "D:\0_course\xampp\xampp\htdocs\mini_shop\templates\goods_form.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5e12d3869ae063_88082669',
  'file_dependency' => 
  array (
    '4d81f6fb6fcf61dbb58f8fa7e9f083af0598af8a' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\mini_shop\\templates\\goods_form.html',
      1 => 1461291374,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e12d3869ae063_88082669 ($_smarty_tpl) {
?>
<h1>編輯商品</h1>
<?php echo '<script'; ?>
 src="class/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
<form action="tool.php" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-md-2 control-label">商品名稱：</label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="goods_title" id="goods_title" placeholder="請輸入商品名稱" value="">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">商品內容：</label>
        <div class="col-md-10">
            <textarea class="form-control" name="goods_content" id="goods_content" placeholder="請輸入商品內容"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">商品價格：</label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="goods_price" id="goods_price" placeholder="請輸入商品價格" value="">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">商品圖片：</label>
        <div class="col-md-10">
            <input type="file" name="goods_pic" id="goods_pic">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <input type="hidden" name="op" value="insert_goods">
            <button type="submit" class="btn btn-primary">儲存商品</button>
        </div>
    </div>
</form>

<?php echo '<script'; ?>
>
    CKEDITOR.replace( 'goods_content' );
<?php echo '</script'; ?>
>
<?php }
}
