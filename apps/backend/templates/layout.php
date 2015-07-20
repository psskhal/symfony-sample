<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<title>JoTAG / <?=$sf_context->getModuleName() ?> / <?=$sf_context->getActionName() ?></title>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
	<div id="wrapper">
		<div id="header">
			<div id="joomla"><?=image_tag('sf_admin/header_text.png',array('alt'=>'123Parcel Logo')) ?></div>
		</div>
	</div>
	<div class="centermain">
		<div class="main">
			<?=include_partial('global/menu') ?>
			<?=include_partial('global/toolbar') ?>
			<div id="contents">
				<?php echo $sf_content ?>
			</div>
		</div>
	</div>
	<?=include_partial('global/footer') ?>
</body>
</html>