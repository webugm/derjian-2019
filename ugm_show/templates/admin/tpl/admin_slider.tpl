
<{if $op=="opList"}>
  <link href="<{$xoAppUrl}>class/treeTable/stylesheets/jquery.treetable.css" rel="stylesheet">
  <link href="<{$xoAppUrl}>class/treeTable/stylesheets/jquery.treetable.theme.default.css" rel="stylesheet">
  <script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
  <script type="text/javascript" src="<{$xoAppUrl}>class/treeTable/javascripts/src/jquery.treetable.js"></script>

  <script type="text/javascript">
    $(function()  {
      //可以展開，預設展開
      $('#form_table').treetable({ expandable: true ,initialState: 'expanded' });

      // 配置拖動節點
      $('#form_table .folder').draggable({
        helper: 'clone',
        opacity: .75,
        refreshPositions: true, // Performance?
        revert: 'invalid',
        revertDuration: 300,
        scroll: true
      });

      // Configure droppable rows
      $('#form_table .folder').each(function() {
        $(this).parents('#form_table tr').droppable({
          accept: '.folder',
          drop: function(e, ui) {
            var droppedEl = ui.draggable.parents('tr');
            console.log(droppedEl[0]);
            $('#form_table').treetable('move', droppedEl.data('ttId'), $(this).data('ttId'));
            //alert( droppedEl.data('ttId'));
            //目地的sn ：$(this).data('ttId')
            //自己的sn：droppedEl.data('ttId')
            $.ajax({
              type:   'POST',
              url:    '?op=opSaveDrag',
              data:   { ofsn: $(this).data('ttId'), sn: droppedEl.data('ttId'),kind :"<{$kind}>" },
              success: function(theResponse) {
                //$('#save_msg').html(theResponse);

                //警告視窗        
                swal({
                  title: theResponse,
                  text: '自動刷新畫面',
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: '確定'
                }).then(function () {
                  location.href="<{$smarty.session.returnUrl}>";
                });
              }
            });

          },
          hoverClass: 'accept',
          over: function(e, ui) {
            var droppedEl = ui.draggable.parents('tr');
            if(this != droppedEl[0] && !$(this).is('.expanded')) {
              $('#form_table').treetable('expandNode', $(this).data('ttId'));
            }
          }
        });
      });

      //排序
      $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
          var order = $(this).sortable('serialize') + '&op=opUpdateSort';
          $.post('<{$WEB.file_name}>', order, function(theResponse){
            //$('#save_msg').html(theResponse);//傳回訊息
            
            //警告視窗        
            swal({
              title: theResponse,
              text: '自動刷新畫面',
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: '確定'
            }).then(function () {
              location.href="<{$smarty.session.returnUrl}>";
            });
          });
        }
      });

      //每行的删除操作注册脚本事件
      $(".btnDel").bind("click", function(){
        var vbtnDel=$(this);//得到点击的按钮对象
        var vTr=vbtnDel.parents("tr");//得到父tr对象;
        var sn=vTr.attr("sn");//取得 sn
        var title=$("#title_"+sn).val();//取得 title
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
          location.href="?op=opDelete&sn=" + sn;
        })

      });

    }); 
  </script>
  <div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">輪播圖管理</h3></div>

    <div class="panel-body">      
      <div id="save_msg"></div>
      <form action='<{$WEB.file_name}>' method='post' id='myForm'>
        <{$foreignForm}>
        <table id="form_table" class="table table-bordered table-striped table-hover">
          <thead>
            <tr class="active">
              <{foreach from=$listTitles item=row}>
                <th 
                  <{foreach from=$row.attr item=attr key=k}>
                    <{$k}>="<{$attr}>" 
                  <{/foreach}>

                >
                  <{$row.content}>
                </th>
              <{/foreach}>
            </tr>
          </thead>
          <!-- 根目錄開始 -->
          <tr id='tr_0' data-tt-id="0">
            <td class="text-left" colspan=<{$listTitles|@count}>>
              <span class='folder'></span>
              <i class="fa fa-home" aria-hidden="true"></i>根目錄              

              <a href="#" class="btn btn-success btn-xs" onclick="jQuery('#form_table').treetable('expandAll'); return false;">展開<i class="fa fa-expand" aria-hidden="true"></i></a>

              <a href="#" class="btn btn-danger btn-xs" onclick="jQuery('#form_table').treetable('collapseAll'); return false;">闔起<i class="fa fa-compress" aria-hidden="true"></i></a>

              <a href="#" class="btn  btn-warning btn-xs">重整畫面<i class="fa fa-refresh" aria-hidden="true"></i></a>

              <a href="?op=opForm&kind=<{$kind}>&ofsn=0" class="btn btn-primary btn-xs" ait="在根目錄建立子輪播圖">新增<i class="fa fa-plus" aria-hidden="true"></i></a>
            </td>
          </tr>
          <!-- 根目錄結束 -->

          <tbody id='sort'>
            <{$listHtml}>
          </tbody>

          <tfoot>
            <tr>
              <td colspan=<{$listTitles|@count}> class="text-center">
                <input type='hidden' name='op' value="opAllInsert">
                <input type='hidden' name='kind' value="<{$kind}>">
                <button type="submit" class="btn btn-primary">送出</button>
              </td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
