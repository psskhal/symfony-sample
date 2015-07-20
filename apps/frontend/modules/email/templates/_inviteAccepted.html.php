<p>Dear <?=$owner ?>,</p>
<p>Your invite was accepted by <?=$user ?>!</p>
<?php if ($credits): ?>
	<p>You received <?=$credits * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT') ?> free days in credits!</p>
<?php endif; ?>