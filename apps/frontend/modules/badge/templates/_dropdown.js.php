<div style="width:165px;" id="pkimagediv"><?php echo image_tag('badge/buttons/badge_button_1.png',array(
	"style"			=> "cursor: pointer; position:relative",
	"onclick"		=> $authorized?"return JoTAG_more()":"return JoTAG_unlock()",
	"onmouseover"	=> "fixedtooltip('', this, event, '');",
	"onmouseout"	=> "delayhidetip();",
	"absolute"		=> true,
	"id"			=> "pskimgTag",
)) ?>
</div>
<?php include_partial("badge/dropdown_general",array(
	"badge" 		=> $this,
	"jotag"			=> $jotag,
	"contacts"		=> $contacts,
	"authorized"	=> $authorized,
	"reload"		=> $reload,
)); ?>

<?php /*?><?php echo image_tag('badge/buttons/badge_button_1.png',array(
	"style"			=> "cursor: pointer;",
	"onclick"		=> $authorized?"return JoTAG_more()":"return JoTAG_unlock()",
	"onmouseover"	=> "fixedtooltip('', this, event, '');",
	"onmouseout"	=> "delayhidetip();",
	"absolute"		=> true,
	"id"			=> "pskimgTag",
)) ?><?php */?>