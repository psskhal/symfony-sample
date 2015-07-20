<p>Dear <?=$user ?>,
<p><?=$jotag->getTagProfile() ?> has updated his "<?=$jotag->getJotag() ?>" JoTAG.</p>
<p>The following information was updated:</p>
<ul>
	<?php if(@$contacts["Email"]): ?>
		<li><b>E-Mails:</b>
			<ul>
				<?php foreach($contacts["Email"] as $obj): ?>
					<li><b><?php echo ContactPeer::getTypeName(ContactPeer::$EMAIL_TYPES,$obj) ?>:</b>
					<?php echo esc_entities($obj->getEmail()) ?></li>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endif; ?>
	<?php if(@$contacts["Address"]): ?>
		<li><b>Addresses:</b>
			<ul>
				<?php foreach($contacts["Address"] as $obj): ?>
					<li><b><?php echo ContactPeer::getTypeName(ContactPeer::$ADDRESS_TYPES,$obj) ?>:</b>
					<?php if($obj->getCompany()): ?><?=esc_entities($obj->getCompany()) ?>, <?php endif; ?>
					<?php if($obj->getTaxId()): ?>Tax ID: <?=esc_entities($obj->getTaxId()) ?>, <?php endif; ?>
					<?=esc_entities($obj->getLine1()) ?>, 
					<?php if($obj->getLine2()): ?><?=esc_entities($obj->getLine2()) ?>, <?php endif; ?>
					<?=esc_entities($obj->getPostcode()) ?>, 
					<?=esc_entities($obj->getCity()) ?>, <?=esc_entities($obj->getState()) ?> - <?=esc_entities($obj->getCountry()) ?>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endif; ?>
	<?php if(@$contacts["Phone"]): ?>
		<li><b>Phones:</b>
			<ul>
				<?php foreach($contacts["Phone"] as $obj): ?>
					<li><b><?php echo ContactPeer::getTypeName(ContactPeer::$PHONE_TYPES,$obj) ?> (<?=PhonePeer::$PHONE_KINDS[$obj->getKind()] ?>):</b> 
					<?php echo esc_entities($obj->getNumber()) ?><?php if ($obj->getExten()): ?>, Ext: <?=$obj->getExten() ?><?php endif; ?></li>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endif; ?>
	<?php if(@$contacts["Url"]): ?>
		<li><b>Websites &amp; Blogs:</b>
			<ul>
				<?php foreach($contacts["Url"] as $obj): ?>
					<li><b><?php echo ContactPeer::getTypeName(ContactPeer::$URL_TYPES,$obj) ?>:</b> 
					<?php echo esc_entities($obj->getUrl()) ?>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endif; ?>
	<?php if(@$contacts["SN"]): ?>
		<li><b>Social Networking Sites:</b>
			<ul>
				<?php foreach($contacts["SN"] as $obj): ?>
					<li><b><?php echo ContactPeer::getTypeName(ContactPeer::$SN_TYPES,$obj) ?> (<?php echo SNPeer::$SN_NETWORKS[$obj->getNetwork()] ?>):</b> 
					<?php echo esc_entities($obj->getIdentifier()) ?>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endif; ?>
	<?php if(@$contacts["IM"]): ?>
		<li><b>IMs:</b>
			<ul>
				<?php foreach($contacts["IM"] as $obj): ?>
					<li><b><?php echo ContactPeer::getTypeName(ContactPeer::$IM_TYPES,$obj) ?> (<?php echo IMPeer::$IM_NETWORKS[$obj->getNetwork()] ?>):</b> 
					<?php echo esc_entities($obj->getIdentifier()) ?>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endif; ?>
</ul>
<p>You can view the updated information by clicking the following link:</p>
<p><?php echo link_to(url_for('@view_jotag?jotag='.$jotag,true),'@view_jotag?jotag='.$jotag,array('absolute'=>true)) ?></p>
<p>Also, a vCard was attached to this email with this jotag updated information.</p>