<{/if}>

<{if $op=="opForm"}>
  <!-- bootstrap 驗證 -->
  <link rel="stylesheet" href="<{$xoAppUrl}>class/bootstrapValidator/css/bootstrapValidator.css"/>
  <script type="text/javascript" src="<{$xoAppUrl}>class/bootstrapValidator/js/bootstrapValidator.js"></script>
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
    <div class="panel-heading"><h3 class="panel-title"><{$row.formTitle}></h3></div>
    <div class="panel-body">
      <form role="form" action="<{$WEB.file_name}>" method="post" id="opForm" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-8">
            <div class="form-group">
              <label>標題</label>
              <input type='text'  name='title' value='<{$row.title}>' id='title' class="form-control">
            </div>
          </div>

          <div class="col-sm-2">
            <div class="form-group">
              <label style="display:block;" >啟用</label>
              <input type='radio' name='enable' id='enable_1' value='1' <{if  $row.enable==1}>checked<{/if}>>
              <label for='enable_1'>啟用</label>&nbsp;&nbsp;
              <input type='radio' name='enable' id='enable_0' value='0' <{if $row.enable==0}>checked<{/if}>>
              <label for='enable_0'>停用</label>
            </div>
          </div>

          <{if $row.stopLevel > 1}>
            <div class="col-sm-2">
              <div class="form-group">
                <label>父輪播圖</label>
                <select name="ofsn" id="ofsn" class="form-control" size="1" >
                  <option value="0">/</option>
                  <{$row.ofsnOption}>
                </select>
              </div>
            </div>
          <{else}>
            <input type='hidden' name='ofsn' value='0'>              
          <{/if}>

        </div>
        <div class="row">
          <div class="col-sm-8">
            <div class="form-group">
              <label>網址</label>
              <input type='text'  name='url' value='<{$row.url}>' id='url' class="form-control">
            </div>
          </div>

          <div class="col-sm-2">
            <div class="form-group">
              <label style="display:block;" >外連</label>
              <input type='radio' name='target' id='target_1' value='1' <{if  $row.target==1}>checked<{/if}>>
              <label for='target_1'>外連</label>&nbsp;&nbsp;
              <input type='radio' name='target' id='target_0' value='0' <{if $row.target==0}>checked<{/if}>>
              <label for='target_0'>本站</label>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-sm-3">
            <div class="form-group">
              <label for="pic">圖片<span>(<{$row.picReadme}>)</span></label>
              <{$row.pic}>
            </div>
          </div>

          <div class="col-sm-9">
            <div class="form-group">
              <label for="content">摘要</label>
              <textarea class="form-control" rows="8" id="content" name="content"><{$row.content}></textarea>
            </div>                 
          </div>

        </div>
        <hr>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary">送出</button>
          <{if !$row.sn}>
          <button type="reset" class="btn btn-danger">重設</button>
          <{/if}>
          <button type="button" class="btn btn-warning" onclick="location.href='<{$smarty.session.returnUrl}>'">返回</button>
          <input type='hidden' name='op' value='<{$row.op}>'>
          <input type='hidden' name='sn' value='<{$row.sn}>'>
          <input type='hidden' name='kind' value='<{$row.kind}>'>
          <{$token}>
        </div>
      </form>
    </div>
  </div>
<{/if}>