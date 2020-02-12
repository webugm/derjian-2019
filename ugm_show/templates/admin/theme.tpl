<{* 後台主佈景 *}>
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

  <!-- sweetalert2 -->
  <script src="<{$xoAppUrl}>class/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<{$xoAppUrl}>class/sweetalert2/sweetalert2.min.css">
  
  <!-- fontawesome -->  
  <link rel="stylesheet" href="<{$xoAppUrl}>class/font-awesome/css/font-awesome.min.css">
	<title><{$WEB.theme_title}></title>

</head>
<body>

	<{* 頁面轉向 *}>
  <{if $redirect}>
    <{include file="file:$redirectFile"}> 
  <{/if}>
  <div class="wrapper">  
	  <!-- HEADER -->
	  <div class="header clearfix headerV3" style="margin-bottom:20px;">
      <{include file="tpl/topBar.tpl"}> 
	  </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">          
          <{if $WEB.file_name == "admin.php"}>
            <{include file="tpl/admin.tpl"}>
          <{elseif  $WEB.file_name == "admin_member.php"}> 
            <{include file="tpl/admin_member.tpl"}>
          <{* 商品管理 *}>  
          <{elseif  $WEB.file_name == "admin_prod.php"}> 
            <{include file="tpl/admin_prod.tpl"}>
          <{* 類別管理 *}>  
          <{elseif  $WEB.file_name == "admin_kind.php"}> 
            <{include file="tpl/admin_kind.tpl"}>
          <{* 選單管理 *}>  
          <{elseif  $WEB.file_name == "admin_nav.php"}> 
            <{include file="tpl/admin_nav.tpl"}>
          <{* 輪播圖管理 *}>  
          <{elseif  $WEB.file_name == "admin_slider.php"}> 
            <{include file="tpl/admin_slider.tpl"}>
          <{* 首頁 *}>  
          <{elseif  $WEB.file_name == "index.php"}> 
          <{/if}>
        </div>

      </div>
    </div>
  	
  </div>
  <{include file="tpl/admin_facebook.tpl"}> 

</body>
</html>