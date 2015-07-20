<?php use_helper('Date'); ?>
<?php slot('title',__('Jotag - Account')) ?>

<?php 
$thiscount=count($emails)+count($addresses)+count($phones)+count($urls)+count($sns)+count($ims);
?>

<?php include_partial('global/tag_menu',array("baloon"=>true,"thiscount"=>$thiscount))?>
<?php slot('header',__('My Account')) ?>

<div class="user_name">
	<h1><?php echo $user ?></h1>
</div>
		<div class="your_account">
		
			<?php if ($sf_user->hasFlash('message')): ?>
				<div id="message_<?=strtolower($sf_user->getFlash('type')) ?>">
					<?php 
						switch($sf_user->getFlash('message'))
						{
							case "ADD_INTEREST": print __("JoTAG %jotag% was successfully added to your interest list",array("%jotag%"=>$sf_user->getFlash('params'))); break;
							case "DEL_INTEREST": print __("JoTAG %jotag% was successfully removed from your interest list",array("%jotag%"=>$sf_user->getFlash('params'))); break;
							case "CANCEL_JOTAG": print __("Your JoTAG %jotag% was cancelled and removed from your account",array("%jotag%"=>$sf_user->getFlash('params'))); break;
							case "JOTAG_CONFIGURED": print __("Your JoTAG %jotag% was successfully configured",array("%jotag%"=>$sf_user->getFlash('params'))); break;
						}
					?>
				</div>	
			<?php endif; ?>

			<div class="col1_a">
				<div class="user_img">

					<?php echo image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$user->getProfile()->getPhoto(),array('width'=>'218px')) ?>
				</div>
				
				<p class="change_photo"><?php echo link_to(__('[change Photo]'),'@photo') ?></p>
				
				<!-- <p><strong>Location:</strong> Tampico, Mexico</p> -->
				<p class="lastupdate"><em><?php echo __("last update:") ?></em><br/>&nbsp;&nbsp;<?php echo format_date($user->getProfile()->getUpdatedAt(),'D') ?></p>
				
				<!-- <div class="time night">
					<p>CURRENT TIME <em>23:35 PM</em></p>
				</div> -->
			</div>
			<div class="col2_a">
				<div class="section">
					<h2><?php echo __("Connection Settings") ?></h2>
						<p><strong><?php echo __("E-Mail")?>:</strong> <span></span></p>
						
						<?php foreach ($user->getEmails() as $email): ?>
							<?php if($email->getIsConfirmed()): ?>
								<p>
									<span>&nbsp;&nbsp;
										<?=$email->getActualEmail()?$email->getActualEmail():$email->getEmail() ?>
										<?php if ($email->getIsPrimary()): ?>
											(<em><?php echo __("primary address") ?></em>)	
										<?php endif; ?>
									</span>
								</p>
							<?php endif; ?>
						<?php endforeach; ?>
						
						<p><strong><?php echo __("Password") ?>:</strong><span>*******</span><span class="actions"><?php echo link_to(__('change password'),'@password') ?></span></p>
						
				</div>
				<div class="section">
					<h2>Jotags</h2>
					
					<?php if ($user->getCredits()): ?>
						<div class="notification"><?php echo __("You have %count% days in credits to get a free JoTAG.",array("%count%"=>$user->getCredits() * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT'))) ?> <?=link_to(__('Get it Now!'),'@buy')?></div> 
					<?php endif; ?>

					<?php foreach ($user->getValidTags() as $jotag): ?>
						<p>
							<strong><?php echo esc_entities($jotag->getJotag()) ?></strong>
							<span>
								<?php if($jotag->getIsPrimary()): ?><em><?php echo __("permanent Jotag") ?></em>
								<?php elseif($jotag->getStatus() == TagPeer::ST_EXPIRED): ?><em><font color="red"><?php echo __("this Jotag has expired") ?></font></em><?php endif; ?>
							</span>
							<span class="actions">
								<?php if($jotag->getTagAuths(TagAuthPeer::buildPendingCriteria())): ?>
									<?php echo link_to(__('%count% pending requests',array(
										'%count%'=>count($jotag->getTagAuths(TagAuthPeer::buildPendingCriteria()))
									)),'@manage_auth_request?jotag='.$jotag->getJotag()) ?> |
								<?php endif; ?>
								<?php if (!$jotag->getIsPrimary()): ?>
								<?=link_to(__('receipt'),'@receipts?jotag='.$jotag->getJotag()) ?> |
								<?php endif; ?>
								<?=link_to(__('configure'),'@configure?jotag='.$jotag->getJotag()) ?>
							</span>
						</p>
					<?php endforeach; ?>
				</div>
				
				<?php if($user->getInterests()): ?>
					<div class="section">
						<h2><?php echo __("Interested JoTAGs") ?></h2>
						<?php foreach ($user->getInterests() as $interest): ?>
							<p>
								<strong><?php echo esc_entities($interest->getJotag()) ?></strong>
								<span>
									<?php if ($interest->isAvailable()): ?>
										<?php echo __("this Jotag is available!")?>
									<?php endif; ?>	
								</span>
								<span class="actions">
									<?php if ($interest->isAvailable()): ?>
										<b><?=link_to(__('Get it Now!'),'@buy_step2?jotag='.$interest->getJotag()) ?></b> |
									<?php endif; ?>
									<?=link_to(__('remove'),'@del_interest?jotag='.$interest->getJotag()) ?>
								</span>
							</tr>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				
				<div class="section">
					<h2><?php echo __("Personal Info") ?> - <?php echo link_to(__('edit'),'@profile') ?></h2>
					<p><strong><?php echo __("First Name") ?>:</strong> <span><?php echo $user->getProfile()->getFirstName() ?></span></p>
					<p><strong><?php echo __("Last Name") ?>:</strong> <span><?php echo $user->getProfile()->getLastName() ?></span></p>
					<p><strong><?php echo __("Language") ?>:</strong> <span><?php echo $user->getProfile()->getLanguage() ?></span></p>
				</div>
			</div>
		</div>