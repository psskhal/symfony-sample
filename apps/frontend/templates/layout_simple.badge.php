<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_http_metas() ?>
<?php include_metas() ?>

<title><?php if(!include_slot('title')): ?>JoTAG<?php endif; ?></title>
<link rel="shortcut icon" href="/favicon.ico" />
<!--[if IE]>
	<script type="text/javascript" src="<?php echo sfConfig::get("app_general_base_path") ?>js/jotag/iepngfix_tilebg.js"></script>
<![endif]-->
</head>
<body>
<div id="startwrapper">
	<?php echo $sf_content ?>
</div>
</body>
</html>