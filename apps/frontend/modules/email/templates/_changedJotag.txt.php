Dear <?=$user ?>,
<?=$jotag->getTagProfile() ?> has updated his "<?=$jotag->getJotag() ?>" JoTAG.
The following information was updated:

<?php if(@$contacts["Email"]): ?>E-Mails:
<?php foreach($contacts["Email"] as $obj): ?>
	<?php echo ContactPeer::getTypeName(ContactPeer::$EMAIL_TYPES,$obj) ?>:	<?php echo esc_entities($obj->getEmail()) ?> 
<?php endforeach; ?>
<?php endif; ?>
<?php if(@$contacts["Address"]): ?>Addresses:
<?php foreach($contacts["Address"] as $obj): ?>
	<?php echo ContactPeer::getTypeName(ContactPeer::$ADDRESS_TYPES,$obj) ?>: <?php if($obj->getCompany()): ?><?=esc_entities($obj->getCompany()) ?>, <?php endif; ?><?php if($obj->getTaxId()): ?>Tax ID: <?=esc_entities($obj->getTaxId()) ?>, <?php endif; ?><?=esc_entities($obj->getLine1()) ?>, <?php if($obj->getLine2()): ?><?=esc_entities($obj->getLine2()) ?>, <?php endif; ?><?=esc_entities($obj->getPostcode()) ?>, <?=esc_entities($obj->getCity()) ?>, <?=esc_entities($obj->getState()) ?> - <?=esc_entities($obj->getCountry()) ?> 
<?php endforeach; ?>
<?php endif; ?>
<?php if(@$contacts["Phone"]): ?>Phones:
<?php foreach($contacts["Phone"] as $obj): ?>
	<?php echo ContactPeer::getTypeName(ContactPeer::$PHONE_TYPES,$obj) ?> (<?=PhonePeer::$PHONE_KINDS[$obj->getKind()] ?>): <?php echo esc_entities($obj->getNumber()) ?><?php if ($obj->getExten()): ?>, Ext: <?=$obj->getExten() ?><?php endif; ?> 
<?php endforeach; ?>
<?php endif; ?>
<?php if(@$contacts["Url"]): ?>Websites & Blogs:
<?php foreach($contacts["Url"] as $obj): ?>
	<?php echo ContactPeer::getTypeName(ContactPeer::$URL_TYPES,$obj) ?>: <?php echo esc_entities($obj->getUrl()) ?> 
<?php endforeach; ?>
<?php endif; ?>
<?php if(@$contacts["SN"]): ?>Social Networking Sites:
<?php foreach($contacts["SN"] as $obj): ?>
	<?php echo ContactPeer::getTypeName(ContactPeer::$SN_TYPES,$obj) ?> (<?php echo SNPeer::$SN_NETWORKS[$obj->getNetwork()] ?>): <?php echo esc_entities($obj->getIdentifier()) ?> 
<?php endforeach; ?>
<?php endif; ?>
<?php if(@$contacts["IM"]): ?>IMs:
<?php foreach($contacts["IM"] as $obj): ?>
	<?php echo ContactPeer::getTypeName(ContactPeer::$IM_TYPES,$obj) ?> (<?php echo IMPeer::$IM_NETWORKS[$obj->getNetwork()] ?>): <?php echo esc_entities($obj->getIdentifier()) ?> 
<?php endforeach; ?>
<?php endif; ?>

You can view the updated information by clicking the following link:
<?php echo url_for('@view_jotag?jotag='.$jotag,true) ?>
  
Also, a vCard was attached to this email with this jotag updated information.
