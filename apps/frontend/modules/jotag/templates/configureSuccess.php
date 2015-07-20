<?php use_helper('Date'); ?>
<?php slot('title',__('Jotag - Account')) ?>
<?php include_partial('global/tag_menu')?>
<?php slot('header',__('Configure Single Jotag')) ?>

	<form action="<?=url_for('@configure?jotag='.$jotag->getJotag()) ?>" method="post">
		<div class="user_name">
			<h1><?php echo __("Configure Jotag \"%tag%\"",array("%tag%"=>$jotag))?></h1>
			<p class="confg"><?php echo __("Here you can select which of your contact details will be visible in \"%tag%\" Jotag.",array("%tag%"=>$jotag))?><br />
			<?php echo __("If you want to edit or add contact details, do it on the %link% page.",array("%link%"=>link_to(__("Contact Info"),"@contacts")))?></p>
		</div>
		
		<div class="cols">

			<?php if ($sf_user->hasFlash('message')): ?>
				<div id="message_<?=strtolower($sf_user->getFlash('type')) ?>">
					<?php 
						switch($sf_user->getFlash('message'))
						{
							case "PRIVACY_SAVED": print __("Privacy mode successfully saved"); break;
							case "BADGE_SAVED": print __("Badge customization successfully saved"); break;
						}
					?>
				</div>	
                <div id="changeDiv" style="display:none;"></div>
			<?php endif; ?>

		
			<div class="col1">
				<div class="user_img">
					<?php echo image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$jotag->getTagProfile()->getPhoto(),array('width'=>'218px')) ?>
				</div>
				<p class="change_photo"><?php echo link_to(__('[change Photo]'),'@jotag_photo?jotag='.$jotag->getJotag()) ?></p>
				
				<!-- <p><strong>Location:</strong> Tampico, Mexico</p> -->
				<p class="lastupdate"><em><?php echo __("last update") ?>:</em><br/>&nbsp;&nbsp;<?php echo format_date($jotag->getLastUpdate(),'D') ?></p>

				
				<!-- <div class="time night">
					<p>CURRENT TIME <em>23:35 PM</em></p>
				</div> -->
			</div>
		
			<div class="col2">

				<div class="setup">
				
					<div class="item">
						<label><?php echo __("Privacy mode:") ?></label>
						<span><?php echo __(TagPrivacyPeer::$PRIVACY_TYPES[$jotag->getTagPrivacy()->getPrivacyType()]) ?></span>
						<?php echo link_to(__("[Change]"),'@jotag_privacy?jotag='.$jotag->getJotag()) ?>
						<?php echo link_to(__("[Manage authorizations]"),'@manage_auth_request?jotag='.$jotag->getJotag()) ?>
					</div>
					<div class="item pstyle">                    
						<label><?php echo __("Badge type:")?></label>
							<link rel="Stylesheet" type="text/css" href="<?php echo url_for("@badge_get?jotag=".$jotag->getJotag()."&sf_format=css"); ?>"></link><script type="text/javascript" src="<?php echo url_for("@badge_get?jotag=".$jotag->getJotag()."&sf_format=js"); ?>"></script>
							&nbsp;<a href="#" onclick="$('badge_code').show(); return false;"><?php echo __("[Get code]") ?></a>
							<?php echo link_to(__("[Customize]"),"@jotag_badge?jotag=".$jotag->getJotag()) ?>
					</div>
					<div class="item" id="badge_code" style="display:none;">
						<span><?php echo __("Copy and paste the code snippet below into your pages, between the <em>&lt;body&gt;</em> and the <em>&lt;/body&gt;</em> tags. If your website uses templates, you can also copy the code into your template, so the button will appear on all your pages automatically. Also, if your jotag is protected by any of our privacy modes, it's <em><strong>recommended</strong></em> that you upload a <em>blank</em> file to your site's root called <strong>jotag_callback.html</strong>. This file is used in order to unlock your jotag when user pass security test.") ?></span><br />
						<br />
						<textarea style="width: 550px;height: 80px;" readonly="readonly" wrap="off" onclick="select()"><!--  JoTAG Badge BEGIN -->
