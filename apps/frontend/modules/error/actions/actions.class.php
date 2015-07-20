<?php

/**
 * error actions.
 *
 * @package    tevenow
 * @subpackage error
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class errorActions extends sfActions
{
	public function executeLogin($request)
	{
		if($request->isXmlHttpRequest())
		{
			$this->url = '@homepage';
			return $this->setTemplate('jsRedirect');
		}
		$this->redirect('@homepage');
	}
	
	public function executeError404()
	{
	}
	
	public function executeSecure()
	{
	}
	
	public function executeDisabled()
	{
	}
}
