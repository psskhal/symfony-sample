Dear <?=$owner ?>,
Your invite was accepted by <?=$user ?>!
<?php if ($credits): ?>
You received <?=$credits * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT') ?> free days in credits!
<?php endif; ?>