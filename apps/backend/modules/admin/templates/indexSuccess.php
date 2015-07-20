<?php use_helper("I18N") ?>
<div id="sf_admin_container">
	<h1><?=__("Dashboard") ?></h1>
	
	<div id="cpanel">
		<div style="float:left;">
			<div class="icon">
				<?=link_to(image_tag('sf_admin/config.png',array('alt'=>__("Global Options"),'align'=>'middle','border'=>0)).'<span>'.__("Global Options").'</span>','options/index') ?> 
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<?=link_to(image_tag('sf_admin/langmanager.png',array('alt'=>__("Language Manager"),'align'=>'middle','border'=>0)).'<span>'.__("Language Manager").'</span>','language/index') ?> 
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<?=link_to(image_tag('sf_admin/user.png',array('alt'=>__("User Manager"),'align'=>'middle','border'=>0)).'<span>'.__("User Manager").'</span>','user/index') ?> 
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<?=link_to(image_tag('sf_admin/cpanel.png',array('alt'=>__("JoTAG Manager"),'align'=>'middle','border'=>0)).'<span>'.__("JoTAG Manager").'</span>','tag/index') ?> 
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<?=link_to(image_tag('sf_admin/categories.png',array('alt'=>__("Badge Manager"),'align'=>'middle','border'=>0)).'<span>'.__("Badge Manager").'</span>','badge/index') ?> 
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<?=link_to(image_tag('sf_admin/messaging.png',array('alt'=>__("Email Manager"),'align'=>'middle','border'=>0)).'<span>'.__("Email Manager").'</span>','email/index') ?> 
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<?=link_to(image_tag('sf_admin/generic.png',array('alt'=>__("Article Manager"),'align'=>'middle','border'=>0)).'<span>'.__("Article Manager").'</span>','article/index') ?> 
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<?=link_to(image_tag('sf_admin/query.png',array('alt'=>__("Order Manager"),'align'=>'middle','border'=>0)).'<span>'.__("Order Manager").'</span>','payment/index') ?> 
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>