<?php decorate_with(false); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php include_http_metas() ?>
<?php include_metas() ?>
<?php 
	use_stylesheet('i18n/badgeStyle');
	sfContext::getInstance()->getResponse()->removeStylesheet("jotag/reset");
	sfContext::getInstance()->getResponse()->removeStylesheet("i18n/style");
?>

<title>Jotag</title>
<!--[if IE]>
	<script type="text/javascript" src="<?php echo sfConfig::get("app_general_base_path") ?>js/jotag/iepngfix_tilebg.js"></script>
<![endif]-->
 
</head>

<body>
	<div id="jotag-enter-answer">
		<div class="type">
			<form action="<?php echo url_for('@login_badge') ?>" method="POST">
				<?php echo $login_form["referal"]->render() ?>
				<h1>Login:</h1>
				<?php if($login_form["email"]->hasError()): ?>
					<p align="center"><font color="#ff0000"><b><?php echo $login_form["email"]->getError() ?></b></font></p>
				<?php endif; ?>
				<p>
					<?php echo $login_form["email"]->renderLabel() ?>
					<?php echo $login_form["email"]->render() ?>
				</p>
				<p>
					<?php echo $login_form["password"]->renderLabel() ?>
					<?php echo $login_form["password"]->render() ?>
				</p>
				<p><?php echo $login_form["remember"]->renderLabel() ?> <?php echo $login_form["remember"]->render() ?></p>
		      	<p align="center"><button><?php echo __("Login")?></button></p>
			</form>
		</div>
		<div class="sign">
			<div class="powered"><?php echo __("powered by")?> <span>Jotag</span></div>
			<div class="get"><?php echo link_to(__("Get your own widget"),"@homepage",array("target"=>"_blank"))?></div>
		</div>
	</div>
</body>
</html>