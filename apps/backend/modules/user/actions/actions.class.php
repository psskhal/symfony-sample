<?php

/**
 * user actions.
 *
 * @package    jotag
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class userActions extends autouserActions
{
  protected function addFiltersCriteria($c)
  {
  	if(isset($this->filters['name']))
  	{
  		foreach(explode(" ",$this->filters['name']) as $name)
  		{
  			// trim name
  			$name = trim($name);
  			if(!$name) continue;
  			
		  	// get criterions
		  	$ct1 = $c->getNewCriterion(ProfilePeer::FIRST_NAME, "%".$name."%",Criteria::LIKE);
		  	$ct2 = $c->getNewCriterion(ProfilePeer::LAST_NAME, "%".$name."%",Criteria::LIKE);
		  	
		  	$c->addJoin(UserPeer::ID, ProfilePeer::USER_ID);
		  	$ct1->addOr($ct2);
		  	$c->addOr($ct1);
  		}
  	}
  	
  	if(isset($this->filters['email']))
  	{
  		$c->setDistinct();
  		$c->addJoin(UserPeer::ID,EmailPeer::USER_ID);
  		$c->add(EmailPeer::EMAIL,"%".$this->filters['email']."%",Criteria::LIKE);
  	}
  }
  
  public function executeSearchUser($request)
  {
  	$data = $request->getParameter($request->getParameter("src"));
  	
  	$search = $data["user_id"];
  	$this->results = UserPeer::search($search);
  }
}
