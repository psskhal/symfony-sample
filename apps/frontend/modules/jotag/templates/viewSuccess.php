<?php use_helper('Javascript','Date'); ?>
<?php slot('title',__('JoTAG - %jotag% contacts',array('%jotag%'=>$jotag->getJotag()))) ?>
<div class="user_name">
	<h1><?php echo $jotag->getTagProfile() ?></h1>
	<p class="has">
		<em><?php echo __("has") ?></em>
		<?php $strings = array(); ?> 
		<?php if(($c = count($jotag->getTagEmailsJoinEmail(EmailPeer::buildConfirmedCriteria())))): ?>
			<?php $strings[] = '<span class="email">'.$c.' '.format_number_choice("[1]email|[1,+Inf]emails",array(),$c).'</span>'; ?>
		<?php endif ?>
		<?php if(($c = count($jotag->getTagAddresssJoinAddress()))): ?>
			<?php $strings[] = '<span class="address">'.$c.' '.format_number_choice("[1]address|[1,+Inf]addresses",array(),$c).'</span>'; ?>
		<?php endif; ?> 
		<?php if(($c = count($jotag->getTagPhonesJoinPhone()))): ?>
			<?php $strings[] = '<span class="phone">'.$c.' '.format_number_choice("[1]phone|[1,+Inf]phones",array(),$c).'</span>'; ?>
		<?php endif; ?> 
		<?php if(($c = count($jotag->getTagUrlsJoinUrl()))): ?>
			<?php $strings[] = '<span class="website">'.$c.' '.format_number_choice("[1]website|[1,+Inf]websites",array(),$c).'</span>'; ?>
		<?php endif; ?> 
		<?php if(($c = count($jotag->getTagSNsJoinSN()))): ?>
			<?php $strings[] = '<span class="sn">'.$c.' '.format_number_choice("[1]social network|[1,+Inf]social networks",array(),$c).'</span>'; ?>
		<?php endif; ?> 
		<?php if(($c = count($jotag->getTagIMsJoinIM()))): ?>
			<?php $strings[] = '<span class="im">'.$c.' '.format_number_choice("[1]IM|[1,+Inf]IMs",array(),$c).'</span>'; ?>
		<?php endif; ?>
        <?php if(($c = count($jotag->getTagCustomsJoinCustom()))): ?>
			<?php $strings[] = (count($strings)?"and ":"").'<span class="custom">'.$c.' '.format_number_choice("[1]Other|[1,+Inf]others",array(),$c).'</span>'; ?>
		<?php endif; ?>
		<?php echo implode(", ",$strings) ?>
</div>

<div class="msg">
	<div class="add" id="buttons">
		<?php include_partial('toolbar',array('jotag'=>$jotag)); ?>
	</div>
</div>

<div class="cols">

	<div class="col1">
		<div class="user_img">
			<?=image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$jotag->getTagProfile()->getPhoto(),array('width'=>'218px')) ?>
		</div>
		
		<!-- <p class=""><strong>Location:</strong> Tampico, Mexico</p>-->

		<p class="lastupdate"><em><?php echo __("last update") ?>:</em><br/>&nbsp;&nbsp;<?php echo format_date($jotag->getLastUpdate(),'D') ?></p>
		
		<!-- <div class="time night">
			<p>CURRENT TIME <em>23:35 PM</em></p>
		</div> -->
	</div>

	<div class="col2">
    
    	<!--  IM -->
		<?php if($jotag->getTagIMsJoinIM()): ?>
        <h1 class="addme"><?php echo __("ADD ME") ?></h1>
			<h2 class="ims"><?php echo __("IMs") ?></h2>
			<?php foreach ($jotag->getTagIMsJoinIM() as $k=>$im): ?>
				<?include_partial("contact/im_row_show",array('obj'=>$im->getIM(),'show'=>true)) ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF IM -->
        
        <!--  SN -->
		<?php if($jotag->getTagSNsJoinSN()): ?>
        <h1 class="followme"><?php echo __("FOLLOW ME") ?></h1>
			<h2 class="sns"><?php echo __("Social Networks") ?></h2>
			<?php foreach ($jotag->getTagSNsJoinSN() as $k=>$sn): ?>
				<?include_partial("contact/sn_row_show",array('obj'=>$sn->getSn(),'show'=>true)) ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF SN -->
		
        <?php if($jotag->getTagEmailsJoinEmail(EmailPeer::buildConfirmedCriteria()) || $jotag->getTagAddresssJoinAddress() || $jotag->getTagPhonesJoinPhone() || $jotag->getTagUrlsJoinUrl() || $jotag->getTagCustomsJoinCustom()): ?>
        <h1 class="reachme"><?php echo __("REACH ME") ?></h1>
        <?php endif; ?>
		<!--  EMAILS -->
		<?php if($jotag->getTagEmailsJoinEmail(EmailPeer::buildConfirmedCriteria())): ?>
			<h2 class="emails"><?php echo __("E-mails") ?></h2>
			<?php foreach ($jotag->getTagEmailsJoinEmail(EmailPeer::buildConfirmedCriteria()) as $k=>$email): ?>
				<?include_partial("contact/email_row_show",array('obj'=>$email->getEmail(),'show'=>true)) ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF EMAILS -->

		<!--  ADDRESSES -->
		<?php if($jotag->getTagAddresssJoinAddress()): ?>
			<h2 class="addresses"><?php echo __("Addresses") ?></h2>
			<?php foreach ($jotag->getTagAddresssJoinAddress() as $k=>$address): ?>
				<?include_partial("contact/address_row_show",array('obj'=>$address->getAddress(),'show'=>true)) ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF ADDRESSES -->
		
		<!--  PHONES -->
		<?php if($jotag->getTagPhonesJoinPhone()): ?>
			<h2 class="phones"><?php echo __("Phones") ?> <span>(<?php echo __("click to call with Skype") ?>)</span></h2>
			<?php foreach ($jotag->getTagPhonesJoinPhone() as $k=>$phone): ?>
				<?include_partial("contact/phone_row_show",array('obj'=>$phone->getPhone(),'show'=>true)) ?>
				<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF PHONES -->
		
		<!--  URLS -->
		<?php if($jotag->getTagUrlsJoinUrl()): ?>
			<h2 class="websites"><?php echo __("Websites") ?></h2>
			<?php foreach ($jotag->getTagUrlsJoinUrl() as $k=>$url): ?>
				<?include_partial("contact/url_row_show",array('obj'=>$url->getUrl(),'show'=>true)) ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF URLS -->
        
        <!--  CUSTOM SN -->
		<?php if($jotag->getTagCustomsJoinCustom()): ?>
			<h2 class="customs" style="text-indent:0;"><?php echo __("Custom Network") ?></h2>
			<?php foreach ($jotag->getTagCustomsJoinCustom() as $k=>$custom): ?>
				<?include_partial("contact/custom_row_show",array('obj'=>$custom->getCustom(),'show'=>true)) ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF CUSTOM SN -->
	</div>
</div>