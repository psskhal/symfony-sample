<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_http_metas() ?>
<?php include_metas() ?>
<script language="JavaScript1.1">
<!-- begin hiding
// You may modify the following:
	var locationAfterPreload = "http://dynamicdrive.com" // URL of the page after preload finishes
	var lengthOfPreloadBar = 150 // Length of preload bar (in pixels)
	var heightOfPreloadBar = 15 // Height of preload bar (in pixels)
	// Put the URLs of images that you want to preload below (as many as you want)
	var yourImages = new Array("<?php echo "http://".$_SERVER['SERVER_NAME'];?>/jotag/web/images/jotag/headerbg.jpg","<?php echo "http://".$_SERVER['SERVER_NAME'];?>/jotag/web/images/jotag/bodybg.jpg", "<?php echo "http://".$_SERVER['SERVER_NAME'];?>/jotag/web/images/jotag/footerbg.jpg")

// Do not modify anything beyond this point!
if (document.images) {
	var dots = new Array() 
	var preImages = new Array(),coverage = Math.floor(lengthOfPreloadBar/yourImages.length),currCount = 0
	var loaded = new Array(),i,covered,timerID
	var leftOverWidth = lengthOfPreloadBar%coverage
}
function loadImages() { 
	for (i = 0; i < yourImages.length; i++) { 
		preImages[i] = new Image()
		preImages[i].src = yourImages[i]
	}
	for (i = 0; i < preImages.length; i++) { 
		loaded[i] = false
	}
	checkLoad()
}
function checkLoad() {
	if (currCount == preImages.length) { 
		//location.replace(locationAfterPreload)
		return
	}
	for (i = 0; i <= preImages.length; i++) {
		if (loaded[i] == false && preImages[i].complete) {
			loaded[i] = true
			//eval("document.img" + currCount + ".src=dots[1].src")
			currCount++
		}
	}
	timerID = setTimeout("checkLoad()",10) 
}
// end hiding -->
</script>

<script language="JavaScript1.1">
<!-- begin hiding
// It is recommended that you put a link to the target URL just in case if the visitor wants to skip preloading
// for some reason, or his browser doesn't support JavaScript image object.
if (document.images) {
	loadImages()
}
// end hiding -->
</script>
<title><?php if(!include_slot('title')): ?>JoTAG<?php endif; ?></title>
<link rel="shortcut icon" href="/favicon.ico" />
<!--[if IE]>
	<script type="text/javascript" src="<?php echo sfConfig::get("app_general_base_path") ?>js/jotag/iepngfix_tilebg.js"></script>
<![endif]-->
</head>
<body> 

<!--Redirect if contact info is not filled-->
<?php if($sf_user->isAuthenticated()): ?>
<?php $contactCount=$sf_user->contactRedirectFun()?>

<?php if($contactCount<2 && !preg_match('/^(.*?)\/contacts/', $_SERVER['REQUEST_URI']) && !preg_match('/^(.*?)page\/_(.*?)$/', $_SERVER['REQUEST_URI'])):?>
<script type="text/javascript" language="javascript">
window.location='contacts';
</script>
<?php die(); endif;?>
<?php endif;?>

<div id="headerwrapper">
	<div id="header">
		<h1 class="pos2"><?php echo link_to("Jotag","@homepage",array("class"=>"png")) ?></h1>
		<?php include_partial("global/navigation"); ?>		
		<div class="title_header"> 
			<?php if(has_slot("header")): ?><h2><?php include_slot('header') ?></h2><?php endif; ?>
		</div>
	</div>
  <!--END OF HEADER-->
</div>
<!--END OF HEADERWRAPPER-->
<div id="inner_content<?php if(has_slot("menu")): ?>_with_menu<?php endif; ?>">
	<?php if(has_slot("menu")): ?>
		<div id="menu_items">
			<?php include_slot("menu") ?>
		</div>
	<?php else:?>
		<div id="menu"></div>
	<?php endif; ?>
	<div id="page">
		<?=$sf_content ?>
		<br clear="all" />
	</div>
	<div id="pagebottom"></div>
</div>
<?php include_partial("global/footer"); ?>

<!--load overlay popup (getting started)-->
<?php if($sf_user->isAuthenticated()): ?>
<?php $contactCount=$sf_user->contactRedirectFun()?>

<?php if($contactCount<2):?>
<?php include_partial("contact/gettingStarted") ?>
<?php endif;?>
<?php endif;?>
</body>
</html>