<?php if($badge->getIsDefault()): ?>
	<?=image_tag(sfConfig::get('sf_admin_web_dir').'/images/tick.png')?>
<?php else: ?>
	<?php echo link_to(image_tag('sf_admin/x.png'),'badge/setDefault?id='.$badge->getId(),array('title'=>'Set as default')) ?>
<?php endif; ?>