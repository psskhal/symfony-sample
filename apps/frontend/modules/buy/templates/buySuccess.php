<?php slot('title',__('JoTAG - Buy JoTAG')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Get JoTAG'))) ?>
	<?php if($step > 2): ?><?=image_tag('paypal.gif',array('align'=>'right','title'=>__('Powered by Paypal'))) ?><?php endif; ?>
	<?php if ($sf_user->hasFlash('message')): ?>
		<div id="message_<?=strtolower($sf_user->getFlash('type')) ?>">
			<?php 
				switch($sf_user->getFlash('message'))
				{
					case "BUY_CANCEL": print __("Your transaction was cancelled"); break;
				}
			?>
		</div>	
	<?php endif; ?>
	<?php if ($form["jotag"]->hasError()): ?>
		<p class="error"><?=$form["jotag"]->getError() ?></p>
		<?php if (@$already_exists && !$user->hasInterest(@$already_exists)): ?>
			<p><b><?php echo __("You can add this JoTAG to your interest list and you will be notified as soon as it becomes available again. Also, the owner will be notified.") ?> <?=__("<a href=\"%link%\">Click here</a> to add this JoTAG to you interest list.",array("%link%"=>url_for('@add_interest?jotag='.$already_exists->getJotag()))) ?></b></p>	
		<?php endif; ?>
	<?php endif; ?>
		<?php if ($step == 1): ?>
		<p><?php echo __("Step 1 - Search availability") ?>:</p>
		<?php if($suggestions): ?>
			<p><?php echo __("These JoTAGs are still available:") ?></p>
				<ul style="margin-left:30px;">
					<?php $sc = 0; foreach($suggestions as $s): ?>
						<li><?php echo link_to($s,"@buy_step2?jotag=".$s) ?></li>
					<?php if(++$sc == 4) break; endforeach; ?>
				</ul>
		<?php endif; ?>
		<form action="<?php echo url_for('@buy') ?>" method="POST">
		  <table>
		  	<tr>
		  		<td><b><?=$form["jotag"]->renderLabel() ?>:</b></td>
		  		<td><?=$form["jotag"]->render() ?></td>
		  	</tr>
		    <tr>
		      <td colspan="2">
		        <input type="submit" name="submit" value="<?php echo __("Check availability") ?>"/>
		      </td>
		    </tr>
		  </table>
		</form>
		<?php elseif ($step == 2): ?>
		<p><?php echo __("Step 2 - Select duration") ?>:</p>
		<form action="<?php echo url_for('@buy') ?>" method="POST">
		  <input type="hidden" name="step" value="2" />
		  <?php if ($jotag_object): ?>
		  <p><b><?php echo __("This JoTAG is already yours! Continue the process in order to renew it.") ?></b></p>
		  <?php else: ?>
   		  <p><b><?php echo __("Good news! The JoTAG you requested is available!") ?></b></p>
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
		  		<td><b><?=$form["duration"]->renderLabel() ?>:</b></td>
		  		<td>
		  			<?=$form["duration"]->render() ?>
		  			<?php if ($form["duration"]->hasError()): ?>
						<span class="error"><?=$form["duration"]->getError() ?></span>	
					<?php endif; ?>
		  		</td>
		  	</tr>
		    <tr>
		      <td colspan="2">
		        <input type="submit" name="submit" value="<?php echo __("Continue") ?>"/>
		        <?=button_to(__('Cancel'),'@account') ?>
		      </td>
		    </tr>
		  </table>
		</form>
		<?php else: ?>
		<p><?php echo __("Step 3 - Confirm your request") ?>:</p>
		  <table>
		  	<tr>
		  		<td><b><?=$form["jotag"]->renderLabel() ?>:</b></td>
		  		<td><?=$form["jotag"]->getValue() ?><?=$form["jotag"]->render() ?><?=$form["confirm_jotag"]->render() ?></td>
		  	</tr>
		  	<tr>
		  		<td><b><?=$form["duration"]->renderLabel() ?>:</b></td>
		  		<td><?=$form["duration"]->getValue() ?> <?=PaymentPeer::getYearString($form["duration"]->getValue(),false) ?><?=$form["duration"]->render() ?></td>
		  	</tr>
		  	<tr>
		  		<td><b><?php echo __("Price") ?>:</b></td>
		  		<td><?=sprintf(OptionPeer::retrieveOption('CURRENCY_FORMAT'),$form["duration"]->getValue()*OptionPeer::retrieveOption('BUY_PRICE')) ?><br /><?php echo $form["country_id"]->render();?></td>
		  	</tr>
		    <tr>
		      <td colspan="2">
				<form id="frmSend2PayPal" action="<?php if (OptionPeer::retrieveOption('PAYPAL_MODE') != 'L'): ?>https://www.sandbox.paypal.com/cgi-bin/webscr<?php else: ?>https://www.paypal.com/cgi-bin/webscr<?php endif; ?>" method="post" id="frmPaypal">
					<input type="hidden" name="cmd" value="_xclick" />
					<input type="hidden" name="business" value="<?=OptionPeer::retrieveOption('PAYPAL_ACCOUNT') ?>" />
					<?php if ($jotag_object): ?>
						<input type="hidden" name="custom" value="RENEW" />
						<input type="hidden" name="item_name" value="<?php echo format_number_choice("[1]Personalized JoTAG - Extra %count% year|[1,+Inf]Personalized JoTAG - Extra %count% years",array("%count%"=>$payment->getDuration()),$form["duration"]->getValue()) ?> (<?=$payment->getTag()->getJotag() ?>)" />
					<?php else: ?>
						<input type="hidden" name="custom" value="NEW" />
						<input type="hidden" name="item_name" value="<?php echo format_number_choice("[1]Personalized JoTAG - %count% year|[1,+Inf]Personalized JoTAG - %count% years",array("%count%"=>$payment->getDuration()),$form["duration"]->getValue()) ?> (<?=$payment->getJotag() ?>)" />
					<?php endif; ?>
					<input type="hidden" name="item_number" value="1" />
					<input type="hidden" name="amount" value="<?=$payment->getAmount() ?>" />
					<input type="hidden" name="rm" value="2" />
					<input type="hidden" name="return" value="<?=url_for('@buy_process',true) ?>" />
					<input type="hidden" name="cancel_return" value="<?=url_for('@buy_cancel',true) ?>" />
					<input type="hidden" name="currency_code" value="USD" />
					<input type="hidden" name="country" value="US" />
					<input type="hidden" name="no_shipping" value="1" />
					<input type="hidden" name="no_note" value="1" />
					<input type="hidden" name="invoice" value="<?=$payment->getId() ?>" />
					<img alt="" id="btnPaypal" src="/img/common/paypal.gif" />
					<input type="submit" name="submit" value="<?php echo __("Confirm") ?>"/>
					<?=button_to(__('Cancel'),'@buy_cancel') ?>
				</form>
		      </td>
		    </tr>
		  </table>
		<?php endif; ?>