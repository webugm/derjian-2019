<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">

	<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="<{$xoImgUrl}>css/bootstrap.min.css">

	<!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
	<link rel="stylesheet" href="<{$xoImgUrl}>css/bootstrap-theme.min.css">
  <!-- 自訂css -->
  <link rel="stylesheet" type="text/css" href="<{$xoImgUrl}>css/style.css">
	
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="<{$xoImgUrl}>js/jquery.min.js"></script>
  
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="<{$xoImgUrl}>js/bootstrap.min.js"></script>

	<!-- bootstrap 驗證 -->
  <link rel="stylesheet" href="<{$xoAppUrl}>class/bootstrapValidator/css/bootstrapValidator.css"/>
  <script type="text/javascript" src="<{$xoAppUrl}>class/bootstrapValidator/js/bootstrapValidator.js"></script>

	<title>錯誤訊息頁面</title>

</head>
<body>
	<{* 頁面轉向 *}>
  <{if $redirect}>
    <{include file="file:$redirectFile"}> 
  <{/if}>
  <div class="container" style="margin-top:20px;">
  	<div class="alert alert-danger" role="alert">
      <h1>請聯絡管理員，謝謝！</h1>
  		<{$error}>	  		
  	</div>
    
  </div>
</body>
</html>