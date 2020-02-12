<{if $op == "opList"}>
	<script type="text/javascript">
		
		$(function() {      
		  //每行的删除操作注册脚本事件
		  $(".btnDel").bind("click", function(){
		    var vbtnDel=$(this);//得到点击的按钮对象
		    var vTr=vbtnDel.parents("tr");//得到父tr对象;
		    var uid=vTr.attr("uid");//取得 uid       
		    var name=vTr.find(".name").html();//取得 title
		    //警告視窗		    
		    swal({
		      title: '確定要刪除此資料？',
		      text: name,
		      type: 'warning',
		      showCancelButton: true,
		      confirmButtonColor: '#3085d6',
		      cancelButtonColor: '#d33',
		      confirmButtonText: '確定刪除！',
		      cancelButtonText: '取消！'
		    }).then(function () {
		      location.href="admin_member.php?op=opDelete&uid=" + uid;
		    })


		  });
		  //给删除按钮注册js脚本
		});
		
	</script>

	<div class="panel panel-primary">
	  <div class="panel-heading">會員管理</div>
	  <div class="panel-body">
	    <table class="table table-condensed table-hover">
			  <thead>
			  	<tr>
			  		<th>uid</th>
			  		<th>姓名</th>
			  		<th>email</th>
			  		<th>群組</th>
			  		<th class="text-center">
				  		<a data-toggle="modal" href="#signup" class="btn btn-primary btn-xs">新增</a>
				  	</th>
			  	</tr>
			  </thead>
			  <tbody>
			  	<{foreach from=$rows item=row}>
				  	<tr uid="<{$row.uid}>" class="uid">
				  		<td class="uid"><{$row.uid}></td>
				  		<td class="name"><{$row.name}></td>
				  		<td class="email"><{$row.email}></td>
				  		<td class="group"><{$row.group}></td>
				  		<td  class="text-center">
				  			<a href="admin_member.php?op=opForm&uid=<{$row.uid}>" class="btn btn-warning btn-xs">編輯</a> 
				  			<button  class="btn btn-danger btn-xs btnDel">刪除</button> </td>
				  	</tr>
			  	<{/foreach}>
			  </tbody>
			</table>
	  </div>
	</div>

	<!-- signup MODAL -->
	<div class="modal fade" id="signup" tabindex="-1" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h3 class="modal-title">註冊帳號</h3>
	      </div>
	      <div class="modal-body">
	        
	        <form action="admin_member.php" method="POST" role="form" id="signupForm">
	          <div class="form-group">
	            <label for="name">姓名</label>
	            <input type="text" class="form-control" id="name" name="name">
	          </div>

	          <div class="form-group">
	            <label for="email">Email</label>
	            <input type="email" class="form-control" id="email" name="email">
	          </div>

	          <div class="form-group">
	            <label for="pass">密碼</label>
	            <input type="password" class="form-control" id="pass" name="pass">
	          </div>
	          
	          <div class="form-group">
	            <label for="confirmPass">確認密碼</label>
	            <input type="password" class="form-control" id="confirmPass" name="confirmPass">
	          </div>

	          <{$token}>
	          <button type="submit" class="btn btn-primary btn-block">註冊</button>
	          <input type="hidden" value="signup" name="op">
	        </form>

	      </div>
	    </div>
	  </div>
	</div>

	<script type="text/javascript">
	  $(document).ready(function() {
	    // Generate a simple captcha
	    function randomNumber(min, max) {
	        return Math.floor(Math.random() * (max - min + 1) + min);
	    };

	    $('#signupForm').bootstrapValidator({
	        //live: 'disabled',//
	        message: '此值無效',
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	          name: {
	            validators: {
	              notEmpty: {
	                message: '必填'
	              }
	            }
	          },
	          email: {
	            validators: {
	              notEmpty: {
	                message: '必填'
	              },
	              emailAddress: {
	                message: '請輸入正確的email'
	              },
	              remote: {
	                type: 'POST',
	                url: 'admin.php?op=ajaxCheckEmail',
	                message: '這個email已經有人使用',
	                delay: 1000
	              }
	            }
	          },
	          pass: {
	            validators: {
	              notEmpty: {
	                message: '必填'
	              },
	              identical: {
	                field: 'confirmPass',
	                message: '密碼及其確認密碼不一樣'
	              },
	              different: {
	                field: 'email',
	                message: '密碼不能與email相同'
	              }
	            }
	          },
	          confirmPass: {
	            validators: {
	                notEmpty: {
	                  message: '必填'
	                },
	                identical: {
	                  field: 'pass',
	                  message: '密碼及其確認密碼不一樣'
	                },
	                different: {
	                  field: 'email',
	                  message: '密碼不能與email相同'
	                }
	            }
	          }
	        }
	    });

	  });
	</script>

