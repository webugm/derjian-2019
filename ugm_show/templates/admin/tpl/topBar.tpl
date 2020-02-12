 			<!-- TOPBAR -->
	    <div class="topBar">
	      <div class="container">
	        <div class="row">
	          <div class="col-md-6 col-sm-5 hidden-xs">
	            <ul class="list-inline">
	            	<li style="color:#fff;"><a href="https://www.ugm.com.tw" title="育將電腦工作室 開發">台南社大-商品展示<{$WEB.version}></a></li>
	              <li><a href="https://github.com/webugm/ugm_show" title="下載"><i class="fa fa-github"></i></a></li>
	            </ul>
	          </div>
	          <div class="col-md-6 col-sm-7 col-xs-12">
	            <ul class="list-inline pull-right top-right">
	              <{if $isAdmin}>
		              <li>	
		              	<!-- Single button -->
										<div class="btn-group">
										  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    管理員 <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
				                <li><a href="admin_member.php">會員管理</a></li>
									    	<li role="separator" class="divider"></li>
				                <li><a href="admin_prod.php">商品管理</a></li>
									    	<li role="separator" class="divider"></li>
				                <li><a href="admin_kind.php">類別管理</a></li>
				                <li><a href="admin_nav.php">選單管理</a></li>
				                <li><a href="admin_slider.php">輪播圖管理</a></li>
										  </ul>
										</div>
		              	
		              </li>
	              <{/if}>
	              <li>	              	
	              	<!-- Single button -->
									<div class="btn-group">
									  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <{if $isUser}><{$smarty.session.name}><{else}>訪客<{/if}>
									    <span class="caret"></span>
									  </button>
									  <ul class="dropdown-menu">
	                    <{if $isUser}> 
	     									<li><a href="admin.php?op=logout">登出</a></li>
									    	<li role="separator" class="divider"></li>
	     									<{if $isAdmin}>
	     										<{if $WEB.file_name == "index.php"}>
		     										<li><a href="admin.php">後台</a></li>
	     										<{/if}>
	     										<{if $WEB.file_name != "index.php"}>
		     										<li><a href="index.php">前台</a></li>
	     										<{/if}>
									    		<li role="separator" class="divider"></li>
					                <li><a href="admin_update.php">更新管理</a></li>
					                <li><a href="admin.php?op=opDeleteTmp">清理暫存</a></li>
	     									<{/if}>
	                    <{else}>
	                    	<li><a href="admin.php?op=loginForm">登入</a></li>
	                    	<li><a href="admin.php?op=signupForm">註冊</a></li> 
	                    <{/if}>
									  </ul>
									</div>
	              </li>
	            </ul>
	          </div>
	        </div>
	      </div>
	    </div>