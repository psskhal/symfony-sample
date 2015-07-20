<?php decorate_with(false); ?>
<?php use_helper('Text'); $options = $jotag->getBadgeOptions(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php include_http_metas() ?>
<?php include_metas() ?>
<?php 
	use_stylesheet('i18n/badgeStyle');
	sfContext::getInstance()->getResponse()->removeStylesheet("jotag/reset");
	sfContext::getInstance()->getResponse()->removeStylesheet("i18n/style");
?>

<title>Jotag</title>
<!--[if IE]>
	<script type="text/javascript" src="<?php echo sfConfig::get("app_general_base_path") ?>js/jotag/iepngfix_tilebg.js"></script>
<![endif]-->
 
</head>

<body>

<?php if($show): ?>
	<div id="jotag-widget">
	
		<div class="inner">
			<div class="user">

				<?php if($options["display_photo"]): ?>
					<?php echo image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$jotag->getTagProfile()->getPhoto(),array('width'=>'66px','height'=>'68px','absolute'=>true)) ?>
				<?php endif; ?>
				<h1><?php echo $jotag->getTagProfile() ?></h1>
				<p>
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
				</p>

			</div>
			<div class="content">
				<div class="links">
					<?php echo link_to(__('Download vCard'),'@vcard?jotag='.$jotag->getJotag(),array("class"=>"vcard")) ?>
					<?php echo link_to(__('View profile on Jotag'),'@view_jotag?jotag='.$jotag->getJotag(),array("class"=>"jtag","target"=>"_blank"))?>
				</div>
				<div class="contact">
                	<!--  IM -->
					<?php if($jotag->getTagIMsJoinIM()): ?>
                    <h1 class="addme"><?php echo __("ADD ME") ?></h1>
						<h2 class="im"><?php echo __("IMs") ?> <span>(<?php echo __("click to add") ?>)</span></h2>
						<?php foreach ($jotag->getTagIMsJoinIM() as $k=>$im): ?>
							<?include_partial("contact/im_row_show",array('obj'=>$im->getIM(),'show'=>true)) ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF IM -->
                    
                    <!--  SN -->
					<?php if($jotag->getTagSNsJoinSN()): ?>
                    <h1 class="followme"><?php echo __("FOLLOW ME") ?></h1>
						<h2 class="sn"><?php echo __("Social Networks") ?></h2>
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
						<h2 class="email"><?php echo __("E-mails") ?></h2>
						<?php foreach ($jotag->getTagEmailsJoinEmail(EmailPeer::buildConfirmedCriteria()) as $k=>$email): ?>
							<?include_partial("contact/email_row_show",array('obj'=>$email->getEmail(),'show'=>true)) ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF EMAILS -->
			
					<!--  ADDRESSES -->
					<?php if($jotag->getTagAddresssJoinAddress()): ?>
						<h2 class="address"><?php echo __("Addresses") ?></h2>
						<?php foreach ($jotag->getTagAddresssJoinAddress() as $k=>$address): ?>
							<?include_partial("contact/address_row_show",array('obj'=>$address->getAddress(),'show'=>true)) ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF ADDRESSES -->
					
					<!--  PHONES -->
					<?php if($jotag->getTagPhonesJoinPhone()): ?>
						<h2 class="phone"><?php echo __("Phones") ?> <span>(<?php echo __("click to Skype") ?>)</span></h2>
						<?php foreach ($jotag->getTagPhonesJoinPhone() as $k=>$phone): ?>
							<?include_partial("contact/phone_row_show",array('obj'=>$phone->getPhone(),'show'=>true)) ?>
							<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF PHONES -->
					
					<!--  URLS -->
					<?php if($jotag->getTagUrlsJoinUrl()): ?>
						<h2 class="web"><?php echo __("Websites") ?></h2>
						<?php foreach ($jotag->getTagUrlsJoinUrl() as $k=>$url): ?>
							<?include_partial("contact/url_row_show",array('obj'=>$url->getUrl(),'show'=>true)) ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF URLS -->
				
                    <!--  CUSTOM SN -->
					<?php if($jotag->getTagCustomsJoinCustom()): ?>
						<h2 class="custom" style="text-indent:0; padding-left:0px;"><?php echo __("Custom Network") ?> </h2>
						<?php foreach ($jotag->getTagCustomsJoinCustom() as $k=>$custom): ?>
							<?include_partial("contact/custom_row_show",array('obj'=>$custom->getCustom(),'show'=>true)) ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF CUSTOM SN -->
				</div>

			</div>
			<div class="sign">
				<div class="powered"><?php echo __("powered by")?> <span>Jotag</span></div>
				<div class="get"><?php echo link_to(__("Get your own widget"),"@homepage",array("target"=>"_blank"))?></div>
			</div>
		</div>
	</div>
<?php else: ?>
	<script type="text/javascript">
		var i = window.setInterval(function () {
			if(parent.frames["jotag_badge_comm"])
			{
				parent.frames["jotag_badge_comm"].location.href = "<?php echo $sf_user->getAttribute("domain","","badge"); ?>/jotag_callback.html#jotag_reload";
				window.clearInterval(i);
			}
		},500);
	</script>
	Reloading badge...
<?php endif; ?>

</body>
</html>