<link rel="Stylesheet" type="text/css" href="<?php echo url_for("@badge_get?jotag=".$jotag->getJotag()."&sf_format=css",true); ?>"></link><script type="text/javascript" src="<?php echo url_for("@badge_get?jotag=".$jotag->getJotag()."&sf_format=js",true); ?>"></script>
<!-- JoTAG Badge END --></textarea>
					</div>
					
					<div class="item">
						<label><?php echo __("Jotag name:") ?></label> <input type="text" name="display_name" value="<?=$jotag->getTagProfile()->getDisplayName(false) ?>" size="50" />
					</div>
					
					<p><?php echo __("Check which contact details to include in this Jotag:")?></p>
				</div>
				
				
					<!--  EMAILS -->
					<?php if($user->getEmails()): ?>
						<div class="avaibl_item">
							<div class="h2_check"><input type="checkbox" class="h2check" id="ckb_email" onclick="$$('input[rel=email]').each(function (o) { o.checked = $('ckb_email').checked; });"<?php if(count($jotag->getMapping('Email')) == count($user->getEmails())): ?> checked<?php endif; ?> /></div> <h2 class="emails"><?php echo __("E-mails")?></h2>
							<?php foreach ($user->getEmails() as $k=>$email): ?>
								<?include_partial("contact/email_row_show",array(
													'obj'=>$email,
													'show'=>true,
													'prefix'=>'<input type="checkbox" rel="email" name="email[]" value="'.$email->getId().'"'.($jotag->isMapped($email)?' checked':'').' />')) ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<!--  END OF EMAILS -->
			
					<!--  ADDRESSES -->
					<?php if($user->getAddresss()): ?>
						<div class="avaibl_item">
							<div class="h2_check"><input type="checkbox" class="h2check" id="ckb_address" onclick="$$('input[rel=address]').each(function (o) { o.checked = $('ckb_address').checked; });"<?php if(count($jotag->getMapping('Address')) == count($user->getAddresss())): ?> checked<?php endif; ?> /></div> <h2 class="addresses"><?php echo __("Addresses")?></h2>
							<?php foreach ($user->getAddresss() as $k=>$address): ?>
								<?include_partial("contact/address_row_show",array(
													'obj'=>$address,
													'show'=>true,
													'prefix'=>'<input type="checkbox" rel="address" name="address[]" value="'.$address->getId().'"'.($jotag->isMapped($address)?' checked':'').' />')) ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<!--  END OF ADDRESSES -->
					
					<!--  PHONES -->
					<?php if($user->getPhones()): ?>
						<div class="avaibl_item">
							<div class="h2_check"><input type="checkbox" class="h2check" id="ckb_phone" onclick="$$('input[rel=phone]').each(function (o) { o.checked = $('ckb_phone').checked; });"<?php if(count($jotag->getMapping('Phone')) == count($user->getPhones())): ?> checked<?php endif; ?> /></div> <h2 class="phones"><?php echo __("Phones") ?> <span>(<?php echo __("click to call with Skype") ?>)</span></h2>
							<?php foreach ($user->getPhones() as $k=>$phone): ?>
								<?include_partial("contact/phone_row_show",array(
													'obj'=>$phone,
													'show'=>true,
													'prefix'=>'<input type="checkbox" rel="phone" name="phone[]" value="'.$phone->getId().'"'.($jotag->isMapped($phone)?' checked':'').' />')) ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<!--  END OF PHONES -->
					
					<!--  URLS -->
					<?php if($user->getUrls()): ?>
						<div class="avaibl_item">
							<div class="h2_check"><input type="checkbox" class="h2check" id="ckb_url" onclick="$$('input[rel=url]').each(function (o) { o.checked = $('ckb_url').checked; });"<?php if(count($jotag->getMapping('Url')) == count($user->getUrls())): ?> checked<?php endif; ?> /></div> <h2 class="websites"><?php echo __("Websites") ?></h2>
							<?php foreach ($user->getUrls() as $k=>$url): ?>
								<?include_partial("contact/url_row_show",array(
													'obj'=>$url,
													'show'=>true,
													'prefix'=>'<input type="checkbox" rel="url" name="url[]" value="'.$url->getId().'"'.($jotag->isMapped($url)?' checked':'').' />')) ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<!--  END OF URLS -->
				
					<!--  SN -->
					<?php if($user->getSNs()): ?>
						<div class="avaibl_item">
							<div class="h2_check"><input type="checkbox" class="h2check" id="ckb_sn" onclick="$$('input[rel=sn]').each(function (o) { o.checked = $('ckb_sn').checked; });"<?php if(count($jotag->getMapping('SN')) == count($user->getSNs())): ?> checked<?php endif; ?> /></div> <h2 class="sns"><?php echo __("Social Networks") ?></h2>
							<?php foreach ($user->getSNs() as $k=>$sn): ?>
								<?include_partial("contact/sn_row_show",array(
													'obj'=>$sn,
													'show'=>true,
													'prefix'=>'<input type="checkbox" rel="sn" name="sn[]" value="'.$sn->getId().'"'.($jotag->isMapped($sn)?' checked':'').' />')) ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<!--  END OF SN -->
					
					<!--  IM -->
					<?php if($user->getIMs()): ?>
						<div class="avaibl_item">
							<div class="h2_check"><input type="checkbox" class="h2check" id="ckb_im" onclick="$$('input[rel=im]').each(function (o) { o.checked = $('ckb_im').checked; });"<?php if(count($jotag->getMapping('IM')) == count($user->getIMs())): ?> checked<?php endif; ?> /></div> <h2 class="ims"><?php echo __("IMs") ?></h2>
							<?php foreach ($user->getIMs() as $k=>$im): ?>
								<?include_partial("contact/im_row_show",array(
													'obj'=>$im,
													'show'=>true,
													'prefix'=>'<input type="checkbox" rel="im" name="im[]" value="'.$im->getId().'"'.($jotag->isMapped($im)?' checked':'').' />')) ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<!--  END OF IM -->
                    
                    <!--  Custom SN -->
					<?php if($user->getCustoms()): ?>
						<div class="avaibl_item">
							<div class="h2_check"><input type="checkbox" class="h2check" id="ckb_custom" onclick="$$('input[rel=custom]').each(function (o) { o.checked = $('ckb_custom').checked; });"<?php if(count($jotag->getMapping('Custom')) == count($user->getCustoms())): ?> checked<?php endif; ?> /></div> <h2 class="customs" style="text-indent:0;"><?php echo __("Custom Network") ?></h2>
							<?php foreach ($user->getCustoms() as $k=>$custom): ?>
								<?include_partial("contact/custom_row_show",array(
													'obj'=>$custom,
													'show'=>true,
													'prefix'=>'<input type="checkbox" rel="custom" name="custom[]" value="'.$custom->getId().'"'.($jotag->isMapped($custom)?' checked':'').' />')) ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<!--  END OF CUSTOM SN -->
					
					<div class="avaibl_item">
						<br /><input type="checkbox" name="link_by_default" value="Y"<?php if($jotag->getLinkByDefault()): ?> checked<?php endif; ?> />
						<span><b><?php echo __("Automatically link new contact informations to this JoTAG") ?></b></span>
					</div>
					
					<input type="image" src="<?php echo image_path("jotag/".$sf_user->getCulture()."/bg-save.gif") ?>" class="button_save" />
			</div>
		</div>
	</form>