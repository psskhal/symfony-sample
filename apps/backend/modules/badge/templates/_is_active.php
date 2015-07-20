<?php if($badge->getIsDefault()): ?>
		<?= $badge->getIsActive() ? image_tag(sfConfig::get('sf_admin_web_dir').'/images/tick.png') : image_tag('sf_admin/x.png') ?>
<?php else: ?>
	<?php echo link_to($badge->getIsActive() ? image_tag(sfConfig::get('sf_admin_web_dir').'/images/tick.png') : image_tag('sf_admin/x.png'),'badge/toggleActive?id='.$badge->getId(),array('title'=>$badge->getIsActive()?'Disable this badge':'Enable this badge')) ?>
<?php endif; ?>