<?php if($sf_user->isAuthenticated()): ?>
	<?php slot('menu')?>
    <?php $myTags=count($sf_user->getSubscriber()->getValidTags(0))?>
		<ul>
			<?php foreach($sf_user->getSubscriber()->getValidTags(2) as $k=>$tag): ?>
				<li><?php echo link_to($tag->getJotag(),'@configure?jotag='.$tag->getJotag(),array("class"=>"bgc".($k+1))) ?></li>
			<?php endforeach; ?>
			<li>
				<?php echo link_to(__('+ Add Jotag'),'@buy',array("class"=>"bgc".($k+2))) ?>
				<?php if(@$baloon): ?>
                <?php if(@$thiscount>1 && $myTags<2): ?>
					<span class="over_title" id="baloonSpanP" style="position:absolute;"><span style="position:relative; float:right; padding-right:5px;"><img src="./images/jotag/close.png" style="cursor:pointer;" onclick="document.getElementById('baloonSpanP').style.display='none';" /></span><em><?php echo __("Check this out! You can have more than one Jotag on your account!<br />For example, you would want to show some of your details to your  business partners, but different ones to your family. You can select which exact contact details will be visible on every single Jotag you create.")?></em></span>
                 <?php endif ?>
				<?php endif ?>
			</li>
		</ul>	
	<?php end_slot() ?>
<?php endif; ?>