<?php slot('title',__('JoTAG - Details')) ?>
<?include_partial("global/header",array('title'=>__('Receipt for %jotag%',array("%jotag%"=>esc_entities($jotag->getJotag()))),'tshirts'=>true)) ?>
	<p align="center">
		<b><?php echo __("JoTAG valid until <em>%date%</em>",array("%date%"=>$jotag->getValidUntil('m/d/Y'))) ?>
		<?php if ($jotag->getStatus() == TagPeer::ST_EXPIRED): ?>
			- <font color="red"><b><i><?php echo __("EXPIRED") ?></i></b></font>
			<br/>
			<b><i><?php echo __("Your JoTAG is expired, renew it now clicking <a href=\"%link%\">here</a>!",array("%link%"=>url_for('@buy_step2?jotag='.$jotag->getJotag()))) ?></i></b><br/>
			<b><i><?php echo __("If you don't want to renew it and wants to remove it from your account, click <a href=\"%link%\">here</a>!",array("%link%"=>url_for('@cancel_jotag?jotag='.$jotag->getJotag()))) ?></i></b>  
		<?php else: ?>
			- <?=link_to(__('Renew now!'),'@buy_step2?jotag='.$jotag->getJotag()) ?></b>
		<?php endif; ?>
	</p>
	<?php if($jotag->getIsCredit() && $user->canReceiveCredits()): ?>
	<p align="center">
		<b><?php echo __("Tell your friends about your personalized JoTAG and we will expand duration of this JoTAG in %count% days for each friend that signs up!",array("%count%"=>OptionPeer::retrieveOption('BONUS_ACCEPT_CREDIT') * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT'))) ?></b><br/>
		<?=button_to(__('Invite friends'),'@invite') ?>
	</p>
	<?php endif; ?>

	<?php if ($sf_user->hasFlash('message')): ?>
		<p class="success"><?=$sf_user->getFlash('message') ?></p>
	<?php endif; ?>
	<br/>
	<p><b><?php echo __("Payments history") ?>:</b></p>
	<?php foreach ($payments as $payment): ?>
		<table>
			<tr><td><b><?php echo __("Order #") ?>:</b></td><td><?=$payment->getPaymentNumber() ?></td></tr>
			<tr><td><b><?php echo __("Date") ?>:</b></td><td><?=$payment->getCreatedAt() ?></td></tr>
			<tr><td><b><?php echo __("Payment Method") ?>:</b></td><td><?=__(PaymentPeer::$PAYMENT_METHODS[$payment->getMethod()]) ?></td></tr>
			<?php if ($payment->getMethod() != PaymentPeer::PT_CREDITS): ?>
				<tr><td><b><?php echo __("Duration") ?>:</b></td><td><?=$payment->getDuration() ?> <?=PaymentPeer::getYearString($payment->getDuration(),false) ?></td></tr>
				<tr><td><b><?php echo __("Total Paid") ?>:</b></td><td><?=sprintf(OptionPeer::retrieveOption('CURRENCY_FORMAT'),$payment->getAmount()) ?></td></tr>
			<?php else: ?>
				<tr><td><b><?php echo __("Duration") ?>:</b></td><td><?=$payment->getDuration() ?> <?php echo __("days") ?></td></tr>
			<?php endif; ?>
		</table><br/>
	<?php endforeach; ?>