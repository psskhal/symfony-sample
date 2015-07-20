<?php decorate_with(false); ?>
<?php $options = $jotag->getBadgeOptions(); ?>
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

<?php if($jotag->haveContacts()): ?>
	<?php slot('captcha') ?>
		<p class="captcha">
			<?php echo $form["captcha"]->render() ?>
			<?php if($form["captcha"]->hasError()): ?><br/><font color="red">&uarr; <?php echo $form["captcha"]->getError() ?> &uarr;</font><br/><?php endif; ?>
		</p>
	<?php end_slot(); ?>

	<div id="jotag-enter-answer">
		<div class="imgs">
			<?php if($options["display_photo"]): ?>
				<?php echo image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$jotag->getTagProfile()->getPhoto(),array('width'=>'66px','height'=>'65px','absolute'=>true)) ?>
			<?php endif; ?>
			<?php echo image_tag("badge/answer/icon-lock.gif")?>
		</div>
		<div class="type">
			<form name="privacy_frm" method="post" action="<?php echo url_for('@view_jotag_badge?jotag='.$jotag->getJotag()) ?>">
				<?php if($jotag->getTagPrivacy()->getPrivacyType() == TagPrivacyPeer::PRIVACY_CAPTCHA): ?>
					<p><?php echo __('%name%\'s contact details are protected with a anti-robot mechanism. Please enter the letters in the box below.',array(
										"%name%"	=> $jotag->getTagProfile()->getFirstName())
					) ?></p>
					<?php include_slot('captcha') ?>
					<p align="center"><button><?php echo __("View Jotag")?></button></p>
				<?php elseif($jotag->getTagPrivacy()->getPrivacyType() == TagPrivacyPeer::PRIVACY_PIN): ?>
					<p><?php echo __('%name%\'s contact details are protected with a security question. Please answer the question to reveal his Jotag.',array(
										"%name%"	=> $jotag->getTagProfile()->getFirstName())
					) ?></p>
					<h1><?php echo $jotag->getTagPrivacy()->getPinHint() ?></h1>
					<p>
						<?php echo $form["pin"]->render() ?>
						<?php if($form["pin"]->hasError() && !$form["captcha"]->hasError()): ?>
							<font color="red">&larr; <?php echo $form["pin"]->getError() ?></font>
						<?php endif; ?>
					</p>
					<?php include_slot('captcha') ?>
					<p align="center"><button><?php echo __("View Jotag")?></button></p>
				<?php elseif($jotag->getTagPrivacy()->getPrivacyType() == TagPrivacyPeer::PRIVACY_AUTH): ?>
						<?php if($sf_user->isAuthenticated()): ?>
							<?php if($jotag->getAuthStatus($sf_user->getSubscriber()) == TagAuthPeer::STATUS_NONE): ?>
								<p><?php echo __('Click the button below to request authorization to view this JoTAG. Optionally, enter a message so the owner can easily idenfity you.') ?></p>
								<h1><?php echo __('Message') ?></h1>
								<p><?php echo $form["message"]->render(array('cols'=>30,'rows'=>1)) ?></p>
								<?php include_slot('captcha') ?>
								<p align="center"><button><?php echo __("Send")?></button></p>
							<?php elseif($jotag->getAuthStatus($sf_user->getSubscriber()) == TagAuthPeer::STATUS_PENDING): ?>
									<p><?php echo __('Your authorization request was sent to the owner of this JoTAG. You will be notified as soon as he/she respond to your request.') ?></p>
							<?php else: ?>
								<p><?php echo __('The owner of this JoTAG denied you from viewing this JoTAG') ?></p>
							<?php endif; ?>
						<?php else: ?>
							<p><?php echo __('Only authorized users can view complete details of this jotag.') ?></p>
							<p><?php echo __('If you are already a JoTAG member, click <a href="%link%">here</a> to login, otherwise, click <a href="%link2%" target="_blank">here</a> to create your JoTAG account now. After that you can go back to this page and ask the owner of this jotag to authorize you.',
												array('%link%'=>url_for('@login_badge_redirect?redirect='.$jotag->getJotag().''),'%link2%'=>url_for("@signup"))) ?></p>
							<p><br /></p>
						<?php endif; ?>
				<?php endif; ?>	
			</form>
		</div>
		<div class="clear"></div>
		<div class="sign">
			<div class="powered"><?php echo __("powered by")?> <span>Jotag</span></div>
			<div class="get"><?php echo link_to(__("Get your own widget"),"@homepage",array("target"=>"_blank"))?></div>
		</div>
	</div>
<?php endif; ?>

</body>

</html>