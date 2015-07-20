#jotag_badge_box
{
	width: 350px;
	border: solid cyan 2px;
	position:relative;
	font-family: arial,helvetica,tahoma,verdana,sans-serif;
	font-size: 12px;
	background-color: #ffffff;
}
#jotag_badge_box td { font-size: 12px; }
#jotag_badge_shade
{
	position: absolute;
	top: 0px;
	left: 0px;
	width: 100%;
	height: 100%;
	margin: 0 auto;
	padding: 0;
	background-color: transparent;
	text-align: center;
	color: white;
	font-weight: bold;
	background-image: url(<?php echo $sf_request->getUriPrefix().$sf_request->getRelativeUrlRoot() ?>/images/badge/bkg.png);
}
#jotag_badge_shade a
{
	position:absolute;
	top: 50%;
	left: 50%;
	margin-right: auto;
	margin-left: -55px;
	margin-top: -35px;
	margin-bottom: 0px;
	display:block;
	padding: 30px;
	background-color: #ffffff;
	border: solid black 2px;
}