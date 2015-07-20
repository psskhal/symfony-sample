<div style="width:165px; text-align:right;" id="pkimagediv"><a href="#" onclick="return JoTAG_more()" onmouseover="fixedtooltip('', this, event, '');" onmouseout="delayhidetip();" style="position:relative;"><?php echo __('My Contacts') ?></a> </div>
<?php include_partial("badge/dropdown_general",array(
	"badge" 		=> $this,
	"jotag"			=> $jotag,
	"contacts"		=> $contacts,
	"authorized"	=> $authorized,
	"reload"		=> $reload,
)); ?>