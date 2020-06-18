<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $config['app_name'] ?></title>
<link href="<?php echo iapp('config')['app_url'] ?>assets/css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo iapp('config')['app_url'] ?>assets/images/silk_theme.css" rel="stylesheet" type="text/css" />
<link href="<?php echo iapp('config')['app_url'] ?>bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo iapp('config')['app_url'] ?>bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<?php echo $css_includes ?>
</head>
<body>
<div id="main">
<div id="error-message" <?php echo ($QUERY['error']) ? '':'style="display:none;"';?>><?php
	if(isset($PARAM['error'])) print strip_tags($PARAM['error']); //It comes from the URL
	else print $QUERY['error']; //Its set in the code(validation error or something.
?></div>

<!-- Begin Content -->
<?php 
/////////////////////////////////// The Template file will appear here ////////////////////////////

include(iframe\App::$template->template);

/////////////////////////////////// The Template file will appear here ////////////////////////////
?>
<!-- End Content -->
</div>

<script src="<?php $config['app_url'] ?>bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="<?php $config['app_url'] ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php $config['app_url'] ?>js/common.js" type="text/javascript"></script>
<?php echo $js_includes ?>
</body>
</html>
