<fieldset>
	<h2>Details</h2>
	<table width="100%">
		<tr>
			<td valign="top">
				<?php echo $form["name"]->renderRow() ?>
				<?php echo $form["template"]->renderRow() ?>
				<?php echo $form["thumbnail"]->renderRow() ?>
				<?php echo $form["is_active"]->renderRow() ?>
			</td>
			<td width="150px">
				<?=image_tag(sfConfig::get('sf_badgeimage_dir_name').'/'.$badge->getThumbnail(),array('width'=>'150px')) ?>
			</td>
		</tr>
	</table>
</fieldset>