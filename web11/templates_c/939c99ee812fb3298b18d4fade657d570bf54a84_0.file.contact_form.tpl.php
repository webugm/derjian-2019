<?php
/* Smarty version 3.1.34-dev-7, created on 2020-02-28 19:46:58
  from 'D:\0_course\xampp\xampp\htdocs\web11\templates\tpl\contact_form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e58fdb2ce9615_47645105',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '939c99ee812fb3298b18d4fade657d570bf54a84' => 
    array (
      0 => 'D:\\0_course\\xampp\\xampp\\htdocs\\web11\\templates\\tpl\\contact_form.tpl',
      1 => 1582875140,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e58fdb2ce9615_47645105 (Smarty_Internal_Template $_smarty_tpl) {
?>   
    
    <div class="container mt-5 mb-3" style="margin-top: 100px!important;">        
        <h1 class="text-center">聯絡我們</h1> 
        <div class="row  mb-5">
            <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
            <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
            <div>0921-560421</div>
            </div>
            <div class="col-lg-4 mr-auto text-center">
            <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
            <!-- Make sure to change the email address in anchor text AND the link below! -->
            <a class="d-block" href="mailto:tawan158@gmail.com">tawan158@gmail.com</a>
            </div>
        </div>
			
        <!-- 表單返回頁，記得在表單加「 target='returnWin' 」 -->
        <iframe name="returnWin" style="display: none;" onload="this.onload=function(){window.location='index.php?op=ok'}"></iframe>

        <form  target='returnWin' role="form" action="https://docs.google.com/forms/u/0/d/e/1FAIpQLSdEdFVM05z1TaxO2rdqukwPVKC3RqG3G70cdgznjX3xbCHOTg/formResponse" method="post" id="myForm" >
            
            <div class="row">
                <!--姓名-->              
                <div class="col-sm-4">
                    <div class="form-group">
                        <label><span class="title">姓名</span><span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="entry.1597864916" id="name" value="">
                    </div>
                </div>
                <!--電話-->              
                <div class="col-sm-4">
                    <div class="form-group">
                        <label><span class="title">電話</span><span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="entry.2110810376" id="tel" value="">
                    </div>
                </div>
                <!--email-->              
                <div class="col-sm-4">
                    <div class="form-group">
                        <label><span class="title">email</span><span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="entry.1402899655" id="email" value="">
                    </div>
                </div>
            </div> 
            
            <div class="row">
                <div class="col-sm-12">  
                    <!-- 聯絡事項 -->
                    <div class="form-group">
                        <label class="control-label">聯絡事項</label>
                        <textarea class="form-control" rows="5" id="contact" name="entry.1136713386"></textarea>
                    </div>
                </div>
            </div>

            <div class="text-center pb-3">
                <button type="submit" class="btn btn-primary">送出</button>
            </div>
        </form>
       
    </div>
    
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
            'entry.1597864916' : {
            required: true
            },
            'entry.2110810376' : {
            required: true
            },
            'entry.1402899655' : {
            required: true
            }
        },
        messages: {
            'entry.1597864916' : {
            required: "必填"
            },
            'entry.2110810376' : {
            required: "必填"
            },
            'entry.1402899655' : {
            required: "必填"
            }
        }
        });

    });
    <?php echo '</script'; ?>
>
    <?php }
}
