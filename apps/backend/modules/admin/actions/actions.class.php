<?php

/**
 * admin actions.
 *
 * @package    jotag
 * @subpackage admin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class adminActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
  }
  
  /**
  * Executes login action
  *
  *
  * @param sfRequest $request A request object
  */
  public function executeLogin($request)
  {
	$this->form = new LoginForm();
	if($request->isMethod('post'))
	{
		$this->form->bind($request->getParameter('login'));
		if($this->form->isValid())
			$this->redirect('@homepage');
	}
  }
  
  /**
  * Executes logout action
  *
  * @param sfRequest $request A request object
  */
  public function executeLogout($request)
  {
  	$this->getUser()->signOut();
  	$this->redirect('@homepage');
  }
}
