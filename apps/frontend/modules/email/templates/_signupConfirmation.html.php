<p>Dear <?=$user ?>,</p>
<p>Welcome to JoTAG. Please confirm you account clicking on the following link:</p>
<p><?=link_to(url_for('@confirm_email?confirm_code='.$email->getConfirmCode(),true),'@confirm_email?confirm_code='.$email->getConfirmCode(),array("absolute"=>true)) ?></p>
<?php if ($user->getCredits()): ?>
	<p>You have <?=$user->getCredits() * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT') ?> free days to get a personalized JoTAG</p> 
<?php endif; ?>