<?php use_helper('I18N') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<title>JoTAG / login</title>

<link rel="shortcut icon" href="/favicon.ico" />

<script language="javascript" type="text/javascript">
	function setFocus() {
		$('username').select();
		$('username').focus();
	}
</script>
</head>
<body onload="setFocus();">
<div id="wrapper">
	<div id="header">
		<div id="joomla"><?=image_tag('sf_admin/header_text.png',array('alt'=>'123Parcel Logo')) ?></div>
	</div>
</div>
<div id="ctr" align="center">
	<div class="login">
		<?php if($form->hasGlobalErrors()): ?>
			<div class="form-errors">
				<h2>
				<?php foreach($form->getGlobalErrors() as $error): ?>
					<?=$error ?>
				<?php endforeach; ?>
				</h2>
			</div>
		<?php endif; ?>
		<div class="login-form">
			<form name="loginForm" action="<?php echo url_for('@login') ?>" method="post">
			<?=image_tag('sf_admin/login.gif',array('alt'=>'Login')) ?>
			<div class="form-block">
				<div class="inputlabel"><?=__('Username')?></div>
				<div><?=$form["username"]->render(array('id'=>'username','class'=>'inputbox')) ?></div>
				<div class="inputlabel"><?=__('Password')?></div>
				<div><?=$form["password"]->render(array('class'=>'inputbox')) ?></div>
				<div align="left"><input type="submit" name="submit" class="button" value="Login" /></div>
			</div>
			</form>
		</div>
		<div class="login-text">
			<div class="ctr"><?=image_tag('sf_admin/login_security.png',array('alt'=>'Security')) ?></div>
			<p><?=__('Welcome to JoTAG') ?></p>
			<p><?=__('Use a valid username and password to gain access to the administration console.')?></p>
		</div>
		<div class="clr"></div>
	</div>
</div>
<?=include_partial('global/footer') ?>
<noscript>
<?=__('!Warning! Javascript must be enabled for proper operation of the Administrator')?>
</noscript>
</body>
</html>