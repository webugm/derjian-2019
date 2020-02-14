<?php
/* Smarty version 3.1.34-dev-7, created on 2020-02-14 23:42:56
  from 'D:\0_course\xampp\xampp\htdocs\web11\templates\tpl\user_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e472270c5e757_23353790',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ab789291426cc7e318ce0d26ee2873957f8f5dae' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\web11\\templates\\tpl\\user_list.tpl',
      1 => 1581720173,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e472270c5e757_23353790 (Smarty_Internal_Template $_smarty_tpl) {
?>
<table class="table">
  <thead>    
    <tr>
      <th>uid</th>
      <th>姓名</th>
      <th>電話</th>
      <th>email</th>
    </tr>
  </thead>
  <tbody>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
      <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['tel'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
</td>
      </tr>
    <?php
}
} else {
?>
      <tr colspan=3>
        目前沒有資料
      </tr>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </tbody>
</table><?php }
}
