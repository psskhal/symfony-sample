<p>Dear <?=$jotag->getUser() ?>,</p>
<?php if($days > 0): ?>
<p>Your personalized JoTAG - <?=$jotag->getJotag() ?> - will expire in the next <?=$days ?> days.</p>
<p>Renew your JoTAG today, clicking <?=link_to('here',url_for('@buy_step2?jotag='.$jotag->getJotag(),true)) ?></p>
<?php else: ?>
<p>Your personalized JoTAG - <?=$jotag->getJotag() ?> - expired <?=abs($days) ?> ago.</p>
<p>Don't lose your JoTAG, click <?=link_to('here',url_for('@buy_step2?jotag='.$jotag->getJotag(),true)) ?> to renew it now!</p>
<p>If you don't want to receive this email anymore, just click <?=link_to('here',url_for('@cancel_jotag?jotag='.$jotag->getJotag(),true)) ?></p>
<br/>
<p><i>PS: You JoTAG will be made available to all users <?=OptionPeer::retrieveOption('BUY_DELETE_AFTER') ?> days after expiration date!</i></p>
<?php endif; ?>