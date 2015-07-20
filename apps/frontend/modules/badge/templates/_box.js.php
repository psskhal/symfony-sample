<?php use_helper('Text'); $options = $jotag->getBadgeOptions(); ?>
<div id="jotag_badge_box">
	<table width="100%">
		<tr>
			<?php if($options["display_photo"]): ?>
				<td width="70px" valign="top" align="center"><?php echo image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$jotag->getTagProfile()->getPhoto(),array('width'=>'60px','absolute'=>true)) ?></td>
			<?php endif; ?>
			<td valign="top">
				<table width="100%">
					<tr><td colspan="2" align="left"><strong><?php echo $jotag->getTagProfile() ?></strong></td></tr>
                    
                    <!--  IM -->
					<?php if(@$contacts["IM"]): ?>
                    <tr><td colspan="2" align="left"><div style="border-bottom:1px solid #000000; width:200px;"><strong>Add Me</strong></div></td></tr>
						<?php foreach ($contacts["IM"] as $im): ?>
							<tr>
								<td width="20" valign="middle"><?php echo image_tag("im_icons/".IMPeer::$IM_ICONS[$im["network"]],array('absolute'=>true)) ?></td>
								<td align="left">
									<?php if (IMPeer::$IM_LINKS[$im["network"]]): ?>
										<a href="<?=sprintf(IMPeer::$IM_LINKS[$im["network"]][0],esc_entities($im["identifier"])) ?>" title="<?=sprintf(__(IMPeer::$IM_LINKS[$im["network"]][1]),esc_entities($im["identifier"])) ?>"><?=esc_entities(truncate_text($im["identifier"],55)) ?></a>
									<?php else: ?><?php echo $im["identifier"] ?><?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF IM -->
                    
                    <!--  SN -->
					<?php if(@$contacts["SN"]): ?>
                    <tr><td colspan="2" align="left"><div style="border-bottom:1px solid #000000; width:200px;"><strong>Follow Me</strong></div></td></tr>
						<?php foreach ($contacts["SN"] as $sn): ?>
							<tr>
								<td width="20" valign="middle"><?php echo image_tag("sn_icons/".SNPeer::$SN_ICONS[$sn["network"]],array('absolute'=>true)) ?></td>
								<td align="left">
									<?php if (SNPeer::$SN_LINKS[$sn["network"]]): ?>
										<a href="<?=sprintf(SNPeer::$SN_LINKS[$sn["network"]][0],esc_entities($sn["identifier"])) ?>" title="<?=sprintf(__(SNPeer::$SN_LINKS[$sn["network"]][1]),esc_entities($sn["identifier"])) ?>"><?=esc_entities(truncate_text($sn["identifier"],55)) ?></a>
									<?php else: ?><?php echo $sn["identifier"] ?><?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF SN -->
                    
                    <?php if(@$contacts["EMAIL"] || @$contacts["PHONE"] || @$contacts["URL"] || @$contacts["CUSTOM"]): ?>
                    <tr><td colspan="2" align="left"><div style="border-bottom:1px solid #000000; width:200px;"><strong>Reach Me</strong></div></td></tr>
                    <?php endif;?>
					<!--  EMAILS -->
					<?php if(@$contacts["EMAIL"]): ?>
						<?php foreach ($contacts["EMAIL"] as $email): ?>
							<tr>
								<td width="20" valign="middle"><?php echo image_tag("badge/email.png",array('absolute'=>true)) ?></td>
								<td align="left"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF EMAILS -->
					
					<!--  PHONES -->
					<?php if(@$contacts["PHONE"]): ?>
						<?php foreach ($contacts["PHONE"] as $phone): ?>
							<tr>
								<td width="20" valign="middle"><?php echo image_tag("badge/phone.png",array('absolute'=>true)) ?></td>
								<td align="left"><?php echo $phone["number"] ?><?php if($phone["exten"]): ?>, ext: <?php echo $phone["exten"] ?><?php endif; ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF PHONES -->
					
					<!--  URLS -->
					<?php if(@$contacts["URL"]): ?>
						<?php foreach ($contacts["URL"] as $url): ?>
							<tr>
								<td width="20" valign="middle"><?php echo image_tag("badge/url.gif",array('absolute'=>true)) ?></td>
								<td align="left"><a href="<?php echo $url ?>" title="<?php echo $url ?>"><?php echo $url ?></a></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF URLS -->
					                    
                    <!--  CUSTOM SN -->
					<?php if(@$contacts["CUSTOM"]): ?>
						<?php foreach ($contacts["CUSTOM"] as $custom): ?>
							<tr>
								<td width="20" valign="middle"><?php echo image_tag("badge/custom.png",array('absolute'=>true)) ?></td>
								<td align="left"><a href="<?php echo $custom['netid'] ?>" title="<?php echo $custom['netname'] ?>"><?php echo $custom['netid'] ?></a></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--  END OF CUSTOM SN -->
				</table>
			</td>
		</tr>
	</table>
	<?php if(!$authorized): ?>
		<div id="jotag_badge_shade">
			<a href="#" id="jotag_badge_unlock" onclick="return JoTAG_unlock();">Unlock</a>
		</div>
	<?php endif; ?>
</div>
