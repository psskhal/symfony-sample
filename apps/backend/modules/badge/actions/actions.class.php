<?php

/**
 * badge actions.
 *
 * @package    jotag
 * @subpackage badge
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class badgeActions extends autobadgeActions
{
  /**
  * Handles setDefault action
  *
  * @param sfRequest $request A request object
  */
  public function executeSetDefault($request)
  {
  	$c = BadgePeer::retrieveByPK($request->getParameter('id'));
  	if($c) $c->setAsDefault();
  	
  	$this->redirect('badge/list');
  }
  
  /**
  * Toogle active/inactive language
  * 
  * @param sfWebRequest $request
  */
  public function executeToggleActive($request)
  {
  	$c = BadgePeer::retrieveByPK($request->getParameter('id'));
  	if($c && !$c->getIsDefault())
  	{
  		$c->setIsActive(!$c->getIsActive());
  		$c->save();
  	}
  	$this->redirect('badge/list');
  }
  
  /**
   * Handles delete action
   */
  public function executeDelete()
  {
  	$c = BadgePeer::retrieveByPK($this->getRequest()->getParameter('id'));
  	if(!$c || !$c->getIsDefault()) parent::executeDelete();
  	else 
  	{
  		$this->getRequest()->setError('delete','You can\'t delete default badge');
  		$this->forward('badge','list');
  	}
  }
}
