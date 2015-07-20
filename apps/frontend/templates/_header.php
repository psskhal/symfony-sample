<?php slot('banner') ?>
<?php if($sf_user->isAuthenticated() && @$tshirts): ?>
	<div id="inside-banner" class="_<?=count($sf_user->getSubscriber()->getValidTags(4)) ?>tshirt">
	<h1><?=$title ?></h1>
	<?php foreach($sf_user->getSubscriber()->getValidTags(4) as $k=>$tag): ?>
		<div id="tshirt<?=$k+1 ?>"><?=link_to($tag->getJotag(),'@configure?jotag='.$tag->getJotag()) ?></div>
	<?php endforeach; ?>
<?php else: ?>
	<div id="inside-banner" class="<?php echo $class ?>">
	<h1><?=$title ?></h1>
	<?php if(@$bubble): ?><div id="bubble_text"><?php echo $bubble; ?></div><?php endif; ?>
<?php endif; ?>
</div>
<?php end_slot() ?>
