<fieldset>
	<h2>Profile</h2>
	<table width="100%">
		<tr>
			<td valign="top">
				<?=$form["profile"]->getWidget()->getWidget()->render(null,$form["profile"]->getValue(),array(),$form["profile"]->getError()) ?>
			</td>
			<td width="150px">
				<?=image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$user->getProfile()->getPhoto(),array('width'=>'150px')) ?>
			</td>
		</tr>
	</table>
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