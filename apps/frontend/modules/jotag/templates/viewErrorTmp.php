<!--  EMAILS -->
<?php if($jotag->getTagEmailsJoinEmail(EmailPeer::buildConfirmedCriteria())): ?>
	<dl>
		<dd id="emails"><?php echo __("E-Mails") ?></dd>
			<?php foreach ($jotag->getTagEmailsJoinEmail(EmailPeer::buildConfirmedCriteria()) as $k=>$email): ?>
				<?php if($k): ?></dl><dl><?php endif; ?>
				<dt class="column-1"><?=esc_entities(ContactPeer::getTypeName(ContactPeer::$EMAIL_TYPES,$email->getEmail())) ?></dt>
			<?php endforeach; ?>
	</dl>
<?php endif; ?>
<!--  END OF EMAILS -->

<!--  ADDRESSES -->
<?php if($jotag->getTagAddresssJoinAddress()): ?>
	<dl>
		<dd id="address"><?php echo __("Addresses") ?></dd>
			<?php foreach ($jotag->getTagAddresssJoinAddress() as $k=>$address): ?>
				<?php if($k): ?></dl><dl><?php endif; ?>
				<dt class="column-1"><?=esc_entities(ContactPeer::getTypeName(ContactPeer::$ADDRESS_TYPES,$address->getAddress())) ?></dt>
			<?php endforeach; ?>
	</dl>
<?php endif; ?>
<!--  END OF ADDRESSES -->

<!--  PHONES -->
<?php if($jotag->getTagPhonesJoinPhone()): ?>
	<dl>
		<dd id="phones"><?php echo __("Phones") ?></dd>
			<?php foreach ($jotag->getTagPhonesJoinPhone() as $k=>$phone): ?>
				<?php if($k): ?></dl><dl><?php endif; ?>
				<dt class="column-1"><?=esc_entities(ContactPeer::getTypeName(ContactPeer::$PHONE_TYPES,$phone->getPhone())) ?></dt>
			<?php endforeach; ?>
	</dl>
<?php endif; ?>
<!--  END OF PHONES -->

<!--  URLS -->
<?php if($jotag->getTagUrlsJoinUrl()): ?>
	<dl>
		<dd id="web-urls"><?php echo __("Websites &amp; Blogs") ?></dd>
			<?php foreach ($jotag->getTagUrlsJoinUrl() as $k=>$url): ?>
				<?php if($k): ?></dl><dl><?php endif; ?>
				<dt class="column-1"><?=esc_entities(ContactPeer::getTypeName(ContactPeer::$URL_TYPES,$url->getUrl())) ?></dt>
			<?php endforeach; ?>
	</dl>
<?php endif; ?>
<!--  END OF URLS -->

<!--  SN -->
<?php if($jotag->getTagSNsJoinSN()): ?>
	<dl>
		<dd id="social-networks"><?php echo __("Social Networking") ?></dd>
			<?php foreach ($jotag->getTagSNsJoinSN() as $k=>$sn): ?>
				<?php if($k): ?></dl><dl><?php endif; ?>
				<dt class="column-1"><?=esc_entities(ContactPeer::getTypeName(ContactPeer::$SN_TYPES,$sn->getSn())) ?></dt>
				<dt>
					<?=image_tag('sn_icons/'.SNPeer::$SN_ICONS[$sn->getSn()->getNetwork()],array(
						'alt'=>SNPeer::$SN_NETWORKS[$sn->getSn()->getNetwork()],
						'title'=>SNPeer::$SN_NETWORKS[$sn->getSn()->getNetwork()])) ?>
					 
				</dt>
			<?php endforeach; ?>
	</dl>
<?php endif; ?>
<!--  END OF SN -->

<!--  IM -->
<?php if($jotag->getTagIMsJoinIM()): ?>
	<dl>
		<dd id="im-chat"><?php echo __("IMs") ?></dd>
			<?php foreach ($jotag->getTagIMsJoinIM() as $k=>$im): ?>
				<?php if($k): ?></dl><dl><?php endif; ?>
				<dt class="column-1"><?=esc_entities(ContactPeer::getTypeName(ContactPeer::$IM_TYPES,$im->getIm())) ?></dt>
				<dt>
					<?=image_tag('im_icons/'.IMPeer::$IM_ICONS[$im->getIm()->getNetwork()],array(
						'alt'=>IMPeer::$IM_NETWORKS[$im->getIm()->getNetwork()],
						'title'=>IMPeer::$IM_NETWORKS[$im->getIm()->getNetwork()])) ?>
					 
				</dt>
			<?php endforeach; ?>
	</dl>
<?php endif; ?>
<!--  END OF IM -->