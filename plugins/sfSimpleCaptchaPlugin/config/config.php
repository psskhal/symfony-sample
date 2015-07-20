<?php
	// set font path
	sfConfig::set('app_simple_captcha_font','monofont.ttf');
	sfConfig::set('app_simple_captcha_route','/captcha.jpg');
	
	// connect captcha route
	$this->dispatcher->connect('routing.load_configuration', array('sfSimpleCaptchaRouting', 'listenToRoutingLoadConfigurationEvent'));
