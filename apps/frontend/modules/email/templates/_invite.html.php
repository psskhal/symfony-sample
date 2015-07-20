<?php if (@$email["first_name"] || @$email["last_name"]): ?><p>Dear <?=trim($email["first_name"]." ".$email["last_name"]) ?>,</p><?php endif; ?>
<p>You were invited joint JoTAG by your friend <?=$user ?>! Click the following link and complete your registration and receive <?=OptionPeer::retrieveOption('BONUS_INVITE_CREDIT') * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT') ?> free days to get a personalized JoTAG:</p>
<p><?=link_to(url_for('@signup_invite?invite_id='.$invite->getId(),true),'@signup_invite?invite_id='.$invite->getId(),array("absolute"=>true)) ?></p>
<?php if($invite->getInviteTagsJoinTag()): ?>
<p><?=$user ?>'s JoTAGs:</p>
<ul>
	<?php foreach($invite->getInviteTagsJoinTag() as $tag): ?>
		<li><?=$tag->getTag()->getJotag() ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php if ($message): ?>
<p>----<br/><?=nl2br(esc_entities($message)) ?><br/>----</p>
<?php endif; ?>