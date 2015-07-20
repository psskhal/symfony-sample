<?php slot('title',__('JoTAG - Quick Contacts')) ?>
<?php slot('help','Here goes some help about quick contact page') ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Quick Contacts'))) ?>
	<?php if (count($contacts)): ?>
		<form action="<?=url_for('@del_quick_contacts')?>" method="post" onsubmit="if(!$$('#contact_list input[type=checkbox]').findAll(function (o) { return o.checked; }).length) { alert('<?php echo __("No contacts were selected, please select one or more and try again") ?>'); return false; } return window.confirm('<?php echo __("Are you sure you want to remove selected JoTAGs from your quick contact list?") ?>')">
			<table>
			  <thead>
				  <tr>
				    <th><input type="checkbox" name="chkAll" id="chkAll" onclick="$$('#contact_list input[type=checkbox]').each(function (o) {o.checked = $('chkAll').checked; })" /></th>
				    <th width="100px">JoTAG</th>
				    <th width="500px"><?php echo __("Name") ?></th>
				  </tr>
			  </thead>
			  <tbody id="contact_list">
				  <?php foreach ($contacts as $contact): ?>
					<tr>
						<td><input type="checkbox" name="jotags[]" value="<?=$contact->getTag()->getJotag() ?>"/></td>
						<td><?=link_to(strtoupper($contact->getTag()->getJotag()),'@view_jotag?jotag='.$contact->getTag()->getJotag()) ?></td>
						<td><?=$contact->getTag()->getTagProfile() ?></td>
					</tr>
				  <?php endforeach; ?>
			  </tbody>
			</table>
			<p><input type="submit" value="<?php echo __("Remove") ?>" /></p>
		</form>
	<?php else: ?>
		<p align="center"><i><?php echo __("You don't have any quick contacts") ?></i></p>
	<?php endif; ?>