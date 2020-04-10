<!DOCTYPE html>
<html><head>
<title><?php echo $config['app_name'] ?></title>
<link href="<?php echo $config['app_url'] ?>assets/css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $config['app_url'] ?>assets/images/silk_theme.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $config['app_url'] ?>bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $config['app_url'] ?>bower_components/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css" />
<?php echo $css_includes ?>
</head>
<body>
<div id="loading">loading...</div>
<div id="header">
<h1 id="logo"><a href="<?php echo $config['app_url']; ?>"><?php echo $config['app_name'] ?></a></h1>
</div>

<div id="content">
<div id="error-message" <?php echo ($QUERY['error']) ? '':'style="display:none;"';?>><?php
	if(isset($PARAM['error'])) print strip_tags($PARAM['error']); //It comes from the URL
	else print $QUERY['error']; //Its set in the code(validation error or something.
?></div>
<div id="success-message" <?php echo ($QUERY['success']) ? '':'style="display:none;"';?>><?php echo strip_tags(stripslashes($QUERY['success']))?></div>

<!-- Begin Content -->
<?php 
/////////////////////////////////// The Template file will appear here ////////////////////////////

include(iframe\App::$template->template);

/////////////////////////////////// The Template file will appear here ////////////////////////////
?>
<!-- End Content -->
</div>

<div id="footer">An <a href="http://www.bin-co.com/php/scripts/iframe/">iFrame</a> Application</div>

<script src="<?php $config['app_url'] ?>bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="<?php $config['app_url'] ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php $config['app_url'] ?>js/common.js" type="text/javascript"></script>
<?php echo $js_includes ?>
</body>
</html>
