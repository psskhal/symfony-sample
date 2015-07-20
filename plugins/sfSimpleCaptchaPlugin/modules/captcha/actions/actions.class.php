<?php
/**
 * Captcha actions
 *
 * @package sfSimpleCaptcha
 * @author Carlos Eduardo O. A. Barros
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class captchaActions extends sfActions
{
  /**
  * Handles index action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeIndex($request)
  {
  	$this->captcha = new sfSimpleCaptcha();
  	
  	// change mime type
	$this->getResponse()->setHttpHeader('Content-Type', 'image/jpeg', true);
	$this->getResponse()->sendHttpHeaders();  	
  }
}