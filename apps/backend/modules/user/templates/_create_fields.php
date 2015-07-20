<fieldset>
	<h2>Profile</h2>
	<?=$form["profile"]->getWidget()->getWidget()->render(null,$form["profile"]->getValue(),array(),$form["profile"]->getError()) ?>
	<?=$form["email"]->renderRow() ?>
</fieldset>
<fieldset>
	<h2>Details</h2>
	<div class="form-row">
 		<label for="user_invited_by">Invited by</label>
		<div class="content"><?=$user->getUserRelatedByInvitedBy()?link_to($user->getUserRelatedByInvitedBy()." (".$user->getUserRelatedByInvitedBy()->getPrimaryEmail().")","user/edit?id=".$user->getUserRelatedByInvitedBy()->getId()):"<i>".__("Not invited")."</i>" ?></div>
	</div>
	<?=$form["credits"]->renderRow() ?>
</fieldset>
<fieldset>
	<h2>Password</h2>
	<?=$form["passwd"]->renderRow() ?>
	<?=$form["confirm_password"]->renderRow() ?>
</fieldset>