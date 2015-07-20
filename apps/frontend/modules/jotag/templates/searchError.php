<?php slot('title',__('JoTAG - Search Result')) ?>
<?php slot('contents_class',"contact") ?>
<?php use_helper('Javascript'); ?>
<?include_partial("global/header",array(
	'class'=>'header_temporary',
	'title'=>__('Search'))) ?>

<div id="buttons">
	<div class="text">
		<br/>
		<p><b><?php echo __("The JoTAG you've searched does not exists.") ?></b></p>
		<?php if(TagPeer::isAvailable($search_jotag)): ?>
			<?php if ($sf_user->isAuthenticated()): ?>
				<p><b><?php echo __("This JoTAG can be yours! Just click <a href=\"%link%\">here</a> to get it for you.",array("%link%"=>url_for('@buy_step2?jotag='.$sf_request->getParameter('search')))) ?>
				<?php if ($sf_user->getSubscriber()->getCredits()): ?>
					<?php echo __("You can have this JoTAG for %count% days for free.",array("%count%"=>$sf_user->getSubscriber()->getCredits() * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT'))) ?>
				<?php else: ?> 
				<?php endif; ?>
				</b></p>
			<?php else: ?>
				<p><b><?php echo __("This JoTAG can be yours! Just click <a href=\"%link%\">here</a> to signup.",array("%link%"=>url_for('@signup'))) ?></b></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>