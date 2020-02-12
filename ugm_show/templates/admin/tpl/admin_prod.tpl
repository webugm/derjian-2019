
<{if $op == "opList"}>
  <script type="text/javascript">
    
    $(function() {      
      //每行的删除操作注册脚本事件
      $(".btnDel").bind("click", function(){
        var vbtnDel=$(this);//得到点击的按钮对象
        var vTr=vbtnDel.parents("tr");//得到父tr对象;
        var sn=vTr.attr("sn");//取得 sn       
        var title=vTr.find(".title").html();//取得 title
        //警告視窗        
        swal({
          title: '確定要刪除此資料？',
          text: title,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '確定刪除！',
          cancelButtonText: '取消！'
        }).then(function () {
          location.href="admin_prod.php?op=opDelete&sn=" + sn;
        })


      });
      //给删除按钮注册js脚本
    });
    
  </script>
	<div class="panel panel-primary">
	  <div class="panel-heading">商品管理 - 列表</div>
	  <div class="panel-body">
      <{$foreignForm}>
	    <table class="table table-bordered table-striped table-hover table-list">
        <thead>
          <tr class="info">
            <{foreach from=$thead item=row}>
               <th <{foreach from=$row.attr item=attr key=attrK}><{$attrK}>="<{$attr}>"<{/foreach}>>
                <{$row.content}>
              </th>
            <{/foreach}>
          </tr>
        </thead>
			  <tbody>
          <{foreach from=$rows item=row key=k}>
            <tr id="tr_<{$row.sn}>" sn="<{$row.sn}>">
              <{foreach from=$tbody item=rowTbody key=colName}>
                 <td <{foreach from=$rowTbody.attr item=attr key=attrK}><{$attrK}>="<{$attr}>"<{/foreach}>>
                  <{$row.$colName}>
                </td>
              <{/foreach}>

            </tr>
          <{/foreach}>
			  </tbody>
			</table>
      <{$bar}>
	  </div>
	</div>
<{/if}>

<{if $op == "opForm"}>
  <script type="text/javascript" src="<{$xoAppUrl}>class/My97DatePicker/WdatePicker.js"></script>
  <link rel="stylesheet" type="text/css" href="<{$xoAppUrl}>class/fontawesome-iconpicker/css/fontawesome-iconpicker.min.css">
  <script type="text/javascript" src="<{$xoAppUrl}>class/fontawesome-iconpicker/js/fontawesome-iconpicker.min.js"></script>
  <script type='text/javascript'>
    $(document).ready(function(){
      $('#icon').iconpicker();
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#opForm').bootstrapValidator({
          //live: 'disabled',//
          message: '此值無效',
          feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
            title: {
              validators: {
                notEmpty: {
                  message: '必填'
                }
              }
            }
          }
      });
    });
  </script>
	<div class="panel panel-primary">
	  <div class="panel-heading">商品管理</div>
	  <div class="panel-body"> 
      <form action="admin_prod.php" method="POST" role="form" id="opForm" enctype="multipart/form-data">
        
        <div class="row">

        	<div class="col-sm-3">
		        <div class="form-group">
		          <label for="title">商品名稱</label>
		          <input type="text" class="form-control" id="title" name="title" value="<{$row.title}>">
		        </div>        		
        	</div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="kind">類別</label>
              <select name="kind" class="form-control" size="1">
                <{$row.kind_options}>
              </select>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="price">商品價格</label>
              <input type="text" class="form-control" id="price" name="price" value="<{$row.price}>">
            </div>            
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="amount">商品數量</label>
              <input type="text" class="form-control" id="amount" name="amount" value="<{$row.amount}>">
            </div>            
          </div>

        </div>

        <div class="row">

          <div class="col-sm-3">
            <div class="form-group">
              <label style="display:block;">啟用</label>
              <input type="radio" name="enable" id="enable_1" value="1" <{if $row.enable == '1'}>checked<{/if}>>
              <label for="enable_1">啟用</label>&nbsp;&nbsp;
              <input type="radio" name="enable" id="enable_0" value="0"  <{if $row.enable == '0'}>checked<{/if}>>
              <label for="enable_0">停用</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label style="display:block;">精選</label>
              <input type="radio" name="choice" id="choice_1" value="1" <{if $row.choice == '1'}>checked<{/if}>>
              <label for="choice_1">啟用</label>&nbsp;&nbsp;
              <input type="radio" name="choice" id="choice_0" value="0" <{if $row.choice == '0'}>checked<{/if}>>
              <label for="choice_0">停用</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="date">建立日期</label>
              <input type="text" class="form-control" id="date" name="date" value="<{$row.date}>" onClick="WdatePicker()">
            </div>            
          </div>          

          <div class="col-sm-3">
            <div class="form-group">
              <label for="sort">排序</label>
              <input type="text" class="form-control" id="sort" name="sort" value="<{$row.sort}>">
            </div>            
          </div>  
          
          
        </div>

        <div class="row">
          <div class="col-sm-3">
            <div class="form-group">
              <label for="icon">圖示</label>
              <div class="input-group iconpicker-container">
                <input type="text" data-placement="bottomRight" class="form-control icp icp-auto iconpicker-element iconpicker-input" id="icon" name="icon" value="<{$row.icon}>">
                <span class="input-group-addon"><i class="fa <{$row.icon}>"></i></span>
              </div>
            </div>            
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="pic">圖片<span>(800x449)</span></label>
              <{$row.pic}>
            </div>
          </div> 

          <div class="col-sm-6">
            <div class="form-group">
              <label for="summary">商品摘要</label>
              <textarea class="form-control" rows="4" id="summary" name="summary"><{$row.summary}></textarea>
            </div>                 
          </div>
          
        </div>

        <div class="form-group">
				  <label for="content">商品內容</label>
				  <{$row.content}>
				</div> 
   

        <{$token}>
        <button type="submit" class="btn btn-primary btn-block">送出</button>
        <input type="hidden" value="<{$row.op}>" name="op">
        <input type="hidden" value="<{$row.sn}>" name="sn" id="sn">
      </form>
	   
	  </div>
	</div>

<{/if}>
