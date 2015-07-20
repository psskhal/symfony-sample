<?php $jotag = new Tag();?>
<?php echo $jotag->getTagProfile() ?>
<div id="authodiv" style="display:;">
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
                    <br /><br />
                    <div style="float:right;">
                    <a href="#" onclick="document.getElementById('pindiv').style.display='block'; document.getElementById('authodiv').style.display='none';">Back To Previous Option</a>
                    </div>
                    </div>