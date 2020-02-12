<?php
include_once "../../head.php";
if (!$_SESSION['isAdmin']) {
    exit;
}

$type    = system_CleanVars($_REQUEST, 'type', '', 'string');
$mod_dir = system_CleanVars($_REQUEST, 'mod_dir', '', 'string');
$LANGCODE = "zh_TW";

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>elFinder 2.1.x source version with PHP connector</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />

		<!-- Require JS (REQUIRED) -->
		<!-- Rename "main.default.js" to "main.js" and edit it if you need configure elFInder options or any things -->
		<!--script data-main="/class/elFinder/main.js" src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js"></script-->
        <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL; ?>/class/jquery/themes/base/jquery-ui.css">

        <script src="<?php echo WEB_URL; ?>/class/jquery/jquery.js"></script>
        <script src="<?php echo WEB_URL; ?>/class/jquery/ui/jquery-ui.js"></script>

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL; ?>/class/elFinder/css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL; ?>/class/elFinder/css/theme.css">

        <!-- elFinder JS (REQUIRED) -->
        <script src="<?php echo WEB_URL; ?>/class/elFinder/js/elfinder.min.js"></script>

        <!-- elFinder translation (OPTIONAL) -->
        <script src="<?php echo WEB_URL; ?>/class/elFinder/js/i18n/elfinder.<?php echo $LANGCODE; ?>.js"></script>



        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
            // Helper function to get parameters from the query string.
            function getUrlParam(paramName) {
                var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
                var match = window.location.search.match(reParam) ;

                return (match && match.length > 1) ? match[1] : '' ;
            }

            $().ready(function() {
                var funcNum = getUrlParam('CKEditorFuncNum');

                var elf = $('#elfinder').elfinder({
                    url : '<?php echo WEB_URL; ?>/class/elFinder/php/connector.minimal.php?type=<?php echo $type; ?>',
                    getFileCallback : function(file) {
                        // alert(file.url);
                        window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                        elf.destroy();
                        window.close();
                    },
                    lang: '<?php echo $LANGCODE; ?>',
                    resizable: true
                }).elfinder('instance');
            });
        </script>

	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>
