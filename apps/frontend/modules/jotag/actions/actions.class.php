<?php
/**
 * jotag actions.
 *
 * @package    jotag
 * @subpackage jotag
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class jotagActions extends sfActions
{
  public function executeSearch($request)
  {
  	$search = trim($request->getParameter('search'));
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$search);
  	
  	// check if active
  	if($jotag && ($jotag->getStatus() == TagPeer::ST_ACTIVE))
  	{
  		// ok, jotag found, send user to view page
  		$this->redirect("@view_jotag?jotag=".$jotag->getJotag() );
  	}
  	
  	// not found
  	$this->search_jotag = $search;
  	return sfView::ERROR;
  }

  /**
  * Handles view action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeView($request)
  {
  	$this->jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	
  	// check if active
  	if(!$this->jotag || ($this->jotag->getStatus() != TagPeer::ST_ACTIVE))
		$this->forward404();
		
	if(!$this->jotag->haveContacts()) return sfView::ERROR;
	
	$nextOption = $this->getUser()->getAttribute('nextOption');
	
	// check privacy settings
	$this->form = new PrivacyCheckForm($this->jotag,array('webservice'=>$this->isWebserviceCall()),null, $nextOption);
		
	if(!TagPrivacyPeer::allowedToView($this->getUser(),$this->jotag))
	{
		// user not allowed to view jotag, display security check form
		if($request->isMethod('post'))
		{
			$this->form->bind($request->getParameter('privacy'));
						
			if($this->form->isValid())
			{	
				if($this->jotag->getTagPrivacy()->getPrivacyType() == TagPrivacyPeer::PRIVACY_AUTH || $nextOption == "fck editor")
				{
					if(!$this->getUser()->isAuthenticated()) throw new sfException('User must be logged in to perform this action');
					if($this->jotag->getAuthStatus($this->getUser()->getSubscriber()) != TagAuthPeer::STATUS_NONE) throw new sfException('User already requested authorization');
					
					// add authorization request
					$this->jotag->addAuthRequest($this->getUser()->getSubscriber());
					
					// change format back to html
					$sf_format = $request->getParameter("sf_format");
					$request->setRequestFormat("html");
					
					// notify owner
					Mailer::sendEmail($this->jotag->getUser()->getPrimaryEmail(),'authRequest',array('jotag'=>$this->jotag,'user'=>$this->getUser()->getSubscriber(),'message'=>$this->form->getValue('message')),$this->jotag->getUser()->getPreferedLanguage());
					
					//$this->getUser()->getAttributeHolder()->remove('nextOption');
					
					$this->redirect("jotag/view?jotag=".$this->jotag->getJotag().'&sf_format='.$sf_format);
				}
				else
				{
					// user passed security check, allow him to view
					TagprivacyPeer::allowToView($this->getUser(),$this->jotag);
					
					$this->redirect("jotag/view?jotag=".$this->jotag->getJotag().'&sf_format='.$request->getParameter('sf_format'));
				}
			}
		}
		
		// not authorized
		return sfView::ERROR;
	}
	$this->allowed = true;
	$this->show = $request->getParameter('show')?true:false;
  }
  
  /**
  * Handles receipt action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeReceipt($request)
  {
  	$this->jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	$this->user = $this->jotag->getUser();
  	
  	$c = new Criteria();
  	$c->addDescendingOrderByColumn(PaymentPeer::CREATED_AT);
  	$c->add(PaymentPeer::STATUS,PaymentPeer::ST_PAID);
  		
  	// get payments
  	$this->payments = $this->jotag->getPayments($c);
  	//$this->forward404Unless($this->payments);
  }
  
 /**
  * Handles cancel action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeCancel($request)
  {
  	$this->jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	//$this->forward404Unless($this->jotag && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId())); // && ($this->jotag->getStatus() == TagPeer::ST_EXPIRED));
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	$this->user = $this->jotag->getUser();
  	
	$this->form = new CancelJotagForm(array('jotag'=>$this->jotag->getJotag()));
	if($request->isMethod('post'))
	{
		$this->form->bind(array(
			'jotag'=>$request->getParameter('jotag'),
			'confirm_jotag'=>$request->getParameter('confirm_jotag'),
			'agree'=>$request->getParameter('agree')));
		if($this->form->isValid())
		{
			$interesteds = $this->jotag->getInteresteds();
			
			// delete JoTAG
			$this->jotag_name = $this->jotag->getJotag();
			$this->jotag->deleteFromUser();
			
			if($interesteds)
			{
				foreach($interesteds as $interested)
				{
					// notify interested users that this jotag is available again
				    Mailer::sendEmail($interested->getUser()->getPrimaryEmail(),'interestNotifyInterested',array('user'=>$interested->getUser(),'jotag'=>$interested->getJotag()),$interested->getUser()->getPreferedLanguage());
				}
			}

  			$this->setMessage("CANCEL_JOTAG","SUCCESS",$this->jotag->getJotag());
  			$this->redirect("user/account");
		}
	}
  }
  
  /**
  * Handles configure action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeConfigure($request)
  {
  	$this->jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	$this->user = $this->jotag->getUser();
  	
  	if($request->isMethod('post'))
  	{
		$this->jotag->clearContacts();
		foreach(array('Email','Address','Phone','Url','IM','SN','Custom') as $contact)
		{
			foreach((array)$request->getParameter(strtolower($contact)) as $id)
			{
				$obj = call_user_func(array($contact.'Peer','retrieveByPK'),$id);
				
				// security check
				if($obj && ($obj->getUserId() == $this->getUser()->getSubscriberId()))
				{
					// add contact to the mapping list
					$className = 'Tag'.$contact;
					$map = new $className();
					call_user_func(array($map,'set'.$contact),$obj);
					//echo "<pre>";print_r($map);echo "</pre>";
					$map->setTagId($this->jotag->getId());
					$map->save();
				}
			}
		}
		if($request->getParameter('link_by_default') == 'Y') $this->jotag->setLinkByDefault(true);
		else $this->jotag->setLinkByDefault(false);
		$this->jotag->save();
		
		// update jotag profile
		$this->jotag->getTagProfile()->setDisplayName(trim($request->getParameter('display_name')));
		$this->jotag->getTagProfile()->save();
		
		if(!$this->isWebserviceCall()) {
			$this->setMessage("JOTAG_CONFIGURED","SUCCESS",$this->jotag->getJotag());
			$this->redirect('@account');
		}
  	}
  }
  
  public function executePhoto($request)
  {
  	$this->jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	$this->user = $this->jotag->getUser();
  	
  	$this->form = new JotagAvatarForm();
  	if($request->isMethod('post'))
  	{
  		// validate form
  		$this->form->bind(array('avatar' => $request->getParameter('avatar')), array('avatar'=>$request->getFiles('avatar')));
  		if($this->form->isValid())
  		{
  		  $file = $this->form->getValue('avatar');
  		  $fileName = $this->jotag->getTagProfile()->getPhoto(false);
  		  if(!$fileName) $fileName = $this->jotag->getTagProfile()->generateAvatarName().'.jpg';
		  $file->save(sfConfig::get('sf_userimage_dir').DIRECTORY_SEPARATOR.$fileName);
		  
		  // update jotag object
		  $this->jotag->getTagProfile()->setPhoto($fileName);
		  $this->jotag->getTagProfile()->save();
		  
		  $this->redirect('@configure?jotag='.$this->jotag->getJotag());
  		}
  	}
  }

  public function executePhotoDel($request)
  {
  	$this->jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	$this->user = $this->jotag->getUser();
  	
  	$fileName = $this->jotag->getTagProfile()->getPhoto(false);
	if($fileName)
	{  	
	  	$this->jotag->getTagProfile()->setPhoto(null);
	  	$this->jotag->getTagProfile()->save();
	  	
	  	// remove from filesystem
	  	unlink(sfConfig::get('sf_userimage_dir').DIRECTORY_SEPARATOR.$fileName);
	}
  	$this->redirect('@configure?jotag='.$this->jotag->getJotag());
  }
  
  /**
  * Handles privacy action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executePrivacy($request)
  {
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->jotag = $jotag;
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	
  	$this->form = new TagPrivacyForm($this->jotag->getTagPrivacy());
  	if($request->isMethod('post'))
  	{
  		$this->form->bind($request->getParameter('tag_privacy'));
  		if($this->form->isValid())
  		{
  			// save privacy
  			$this->form->save();
  			
			$this->setMessage("PRIVACY_SAVED","SUCCESS");  			
  			
  			// go back to details page
  			$this->redirect("@configure?jotag=".$this->jotag->getJotag());
  		}
  	}
  }
  
  /**
  * Handles cbadge action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeBadge($request)
  {
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->jotag = $jotag;
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	
  	$this->form = new TagBadgeForm($this->jotag);
  	if($request->isMethod('post'))
  	{
		if($this->form->bind($request->getParameter('tag')));
		if($this->form->isValid())
		{
			// save badge
			$this->form->save();

			$this->setMessage("BADGE_SAVED","SUCCESS");
			
			// go back to details page
			$this->redirect("@configure?jotag=".$this->jotag->getJotag());
		}
  	}
  }
  
  /**
  * Handles accept request action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeAcceptRequest($request)
  {
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->jotag = $jotag;
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	
  	// get user
  	$user = UserPeer::retrieveByPK($request->getParameter('user'));
  	$this->forward404Unless($user);
  	
  	// verify user
  	$tauth = $jotag->getRequestByUser($user);
  	$this->forward404Unless($tauth->getStatus() != TagAuthPeer::STATUS_NONE);
  	
  	if($jotag->acceptRequestFromUser($user))
  	{
  		// build vcard attachment
  		$vcard = new Swift_Message_Attachment($jotag->getVCard()->fetch(),$jotag->getTagProfile()->__toString().'.vcf',"text/plain");
  		
  		// email user
  		Mailer::sendEmail($user->getPrimaryEmail(),'requestAccepted',array('user'=>$user,'jotag'=>$jotag),"",$vcard);
  	}
  	
  	$this->setMessage("AUTH_ACCEPTED","SUCCESS");
  	$this->redirect("@manage_auth_request?jotag=".$this->jotag->getJotag());
  }
  
  /**
  * Handles reject request action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeRejectRequest($request)
  {
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->jotag = $jotag;
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	
  	// get user
  	$user = UserPeer::retrieveByPK($request->getParameter('user'));
  	$this->forward404Unless($user);
  	
  	// verify user
  	$tauth = $jotag->getRequestByUser($user);
  	$this->forward404Unless($tauth->getStatus() != TagAuthPeer::STATUS_NONE);
  	
  	if($jotag->rejectRequestFromUser($user))
  	{
  		// email user
  		Mailer::sendEmail($user->getPrimaryEmail(),'requestRejected',array('user'=>$user,'jotag'=>$jotag));
  	}
  	
  	$this->setMessage("AUTH_REJECTED","SUCCESS");
  	$this->redirect("@manage_auth_request?jotag=".$this->jotag->getJotag());
  }
  
  /**
  * Handles discard request action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeDiscardRequest($request)
  {
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->jotag = $jotag;
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));
  	
  	// get user
  	$user = UserPeer::retrieveByPK($request->getParameter('user'));
  	$this->forward404Unless($user);
  	
  	// verify user
  	$tauth = $jotag->getRequestByUser($user);
  	$this->forward404Unless($tauth->getStatus() != TagAuthPeer::STATUS_NONE);

  	if($tauth->getStatus() == TagAuthPeer::STATUS_PENDING) $this->setMessage("AUTH_DISCARDED","SUCCESS");
  	else $this->setMessage("AUTH_DELETED","SUCCESS");
  	
  	$tauth->delete();
  	$this->redirect("@manage_auth_request?jotag=".$this->jotag->getJotag());
  }
  
  /**
  * Handles manage requests action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeManageRequests($request)
  {
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->jotag = $jotag;
  	$this->forward404Unless($this->jotag && TagPeer::isValid($this->jotag) && ($this->jotag->getUser()->getId() == $this->getUser()->getSubscriberId()));// && ($jotag->getTagPrivacy()->getPrivacyType() == TagPrivacyPeer::PRIVACY_AUTH));
  	
  	$this->pending = $jotag->getTagAuthsJoinUser(TagAuthPeer::buildPendingCriteria());
  	$this->authorized = $jotag->getTagAuthsJoinUser(TagAuthPeer::buildAuthorizedCriteria());
  	$this->denied = $jotag->getTagAuthsJoinUser(TagAuthPeer::buildDeniedCriteria());
  }
  
  /**
  * Handles vcard action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeVcard($request)
  {
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->jotag = $jotag;
  	$this->forward404Unless($jotag && ($jotag->getStatus() == TagPeer::ST_ACTIVE) && $jotag->haveContacts());
  	
  	// check privacy
	$this->form = new PrivacyCheckForm($this->jotag);
	$this->forward404Unless(TagPrivacyPeer::allowedToView($this->getUser(),$this->jotag,$this->form));

  	// get vcard (convert to ISO-8859-1)
  	$this->vcard = $jotag->getVCard()->fetch();
  	
    // Set the headers for downloading vcard
	$this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename="'.$jotag->getTagProfile()->__toString().'.vcf"');
	$this->getResponse()->setHttpHeader('Content-length',strlen($this->vcard));
  }
  
  /*
   * General routines
   */
  private function setMessage($msg,$type,$params=null)
  {
  	$this->getUser()->setFlash('message',$msg);
  	$this->getUser()->setFlash('type',$type);
	$this->getUser()->setFlash('params',$params);
  }
  
  private function isWebserviceCall()
  {
  	return $this->isSoapRequest();
  }
  
  public function executeNextOption($request)
  {
	  $jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	  $this->jotag = $jotag;
	  $this->form = new PrivacyCheckForm($this->jotag,array('webservice'=>$this->isWebserviceCall()));
	  
	  $nextOption = "fck editor";
	  $this->form->configure($nextOption);
 
	 // Store data in the user session
	 $this->getUser()->setAttribute('nextOption', "fck editor");
	 
	 
	  //TagprivacyPeer::allowToView($this->getUser(),$this->jotag);
      //$this->redirect("@view_jotag?jotag=".$jotag->getJotag());
	  //javascript_tag("window.location='@view_jotag?jotag=".$jotag->getJotag()."'; alert('here');");
  }
  
  public function executeBackOption($request)
  {
	  $jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	  $this->jotag = $jotag;
	  $this->getUser()->getAttributeHolder()->remove('nextOption');
  }
  
}
