<?php slot('title',__('JoTAG - Configure')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Privacy mode for %jotag%',array("%jotag%"=>esc_entities($jotag->getJotag()))),'tshirts'=>true)) ?>
<p><?php echo __("There are three different privacy modes:") ?></p>
<br/><ul>
	<li><b><?php echo __("None") ?>:</b> <?php echo __("Anyone can view this JoTAG contact information, including non-registered users.") ?></li>
	<li><b><?php echo __("Captcha") ?>:</b> <?php echo __("Anyone can view this JoTAG contact information, including non-registered users. An anti-robot system (captcha) will be enabled to avoid robots from crawling for JoTAGs.") ?></li>
	<?php if(!$jotag->getIsPrimary()): ?>
		<li><b><?php echo __("Security Question") ?>:</b> <?php echo __("Anyone can view this JoTAG contact information, including non-registered users, but they will need to input the correct Answer for your Security Question to gain access to the information.") ?></li>
		<li><b><?php echo __("Authorization") ?>:</b> <?php echo __("Users that want to view this JoTAG contact information must ask for you to authorize them. Users must be registered and logged in.") ?></li>
	<?php endif; ?>
</ul><br/>
<form action="<?php echo url_for('@jotag_privacy?jotag='.$jotag->getJotag()) ?>" method="POST">
	<table width="100%" border="0">
		<tr>
			<td width="150px"><b><?php echo $form["privacy_type"]->renderLabel() ?>:</b></td>
			<td><?php echo $form["privacy_type"]->render(array('onchange'=>"\$\$('tr[rel=pin]').each(function (o) { if(\$('tag_privacy_privacy_type').value == '".TagPrivacyPeer::PRIVACY_PIN."') o.show(); else o.hide(); })")) ?></td>
		</tr>
		<tr rel="pin"<?php if($form["privacy_type"]->getValue() != TagPrivacyPeer::PRIVACY_PIN): ?> style="display:none"<?php endif; ?>>
			<td width="120px"><b><?php echo $form["pin_hint"]->renderLabel() ?>:</b></td>
			<td>
				<?php echo $form["pin_hint"]->render(array('size'=>30,'maxlength'=>100)) ?>
				<?php if($form["pin_hint"]->hasError()): ?>
					<font color="red">&larr; <?php echo $form["pin_hint"]->getError() ?></font>
				<?php endif; ?>
			</td>
		</tr>
		<tr rel="pin"<?php if($form["privacy_type"]->getValue() != TagPrivacyPeer::PRIVACY_PIN): ?> style="display:none"<?php endif; ?>>
			<td width="120px"><b><?php echo $form["pin"]->renderLabel() ?>:</b></td>
			<td>
				<?php echo $form["pin"]->render(array('size'=>'30','maxlength'=>'1000')) ?>
				<?php if($form["pin"]->hasError()): ?>
					<font color="red">&larr; <?php echo $form["pin"]->getError() ?></font>
				<?php endif; ?>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	    <tr>
	      <td colspan="2">
	        <input type="submit" name="submit" value="<?php echo __("Save") ?>" />
	        <?php echo button_to(__('Cancel'),"@configure?jotag=".$jotag->getJotag()) ?>
	      </td>
	    </tr>
	</table>
</form>