<?php
class sfValidatorSimpleCaptcha extends sfValidatorBase
{
	protected function configure($options = array(), $messages = array())
	{
		$this->addMessage('captcha', 'The captcha is not valid.');
	}
	
	protected function doClean($value)
	{
		$code = sfSimpleCaptcha::getSecurityCode(true);
		
//		die("code = $code, value = $value");
		if($code && ($code == $value)) return $value;

		throw new sfValidatorError($this, 'captcha', array());
	}
}