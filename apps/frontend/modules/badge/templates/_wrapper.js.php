<?php use_helper('Partial'); ?>
<!--  lightbox -->
<div id="jotag_badge_background"></div>
<div id="jotag_badge_lightbox_wrapper">
	<div id="jotag_badge_lightbox_border">
		<div id="jotag_badge_lightbox">
			<iframe name="jotag_badge_lightbox_iframe" id="jotag_badge_lightbox_iframe" frameborder="0" marginheight="0" marginwidth="0"></iframe>
			<iframe name="jotag_badge_comm" id="jotag_badge_comm" width="1" height="1" style="display:none;"></iframe>
		</div>
	</div>
</div>
<!--  badge -->
<?php include_partial("badge/".$template,array(
	"badge" 		=> $this,
	"jotag"			=> $jotag,
	"contacts"		=> $contacts,
	"authorized"	=> $authorized,
	"reload"		=> $reload,
)); ?>
