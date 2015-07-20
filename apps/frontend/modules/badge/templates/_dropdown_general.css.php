#jotag_badge_container #jotag_badge_box
{
	width: 239px;
	max-width: 239px;
	height: 223px;
	max-height: 223px;
	/*overflow: hidden;*/
	position:absolute;
	z-index: 1000;
	padding: 1px;
}

#jotag_badge_container #jotag-small-widget, #jotag_badge_container #jotag-rollover, #jotag_badge_container #jotag-widget, #jotag_badge_container #jotag-enter-answer  {
	font-size:12px;
	text-align:center;
	color:#2a2a2a;
	font-family: tahoma,'lucida grande','lucida sans unicode',arial,helvetica,sans-serif;
	text-align:left;
}

#jotag_badge_container #jotag-rollover  {
	width:219px;
	height:203px;
	background:url(<?php echo image_path("badge/rollover/bg-rollover.gif",array("absolute"=>true))?>) top left no-repeat;
	padding:10px;
	color:#454545;
	position:relative;
}

#jotag_badge_container #jotag-rollover  p {
	margin:0;
	padding:6px 0;
}

#jotag_badge_container #jotag-rollover  p a	{
	color:#454545;
}

#jotag_badge_container #jotag-rollover div#user p a {
	padding-left:24px;
	background:url(<?php echo image_path("badge/rollover/icon-vcard.gif",array("absolute"=>true))?>) top left no-repeat;
	color:#454545;
}

#jotag_badge_container #jotag-rollover  p a {
	line-height:18px;
	display:block;
}

#jotag_badge_container #jotag-rollover  p a.email {
	background:url(<?php echo image_path("badge/rollover/icon-email.gif",array("absolute"=>true))?>) top left no-repeat;
	padding-left:32px;
}

#jotag_badge_container #jotag-rollover  p a.phone {
	background:url(<?php echo image_path("badge/rollover/icon-iphone.gif",array("absolute"=>true))?>) top left no-repeat;
	padding-left:32px;
}

#jotag_badge_container #jotag-rollover  p a.url {
	background:url(<?php echo image_path("badge/rollover/icon-url.gif",array("absolute"=>true))?>) top left no-repeat;
	padding-left:32px;
}

#jotag_badge_container #jotag-rollover  p a.custom {
	background:url(<?php echo image_path("badge/rollover/icon-custom.png",array("absolute"=>true))?>) top left no-repeat;
	padding-left:32px;
}

<?php foreach(IMPeer::$IM_NETWORKS_IDS as $k=>$v):?>
#jotag_badge_container #jotag-rollover p a.<?php echo $v ?> {
	background:url(<?php echo image_path("im_icons/".IMPeer::$IM_ICONS[$k],array("absolute"=>true))?>) 5px 0 no-repeat;
	padding-left:32px;
}
<?php endforeach ?>

<?php foreach(SNPeer::$SN_NETWORKS_IDS as $k=>$v):?>
#jotag_badge_container #jotag-rollover p a.<?php echo $v ?> {
	background:url(<?php echo image_path("sn_icons/".SNPeer::$SN_ICONS[$k],array("absolute"=>true))?>) 5px 0 no-repeat;
	padding-left:32px;
}
<?php endforeach ?>

#jotag_badge_container #jotag-rollover  p#view {
	padding-left:25px;
}

#jotag_badge_container #jotag-rollover  p#view a {
	color:#fff;
	background:url(<?php echo image_path("badge/rollover/bg-view.gif",array("absolute"=>true))?>) top left no-repeat;
	width:93px;
	display:block;
	float:left;
	margin-right:5px;
	text-align:center;
	height:22px;
	line-height:22px;
	text-decoration:none;
}

#jotag_badge_container #jotag-rollover  p#view strong{
	line-height:18px;
	font-size:9px;
	display:block;
	float:left;
	color:#9d9b9b;
}

#jotag_badge_container #jotag-rollover  p#view strong span {
	color:#d4412a;
}

#jotag_badge_container #jotag-rollover div#user {
	background:#f0f0f0;
	height:68px;
	margin-bottom:12px;
	border:1px solid #dddddd;}

#jotag_badge_container #jotag-rollover div#user img {
	float:left;
	padding-right:12px;
	margin:0px;
}

#jotag_badge_container #jotag-rollover div#user h1 {
	margin:0;
	padding:0;
	color:#282727;
	letter-spacing:-0.05em;
	line-height:34px;
	font-size:17px;
}

#jotag_badge_container #jotag-rollover div#user  p {
	margin:0;
	padding:0;
	float:left;
	line-height:34px;
}


#jotag_badge_container #jotag-rollover .unlock {
	position:absolute;
	background:url(<?php echo image_path("badge/rollover/unlock/bg-unlock.png",array("absolute"=>true))?>) top left repeat;
	top:0px;
	left:0px;
	text-align:center;
	padding:15px;
	width:209px;
	height:193px;
	color:#fff;
}

#jotag_badge_container #jotag-rollover .unlock p.powered {
	color:#9d9b9b;
	font-size:10px;
	margin-top:20px;
}

#jotag_badge_container #jotag-rollover .unlock p.powered  span {
	color:#d4412a;
}

#jotag_badge_container #jotag-rollover .unlock div {
	margin-top:30px;
	text-align: center;
	height:30px;
}

#jotag_badge_container #jotag-rollover .unlock img {
	padding:0 8px;
}

#jotag_badge_container #jotag-rollover .unlock button, #jotag_badge_container #jotag-rollover .unlock input  {
	height:28px;
	border:none;
	padding:0;
	margin:0;
}

#jotag_badge_container #jotag-rollover .unlock button {
	background:url(<?php echo image_path("badge/rollover/unlock/bg-button.png",array("absolute"=>true))?>) left center no-repeat;
	width:53px;
	font-size:11px;
	color:#fff;
	font-weight:bold;
}

#jotag_badge_container #jotag-rollover .unlock input {
	background:url(<?php echo image_path("badge/rollover/unlock/bg-input.gif",array("absolute"=>true))?>) top center no-repeat;
	width:112px;
	margin-right:7px;
}