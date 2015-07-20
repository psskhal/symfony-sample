<?php if($sf_user->isAuthenticated()): ?>
<div class="top_menu">
	<?php echo link_to(__("Home"),"@homepage",array("class"=>"home")) ?>
	<?php echo link_to(__('My Account'),'@account') ?>
	<?php echo link_to(__('Contact Info'),'@contacts') ?>
	<?php echo link_to(__('Quick Contacts'),'@quick_contacts') ?>
	<?php echo link_to(__('Invites'),'@invite') ?>
	<?php echo link_to(__('Sign Out'),'@logout') ?>
</div>
<?php else: ?>
<div class="search png">
	<span><?php echo link_to(__('Login'),'@login') ?></span>
	<span><?php echo link_to(__("Help"),'@page?page=help') ?></span>
	<form action="<?=url_for('@search') ?>" method="post">
		<input value="<?php echo __("Get Jotag") ?>" class="sfield" name="search" />
		<input value="<?php echo __("Search") ?>" class="button" type="image" src="<?php echo image_path("jotag/bg-button.gif") ?>" />
	</form>
</div>
<?php endif; ?>