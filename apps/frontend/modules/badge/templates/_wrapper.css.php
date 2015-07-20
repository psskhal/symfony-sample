#jotag_badge_container div,#jotag_badge_container h1,#jotag_badge_container h2,#jotag_badge_container h3,#jotag_badge_container h4,#jotag_badge_container h5,#jotag_badge_container h6,#jotag_badge_container p,#jotag_badge_container a, #jotag_badge_container span, #jotag_badge_container strong { 
	margin:0;
	padding:0;
	border:0;
	font-size:100%;
	font-weight:normal;
	float:none;
	line-height:18px;
	width:auto;
	height:auto;
}
#jotag_badge_container strong
{
	font-weight: bold;
}

#jotag_badge_container img { 
	border:0;
}

#jotag_badge_container
{
	display: inline;
}
#jotag_badge_container #jotag_badge_background
{
	position: fixed;
	top: 0px;
	left: 0px;
	width: 100%;
	height: 100%;
	z-index: 1001;
	background-color: #000000;
	opacity: 0.4;
	filter: alpha(opacity=40);
	display:none;
}
#jotag_badge_container #jotag_badge_lightbox_wrapper
{
	position: fixed;
	top: 0px;
	left: 0px;
	width: 100%;
	margin: 0 auto;
	padding: 0px;
	z-index: 100000001;
	overflow-y: visible;
	overflow-x: visible;
	display: none;
}
#jotag_badge_container #jotag_badge_lightbox_border
{
	background:url(<?php echo image_path("badge/details/bg.png",array("absolute"=>true))?>) top left no-repeat;
	height:506px;
	width:409px;
	position: absolute;
	top: 50%;
	left: 50%;
	padding: 10px;
	margin-bottom: 0px;
	margin-top: 106.5px;	/* calculate on the fly */
	margin-left: -204px;
	margin-right: auto;
	z-index: 100000001;
	font-family: arial,helvetica,tahoma,verdana,sans-serif;
	font-size: 12px;
	color: #4c4c4c;
}
#jotag_badge_container #jotag_badge_lightbox_border.unlock {
	height: auto;
	border: solid #bdbdbd 10px;
	padding: 0px;
	width: 434px;
	margin-left: -214px;
}

#jotag_badge_container #jotag_badge_lightbox_border #jotag_badge_lightbox
{
	background-color: #ffffff;
	margin-left: 35px;
	margin-top: 35px;
	width: 330px;
	height: 428px;
}
#jotag_badge_container #jotag_badge_lightbox_border.unlock #jotag_badge_lightbox {
	margin-left: 0px;
	margin-top: 0px;
	height: auto;
	width: 434px;
}
#jotag_badge_container #jotag_badge_lightbox_border #jotag_badge_lightbox iframe
{
	border: 0px;
	display:block;
	width: 100%;
	height:420px;
}
#jotag_badge_container #jotag_badge_lightbox_border.unlock #jotag_badge_lightbox iframe {
	height: 235px;
}
<?php include_partial("badge/".$template,array(
	"badge" 		=> $this,
	"jotag"			=> $jotag,
	"contacts"		=> $contacts,
	"authorized"	=> $authorized,
	"reload"		=> $reload, 
)); ?>