<{/if}>

<{if $op == "opForm"}>

	<div class="panel panel-primary">
	  <div class="panel-heading">編輯會員(<{$row.name}>) - 會員管理</div>
	  <div class="panel-body"> 
      <form action="admin_member.php" method="POST" role="form" id="opForm">
        <div class="row">
        	<div class="col-sm-3">
		        <div class="form-group">
		          <label for="name">姓名</label>
		          <input type="text" class="form-control" id="name" name="name" value="<{$row.name}>">
		        </div>        		
        	</div>
        	<div class="col-sm-3">
        		<div class="form-group">
        			<label for="group">群組</label>
        			<select class="form-control" id="group" name="group">
        				<option value="admin"<{if $row.group == "admin"}> selected<{/if}>>管理員</option>
        				<option value="user"<{if $row.group == "user"}> selected<{/if}>>會員</option>
        			</select>
        		</div>
        		
        	</div>
        	<div class="col-sm-3">
		        <div class="form-group">
		          <label for="pass">密碼</label>
		          <input type="password" class="form-control" id="pass" name="pass">
		        </div>
        		
        	</div>
        	<div class="col-sm-3"> 
		        <div class="form-group">
		          <label for="confirmPass">確認密碼</label>
		          <input type="password" class="form-control" id="confirmPass" name="confirmPass">
		        </div>
        		
        	</div>
        </div>


        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<{$row.email}>">
        </div>	       

        <{$token}>
        <button type="submit" class="btn btn-primary btn-block">更新</button>
        <input type="hidden" value="opUpdate" name="op">
        <input type="hidden" value="<{$row.uid}>" name="uid" id="uid">
      </form>
	   
	  </div>
	</div>

	<script type="text/javascript">
	  $(document).ready(function() {
	    // Generate a simple captcha
	    function randomNumber(min, max) {
	        return Math.floor(Math.random() * (max - min + 1) + min);
	    };
	    var uid = $("#uid").val();

	    $('#opForm').bootstrapValidator({
	        //live: 'disabled',//
	        message: '此值無效',
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	          name: {
	            validators: {
	              notEmpty: {
	                message: '必填'
	              }
	            }
	          },
	          email: {
	            validators: {
	              notEmpty: {
	                message: '必填'
	              },
	              emailAddress: {
	                message: '請輸入正確的email'
	              },
	              remote: {
	                type: 'POST',
	                url: 'admin_member.php?op=ajaxCheckEmail&uid='+ uid,
	                message: '這個email已經有人使用',
	                delay: 1000
	              }
	            }
	          },
	          pass: {
	            validators: {
	              identical: {
	                field: 'confirmPass',
	                message: '密碼及其確認密碼不一樣'
	              },
	              different: {
	                field: 'email',
	                message: '密碼不能與email相同'
	              }
	            }
	          },
	          confirmPass: {
	            validators: {
                identical: {
                  field: 'pass',
                  message: '密碼及其確認密碼不一樣'
                },
                different: {
                  field: 'email',
                  message: '密碼不能與email相同'
                }
	            }
	          }
	        }
	    });

	  });
	</script>
<{/if}>
