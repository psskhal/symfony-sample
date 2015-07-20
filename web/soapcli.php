<?php
	$client = new SoapClient('http://dexter.barros.ws/jotag/soap.wsdl',array('trace'=>true));
	$client->__setCookie('JOTAGSESSION','77f845d8ef25db15dbfbc6cfc4950e51');
	print_r($client->__getFunctions());
	
	print_r($client->soap_getLanguages());
	print_r($client->soap_getCurrentLanguage());
	$client->soap_setCurrentLanguage(1);
	print_r($client->soap_getCurrentLanguage());
	
	$client->soap_configureJotag('RHY 575','Carlos 123',array(3),null,null,null,null,null,false);
	
	//$client->soap_login(array('email'=>'jotag@barros.ws','password'=>'budega'));
	print_r($client->soap_getProfile());
	$client->soap_saveProfile(array('first_name'=>'Testing','last_name'=>'Soap','language_id'=>2));
	print_r($client->soap_getProfile());
	//print_r($client->soap_viewJotag("barros",array('pin'=>'budega','message'=>'Hey man, let me in!!','captcha'=>'z48mx2')));
?>
