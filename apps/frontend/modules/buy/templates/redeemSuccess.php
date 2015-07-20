<?php slot('title',__('JoTAG - Redeem Credits')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Get JoTAG'))) ?>
	<?php if ($form["jotag"]->hasError()): ?>
		<p class="error"><?=$form["jotag"]->getError() ?></p>
	<?php endif; ?>
	<?php if ($step == 2): ?>
		<p><?php echo __("Step 2 - Confirm your request") ?>:</p>
		<form action="<?php echo url_for('@buy') ?>" method="POST">
		  <input type="hidden" name="step" value="2" />
		  <?php if ($jotag_object): ?>
		  	<p><b><?php echo __("This JoTAG is alreayd yours! Continue the process in order to renew it.") ?><br/>
		  	<?php echo __("You can extend this JoTAG duration in %count% days, using your available credits. Just confirm your request!",array("%count%"=>$user->getCredits() * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT'))) ?></b></p>
		  <?php else: ?>
	   	  	<p><b><?php echo __("Good news! The JoTAG you requested is available!") ?><br/>
	   	  	<?php echo __("You can get this JoTAG for FREE for %count% days, using your available credits. Just confirm your request and it will be yours!",array("%count%"=>$user->getCredits() * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT'))) ?></b></p>
	   	  <?php endif; ?>
		  <table>
		  	<tr>
		  		<td><b><?=$form["jotag"]->renderLabel() ?>:</b></td>
		  		<td><?=$form["jotag"]->getValue() ?><?=$form["jotag"]->render() ?></td>
		  	</tr>
		  	<tr>
		  		<td><b><?=$form["confirm_jotag"]->renderLabel() ?>:</b></td>
		  		<td><?=$form["confirm_jotag"]->render() ?></td>
		  	</tr>
		  	<tr>
		  		<td><b><?php echo __("Duration") ?>:</b></td>
		  		<td><?php echo __("%count% days",array("%count%"=>$user->getCredits() * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT'))) ?></td>
		  	</tr>
		    <tr>
		      <td colspan="2">
		        <input type="submit" name="submit" value="<?php echo __("Confirm") ?>"/>
		        <?=button_to(__('Cancel'),'@account') ?>
		      </td>
		    </tr>
		  </table>
		</form>
	<?php else: ?>
		<div id="message_success">
			<?php if ($payment->getType() == PaymentPeer::PT_RENEW): ?>
				<?php echo __("Your credits was successfully redeemed. Expiration date of you JoTAG (%jotag%) was updated",array("%jotag%"=>$jotag->getJotag())) ?>
			<?php else: ?>
				<?php echo __("Your credits was successfully redeemed. Your new JoTAG (%jotag%) is already available on your account",array("%jotag%"=>$jotag->getJotag())) ?>
			<?php endif; ?>
		</div>
		<?php if($user->canReceiveCredits()): ?>
			<p align="center">
				<b><?php echo __("Tell your friends about your personalized JoTAG and we will expand duration of your new JoTAG in %count% days for each friend that signs up!",array("%count%"=>OptionPeer::retrieveOption('BONUS_ACCEPT_CREDIT') * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT'))) ?></b><br/><br/>
				<?=button_to(__('Invite friends'),'@invite') ?> <?=button_to(__('Not now'),'@account') ?>
			</p>
		<?php else: ?>
			<p align="center"><?=button_to(__('Return to My Account'),'@account') ?></p>
		<?php endif; ?>
	<?php endif; ?>