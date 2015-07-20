Dear <?=$user ?>,
Welcome to JoTAG. Please confirm you account clicking on the following link:
<?=link_to(url_for('@confirm_email?confirm_code='.$email->getConfirmCode(),true),'@confirm_email?confirm_code='.$email->getConfirmCode(),array("absolute"=>true)) ?>
<?php if ($user->getCredits()): ?>
You have <?=$user->getCredits() * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT') ?> free days to get a personalized JoTAG 
<?php endif; ?>