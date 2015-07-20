Dear <?=$jotag->getUser() ?>,
<?php if($days > 0): ?>
Your personalized JoTAG - <?=$jotag->getJotag() ?> - will expire in the next <?=$days ?> days.
Renew your JoTAG today, clicking the following link:
<?=url_for('@buy_step2?jotag='.$jotag->getJotag(),true) ?>  
<?php else: ?>
Your personalized JoTAG - <?=$jotag->getJotag() ?> - expired <?=abs($days) ?> ago.
Don't lose your JoTAG, renew your JoTAG now clicking the following link:
<?=url_for('@buy_step2?jotag='.$jotag->getJotag(),true) ?>    
If you don't want to receive this email anymore, just click the following link:
<?=url_for('@cancel_jotag?jotag='.$jotag->getJotag(),true) ?>    

PS: You JoTAG will be made available to all users <?=OptionPeer::retrieveOption('BUY_DELETE_AFTER') ?> days after expiration date!
<?php endif; ?>