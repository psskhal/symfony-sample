<?php slot('title',__('JoTAG - %jotag% contacts',array('%jotag%'=>$jotag->getJotag()))) ?>
<?php  use_helper('Javascript'); ?>
<?php //$sf_user->getAttributeHolder()->remove('nextOption'); ?><br /><br />
<?php if($jotag->haveContacts()): ?>
	<?php
		// define strings to me used, based on security method for this jotag
		slot('captcha');
	?>
			<div class="captcha">
				<?php if($jotag->getTagPrivacy()->getPrivacyType() != TagPrivacyPeer::PRIVACY_CAPTCHA): ?><label><?php echo __("Enter the letters in the box below") ?>:</label><br /><?php endif ?>
				<?php echo $form['captcha']->render() ?>
				<?php if($form['captcha']->hasError()): ?>
					<font color="red">&larr; <?php echo $form["captcha"]->getError() ?></font>
				<?php endif ?>
			</div>
	<?php
		end_slot();
		
		switch($jotag->getTagPrivacy()->getPrivacyType()) {
			case TagPrivacyPeer::PRIVACY_CAPTCHA:
				slot('privacy_title',__('Captcha'));
				slot('privacy_description',__('%name%\'s contact details are protected with a anti-robot mechanism. Please enter the letters in the box below.',array(
					"%name%"	=> $jotag->getTagProfile()->getFirstName())
				));
				slot('privacy_form');
	?>
					<div class="secque">
						<h2><?php echo __('Captcha') ?></h2>
						<p><?php echo __('%name%\'s contact details are protected with a anti-robot mechanism. Please enter the letters in the box below.',array(
											"%name%"	=> $jotag->getTagProfile()->getFirstName()
										)) ?></p>
					</div>
					<form name="privacy_frm" method="post" action="<?php echo url_for('@view_jotag?jotag='.$jotag->getJotag()) ?>">
						<?php include_slot('captcha') ?>
						<input type="image" src="<?php echo image_path('jotag/'.$sf_user->getCulture().'/button-view.png') ?>" />
					</form>
	<?php
				end_slot();
				break;
			case TagPrivacyPeer::PRIVACY_AUTH:
				slot('privacy_form');
	?>
					<div class="secque">
						<h2><?php echo __('Authorization required') ?></h2>
							<?php if(!$sf_user->isAuthenticated()): ?>
								<p><?php echo __('Only authorized users are allowed to view %name%\'s contact details. If you are already a JoTAG member, click <a href="%link%">here</a> to login, otherwise, click <a href="%link2%">here</a> to create your JoTAG account now. After that you can go back to this page and request authorization.',array(
														"%name%"	=> $jotag->getTagProfile()->getFirstName(),
														'%link%'	=> url_for('@login_redirect?redirect='.$jotag->getJotag()),
														'%link2%'	=> url_for("@signup")
												)) ?></p>
							<?php elseif($jotag->getAuthStatus($sf_user->getSubscriber()) == TagAuthPeer::STATUS_PENDING): ?>
								<p><?php echo __('Only authorized users are allowed to view %name%\'s contact details. Your request was sent and you will be notified as soon as it\'s responded.',array(
													"%name%"	=> $jotag->getTagProfile()->getFirstName()
												)) ?></p>
							<?php elseif($jotag->getAuthStatus($sf_user->getSubscriber()) == TagAuthPeer::STATUS_DENIED): ?>
								<p><?php echo __('Only authorized users are allowed to view %name%\'s contact details, and your authorization request was denied.',array(
													"%name%"	=> $jotag->getTagProfile()->getFirstName()
												)) ?></p>
							<?php else: ?>
								<p><?php echo __('Only authorized users are allowed to view %name%\'s contact details. Click the button below to request authorization, and, optionally, enter a message to identify yourself.',array(
													"%name%"	=> $jotag->getTagProfile()->getFirstName()
												)) ?></p>
							<?php endif ?>
					</div>
					<?php if($sf_user->isAuthenticated()): ?>
						<?php if($jotag->getAuthStatus($sf_user->getSubscriber()) == TagAuthPeer::STATUS_NONE): ?>
							<form name="privacy_frm" method="post" action="<?php echo url_for('@view_jotag?jotag='.$jotag->getJotag()) ?>">
								<p><b><?php echo __('Message') ?></b></p>
								<?php echo $form["message"]->render(array('cols'=>50,'rows'=>4)) ?><br /><br />
								<?php include_slot('captcha') ?>
								<input type="submit" value="<?php echo __('Request Authorization') ?>" />
							</form>
						<?php endif; ?>
					<?php endif; ?>
                    
	<?php
				end_slot();
				break;
			case TagPrivacyPeer::PRIVACY_PIN:
			?>
            <?php
			slot('privacy_form');
			?>
			<div id="tagViewOptionDiv">
            <?php $nextOption = $sf_user->getAttribute('nextOption')?>
            <?php if($nextOption == "fck editor"): ?>
            <?php if(!$form['captcha']->hasError()): ?>
            <?php $sf_user->getAttributeHolder()->remove('nextOption');?>
            <?php endif; ?>
            <div class="secque">
						<h2><?php echo __('Authorization required') ?></h2>
							<?php if(!$sf_user->isAuthenticated()): ?>
								<p><?php echo __('Only authorized users are allowed to view %name%\'s contact details. If you are already a JoTAG member, click <a href="%link%">here</a> to login, otherwise, click <a href="%link2%">here</a> to create your JoTAG account now. After that you can go back to this page and request authorization.',array(
														"%name%"	=> $jotag->getTagProfile()->getFirstName(),
														'%link%'	=> url_for('@login_redirect?redirect='.$jotag->getJotag()),
														'%link2%'	=> url_for("@signup")
												)) ?></p>
							<?php elseif($jotag->getAuthStatus($sf_user->getSubscriber()) == TagAuthPeer::STATUS_PENDING): ?>
								<p><?php echo __('Only authorized users are allowed to view %name%\'s contact details. Your request was sent and you will be notified as soon as it\'s responded.',array(
													"%name%"	=> $jotag->getTagProfile()->getFirstName()
												)) ?></p>
							<?php elseif($jotag->getAuthStatus($sf_user->getSubscriber()) == TagAuthPeer::STATUS_DENIED): ?>
								<p><?php echo __('Only authorized users are allowed to view %name%\'s contact details, and your authorization request was denied.',array(
													"%name%"	=> $jotag->getTagProfile()->getFirstName()
												)) ?></p>
							<?php else: ?>
								<p><?php echo __('Only authorized users are allowed to view %name%\'s contact details. Click the button below to request authorization, and, optionally, enter a message to identify yourself.',array(
													"%name%"	=> $jotag->getTagProfile()->getFirstName()
												)) ?></p>
							<?php endif ?>
					</div>
					<?php if($sf_user->isAuthenticated()): ?>
						<?php if($jotag->getAuthStatus($sf_user->getSubscriber()) == TagAuthPeer::STATUS_NONE): ?>
							<form name="privacy_frm" method="post" action="<?php echo url_for('@view_jotag?jotag='.$jotag->getJotag()) ?>">
								<p><b><?php echo __('Message') ?></b></p>
								<?php echo $form["message"]->render(array('cols'=>50,'rows'=>4)) ?>
                                <br /><br />
                                <?php include_slot('captcha') ?>
								<input type="submit" value="<?php echo __('Request Authorization') ?>" />
							</form>
						<?php endif; ?>
					<?php endif; ?>
                    <br />
                    <br />
                    
                    <p><?php echo link_to_remote(__('[<< Back To Previous Option]'),array(
					'url'		=> '@next_option_back?jotag='.$jotag->getJotag(),
					'update'	=> 'tagViewOptionDiv',
					'script'	=> true)) ?></p><br/>    
                    <?php else: ?>
    				<div class="secque">
						<h2><?php echo __('Security question') ?></h2>
						<p><?php echo __('%name%\'s contact details are protected with a security question. Please please please answer the question to reveal his Jotag.',array(
											"%name%"	=> $jotag->getTagProfile()->getFirstName()
										)) ?></p>
					</div>
					<form name="privacy_frm" method="post" action="<?php echo url_for('@view_jotag?jotag='.$jotag->getJotag()) ?>">
						<h2><?php echo $jotag->getTagPrivacy()->getPinHint() ?></h2>
						<label><?php echo __("Your answer") ?>:</label>
						<br />
						<?php echo $form["pin"]->render() ?>
						<?php if($form["pin"]->hasError() && !$form["captcha"]->hasError()): ?><font color="red">&larr; <?php echo $form["pin"]->getError() ?></font><?php endif; ?>
						<br />
						<?php include_slot('captcha') ?>
						<input type="image" src="<?php echo image_path('jotag/'.$sf_user->getCulture().'/button-view.png') ?>" />
					</form>
                    <br />
                    <p><?php echo link_to_remote(__('[Try Next Option]'),array(
					'url'		=> '@next_option?jotag='.$jotag->getJotag(),
					'update'	=> 'tagViewOptionDiv',
					'script'	=> true)) ?></p><br/>  
                    <?php endif; ?>                 
				
                </div>
                <?php
				end_slot();
				break;
		}
	?>
<?php else: ?>
	<?php
		slot('privacy_form');
	?>
		<div class="secque">
			<h2><?php echo __('No contacts') ?></h2>
			<p><?php echo __('This Jotag has no contact information',array(
							)) ?></p>
		</div>
	<?php end_slot(); ?>
<?php endif; ?>
		<div class="user_name">
			<h1><?php echo $jotag->getTagProfile() ?></h1>
		</div>
		
		<div class="unloack">
		
			<div class="col1_u">
				<div class="user_img">
					<?=image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$jotag->getTagProfile()->getPhoto(),array('width'=>'218px')) ?>
				</div>
			</div>
		
			<div class="col2_u">
				<?php include_slot('privacy_form') ?>
			</div>
			
		</div>