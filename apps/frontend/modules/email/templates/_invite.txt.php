<?php if (@$email["first_name"] || @$email["last_name"]): ?>Dear <?=trim($email["first_name"]." ".$email["last_name"]) ?>,<?php endif; ?>

You were invited joint JoTAG by your friend <?=$user ?>! Click the following link and complete your registration and receive <?=OptionPeer::retrieveOption('BONUS_INVITE_CREDIT') * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT') ?> free days to get a personalized JoTAG:
<?=url_for('@signup_invite?invite_id='.$invite->getId(),true) ?>

<?php if($invite->getInviteTagsJoinTag()): ?>

<?=$user ?>'s JoTAGs:
<?php foreach($invite->getInviteTagsJoinTag() as $tag): ?>
    <?=$tag->getTag()->getJotag() ?>
		
<?php endforeach; ?>
<?php endif; ?>
<?php if ($message): ?>

----
<?=$message ?>

----
<?php endif; ?>