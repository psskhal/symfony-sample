<?php 
	use_helper('Text'); 
	$counter = 0; $max_contacts = 3; 
	$options = $jotag->getBadgeOptions();
	$max_chars = 30; 
?>

<div id="jotag_badge_box" onmouseover="fixedtooltip('', document.getElementById('pskimgTag'), event, '');" onmouseout="delayhidetip();" style="<?php if(!$reload): ?>display:none;<?php endif; ?>"  >

	<div id="jotag-rollover">
	
		<?php if(!$authorized): ?>
			<div class="unlock">
				<p>
					<?php echo image_tag("badge/rollover/unlock/icon-lock.png",array("absolute"=>true,"align"=>"left"))?>
					<br /><?php echo __("Click the unlock button below to reveal %name%'s contact details",array("%name%"=>$jotag->getTagProfile()))?>
				</p>
				<div><button onclick="return JoTAG_unlock()">Unlock</button></div>
				<br clear="all" />
				<p class="powered">powered by <span>Jotag</span></p>
			</div>
		<?php endif; ?>	
	
		<div id="user">
			<?php if($options["display_photo"]): ?>
				<?php echo image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$jotag->getTagProfile()->getPhoto(),array('width'=>'68px','height'=>'68px','absolute'=>true)) ?>
			<?php endif ?>
			<h1><?php echo $jotag->getTagProfile() ?></h1>
			<p><?php echo link_to(__('Download vCard'),'@vcard?jotag='.$jotag->getJotag(),array("absolute"=>true)) ?></p>
		</div>
        
		<!--  EMAILS -->
		<?php if(@$contacts["EMAIL"]): ?>
			<?php foreach ($contacts["EMAIL"] as $email): ?>
				<?php if(++$counter <= $max_contacts): ?>
					<p><a href="mailto:<?php echo $email ?>" class="email"><?php echo $email ?></a></p>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF EMAILS -->
		<!--  PHONES -->
		<?php if(@$contacts["PHONE"]): ?>
			<?php foreach ($contacts["PHONE"] as $phone): ?>
				<?php if(++$counter <= $max_contacts): ?>
					<p><a href="skype:<?=preg_replace("/[^0-9\+]/","",$phone["number"]) ?>?call" class="phone"><?php echo $phone["number"] ?><?php if($phone["exten"]): ?>, ext: <?php echo $phone["exten"] ?><?php endif; ?></a></p>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF PHONES -->
		<!--  URLS -->
		<?php if(@$contacts["URL"]): ?>
			<?php foreach ($contacts["URL"] as $url): ?>
				<?php if(++$counter <= $max_contacts): ?>
					<p><a href="<?php echo $url ?>" title="<?php echo $url ?>" class="url"><?php echo truncate_text($url,$max_chars) ?></a></p>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF URLS -->
		<!--  SN -->
		<?php if(@$contacts["SN"]): ?>
			<?php foreach ($contacts["SN"] as $sn): ?>
				<?php if(++$counter <= $max_contacts): ?>
					<?php if (SNPeer::$SN_LINKS[$sn["network"]]): ?>
						<p><a href="<?=sprintf(SNPeer::$SN_LINKS[$sn["network"]][0],esc_entities($sn["identifier"])) ?>" title="<?=sprintf(__(SNPeer::$SN_LINKS[$sn["network"]][1]),esc_entities($sn["identifier"])) ?>" class="<?php echo SNPeer::$SN_NETWORKS_IDS[$sn["network"]]?>"><?=esc_entities(truncate_text($sn["identifier"],$max_chars)) ?></a>
					<?php else: ?><p><a href="#" onclick="return false" class="<?php echo strtolower($sn["network"])?>"><?php echo $sn["identifier"] ?></a></p><?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF SN -->
		<!--  IM -->
		<?php if(@$contacts["IM"]): ?>
			<?php foreach ($contacts["IM"] as $im): ?>
				<?php if(++$counter <= $max_contacts): ?>
					<?php if (IMPeer::$IM_LINKS[$im["network"]]): ?>
						<p><a href="<?=sprintf(IMPeer::$IM_LINKS[$im["network"]][0],esc_entities($im["identifier"])) ?>" title="<?=sprintf(__(IMPeer::$IM_LINKS[$im["network"]][1]),esc_entities($im["identifier"])) ?>" class="<?php echo IMPeer::$IM_NETWORKS_IDS[$im["network"]]?>"><?=esc_entities(truncate_text($im["identifier"],$max_chars)) ?></a></p>
					<?php else: ?><p><a href="#" onclick="return false"><?php echo $im["identifier"] ?></a></p><?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF IM -->
        <!--  CUSTOM SN -->
		<?php if(@$contacts["CUSTOM"]): ?>
			<?php foreach ($contacts["CUSTOM"] as $custom): ?>
				<?php if(++$counter <= $max_contacts): ?>
					<p><a href="<?php echo $custom['netid'] ?>" class="custom"><?php echo truncate_text($custom['netid'],21) ?></a></p>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<!--  END OF CUSTOM SN -->
		<p id="view"><a href="#" onclick="return JoTAG_more()"><?php echo __("View more")?></a> <strong><?php echo __("powered by")?> <span>Jotag</span></strong></p>
	</div>
</div>