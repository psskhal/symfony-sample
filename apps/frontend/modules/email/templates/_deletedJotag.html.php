<p>Dear <?=$jotag->getUser() ?>,
<p>Your personalized JoTAG - <?=$jotag_name ?> - expired <?=OptionPeer::retrieveOption('BUY_DELETE_AFTER') ?> ago and was removed from your account
and is now available to all users.</p>