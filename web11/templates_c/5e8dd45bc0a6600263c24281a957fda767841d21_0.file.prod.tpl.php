<?php
/* Smarty version 3.1.34-dev-7, created on 2020-02-26 06:07:19
  from 'D:\0_course\xampp\xampp\htdocs\web11\templates\tpl\prod.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e559a97eda298_25821333',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5e8dd45bc0a6600263c24281a957fda767841d21' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\web11\\templates\\tpl\\prod.tpl',
      1 => 1582668436,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e559a97eda298_25821333 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['op']->value == "op_list") {?>
	<table class="table table-striped table-bordered table-hover table-sm">
			<thead>
			<tr>
					<th scope="col">標題</th>
					<th scope="col">類別</th>
					<th scope="col">價格</th>
					<th scope="col">狀態</th>
					<th scope="col">計數</th>
					<th scope="col">
						<a href="?op=op_form" class="btn btn-primary btn-sm">新增</a>
					</th>
			</tr>
			</thead>
			<tbody>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
							<tr>
									<td><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['row']->value['kind_sn'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
</td>
									<td class="text-center"><?php if ($_smarty_tpl->tpl_vars['row']->value['enable']) {?><i class="fas fa-check"></i><?php }?></td>
									<td><?php echo $_smarty_tpl->tpl_vars['row']->value['counter'];?>
</td>
									<td>
										<a href="?op=op_form&sn=<?php echo $_smarty_tpl->tpl_vars['row']->value['sn'];?>
"><i class="far fa-edit"></i></a>
										<a href="javascript:void(0)" onclick="op_delete(<?php echo $_smarty_tpl->tpl_vars['row']->value['sn'];?>
);"><i class="far fa-trash-alt"></i></a>
									</td>
							</tr>
					<?php
}
} else {
?>
							<tr>
									<td colspan=6>目前沒有資料</td>
							</tr>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

			</tbody>
	</table>
	
	<!-- sweetalert2 -->
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['xoAppUrl']->value;?>
class/sweetalert2/sweetalert2.min.css">
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['xoAppUrl']->value;?>
class/sweetalert2/sweetalert2.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>
			function op_delete(uid){
					Swal.fire({
							title: '你確定嗎？',
							text: "您將無法還原！",
							icon: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: '是的，刪除它！',
							cancelButtonText: '取消'
							}).then((result) => {
							if (result.value) {
									document.location.href="user.php?op=op_delete&uid="+uid;
							}
					})
			}
	<?php echo '</script'; ?>
>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['op']->value == "op_form") {?>
	<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo $_smarty_tpl->tpl_vars['xoAppUrl']->value;?>
class/My97DatePicker/WdatePicker.js'><?php echo '</script'; ?>
>	
    
	<div>
		<h1 class="text-center">商品表單</h1>
			
		<form action="prod.php" method="post" id="myForm" class="mb-2" enctype="multipart/form-data">
			
			<div class="row">         
				<!--標題-->              
				<div class="col-sm-6">
					<div class="form-group">
					<label>標題<span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="title" id="title" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
">
					</div>
				</div>         
				<!--日期-->              
				<div class="col-sm-3">
					<div class="form-group">
					<label>日期<span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="date" id="date" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['date'];?>
" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})">
					</div>
				</div> 
				<!-- 商品狀態  -->
				<div class="col-sm-3">
					<div class="form-group">
					<label style="display:block;">商品狀態</label>
					<input type="radio" name="enable" id="enable_1" value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value['enable'] == '1') {?>checked<?php }?>>
					<label for="enable_1" style="display:inline;">啟用</label>&nbsp;&nbsp;
					<input type="radio" name="enable" id="enable_0" value="0" <?php if ($_smarty_tpl->tpl_vars['row']->value['enable'] == '0') {?>checked<?php }?>>
					<label for="enable_0" style="display:inline;">停用</label>
					</div>
				</div> 
				<!-- 類別  -->              
				<div class="col-sm-4">
					<div class="form-group">
						<label class="d-block">類別</label>
						<select name="kind_sn" id="kind_sn" class="form-control" >
							<option value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value['kind_sn'] == "1") {?> selected<?php }?> >類別1</option>
							<option value="2" <?php if ($_smarty_tpl->tpl_vars['row']->value['kind_sn'] == "2") {?> selected<?php }?> >類別2</option>
						</select>
					</div> 
				</div> 							

				<!--價格-->              
				<div class="col-sm-4">
					<div class="form-group">
						<label>價格</label>
						<input type="text" class="form-control text-right" name="price" id="price" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
">
					</div>
				</div> 

				<!--排序-->              
				<div class="col-sm-2">
					<div class="form-group">
						<label>排序</label>
						<input type="text" class="form-control text-right" name="sort" id="sort" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sort'];?>
">
					</div>
				</div>  

				<!--計數器-->              
				<div class="col-sm-2">
					<div class="form-group">
						<label>計數器</label>
						<input type="text" class="form-control text-right" name="counter" id="counter" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['counter'];?>
">
					</div>
				</div> 
				<!--商品圖-->              
				<div class="col-sm-4">
					<div class="form-group">
						<label>商品圖</label>
						<input type="file" class="form-control" name="prod" id="prod" >
						<label class="mt-1">
							<?php if ($_smarty_tpl->tpl_vars['row']->value['prod']) {?>
								<img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['prod'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
" class="img-fluid">
							<?php }?>
						</label>
					</div>
				</div> 
			</div>
			<div class="row">
				<div class="col-sm-12">  
					<!-- 內容 -->
					<div class="form-group">
						<label class="control-label">內容</label>
						<textarea class="form-control" rows="4" id="content" name="content"><?php echo $_smarty_tpl->tpl_vars['row']->value['content'];?>
</textarea>
					</div>
				</div>
			</div>

			<div class="text-center pb-20">
			<input type="hidden" name="op" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['op'];?>
">
			<input type="hidden" name="sn" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sn'];?>
">
			<button type="submit" class="btn btn-primary">送出</button>
			</div>
		
		</form>
		<!-- 表單驗證 -->
		<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"><?php echo '</script'; ?>
>
		<!-- 調用方法 -->
		<style>
				.error{
				color:red;
				}
		</style>
		<?php echo '<script'; ?>
>
			$(function(){
				$("#myForm").validate({
					submitHandler: function(form) {
							form.submit();
					},
					rules: {
						'title' : {
							required: true
						}
					},
					messages: {
						'title' : {
							required: "必填"
						}
					}
				});

			});
		<?php echo '</script'; ?>
>
			
	</div>

<?php }
}
}
