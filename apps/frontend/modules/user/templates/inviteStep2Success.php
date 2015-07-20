<?php slot('title',__('JoTAG - Invite Friends')) ?>
<?use_helper('Javascript') ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Invite Friends'))) ?>
	<form action="<?=url_for('@invite') ?>" method="post" onsubmit="if(!$$('#lstEmails input[type=checkbox]').findAll(function (o) { return o.checked; }).length) { alert('<?php echo __("No contacts were selected, please select one or more and try again") ?>'); return false; }">
		<input type="hidden" name="step" value="step2" />
		<table width="700px">
			<tr>
				<td align="right" valign="top"><b><?php echo __("To") ?>:</b></td>
				<td>
					<table width="100%" cellspacing="0px" cellpadding="0px">
						<thead>
							<tr>
								<th width="20px" align="left"><input type="checkbox" name="chkAll" id="chkAll" onclick="$$('#lstEmails input[type=checkbox]').each(function (o) {o.checked = $('chkAll').checked; })" checked /></th>
								<th width="250px" align="left"><?php echo __("Name") ?></th>
								<th align="left"><?php echo __("Email") ?></th>
							</tr>
						</thead>
					</table>
					<div id="lstEmails">
						<table width="100%" cellspacing="0px" cellpadding="0px">
							<tbody>
							<?php $k=0; foreach ($emails as $email): ?>
								<?php if($email["email"]): ?>
									<tr>
										<td width="20px">
											<?php if(!$email["registered"]): ?>
												<input type="hidden" name="invite[emails][<?=$k ?>][first_name]" value="<?=esc_entities($email["first_name"]) ?>" />
												<input type="hidden" name="invite[emails][<?=$k ?>][last_name]" value="<?=esc_entities($email["last_name"]) ?>" />
												<input type="hidden" name="invite[emails][<?=$k ?>][email]" value="<?=esc_entities($email["email"]) ?>" />
											<?php endif; ?>
											<input type="checkbox" name="chkEmail[]" value="<?=$k ?>" <?php if($email["registered"]): ?>disabled<?php else: ?>checked<?php endif; ?> />
										</td>
										<td width="250px"><?=esc_entities(substr(trim($email["first_name"]." ".$email["last_name"]),0,30)) ?></td>
										<td><?=esc_entities(substr($email["email"],0,45)) ?><?php if($email["registered"]): ?> <em>(<?php echo __("already member") ?></em><?php endif; ?></td>
									</tr>
									<?php if(!$email["registered"]) $k++; ?>
								<?php endif; ?>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</td>			
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<b><?php echo __("Let my friends know about the following JoTAGs") ?>:<br/></b>
					<?php foreach($user->getValidTags() as $tag): ?>
						<input type="checkbox" name="jotags[]" value="<?=$tag->getJotag() ?>" checked /> <?=$tag->getJotag() ?>
					<?php endforeach; ?>
				</td>
			</tr>
			<tr>
				<td align="right" valign="top"><b><?php echo __("Message") ?>:</b></td>
				<td>
					<textarea name="message" style="width:100%" rows="5"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="<?php echo __("Send") ?>" />
				</td>
			</tr>
		</table>
	</form>