<?php use_helper('Javascript'); ?>
<?php echo link_to("VCARD",'@vcard?jotag='.$jotag->getJotag(),array('class'=>'vcard','id'=>'vcard','title'=>__('Add contact details to addressbook'))) ?>
<?php $Icons_added = 0; $IM_shown = array(); foreach ($jotag->getTagIMsJoinIM() as $k=>$im): if($Icons_added >= 3) break; ?>
	<?php if (@IMPeer::$IM_TOOLBAR[$im->getIM()->getNetwork()] && @IMPeer::$IM_NETWORKS_IDS[$im->getIm()->getNetwork()] && !@$IM_shown[$im->getIm()->getNetwork()]): ?>
		<a class="<?php echo strtolower(IMPeer::$IM_NETWORKS_IDS[$im->getIm()->getNetwork()]) ?>" href="<?=sprintf(IMPeer::$IM_LINKS[$im->getIM()->getNetwork()][0],esc_entities($im->getIM()->getIdentifier())) ?>" title="<?=sprintf(__(IMPeer::$IM_LINKS[$im->getIM()->getNetwork()][1]),esc_entities($im->getIM()->getIdentifier())) ?>" id="<?php echo strtolower(IMPeer::$IM_NETWORKS_IDS[$im->getIm()->getNetwork()]) ?>"><?php echo strtoupper(IMPeer::$IM_NETWORKS[$im->getIm()->getNetwork()]) ?></a>
	<?php $IM_shown[$im->getIm()->getNetwork()] = true; $Icons_added++; endif; ?>
<?php endforeach; ?>
<?php if($sf_user->isAuthenticated()): ?>
	<?php echo link_to_remote("QUICK",array(
		"url" 		=> "@add_quick_contact?jotag=".$jotag->getJotag(),
		"update" 	=> "buttons"
	),array("class"=>"quick-contact","title"=>__("Add this JoTAG to your quick contacts"))) ?>
<?php endif; ?>