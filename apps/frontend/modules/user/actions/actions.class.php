<?php

/**
 * user actions.
 *
 * @package    jotag
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class userActions extends sfActions
{
  public function executeLoginRequired($request)
  {
	if($this->isSoapRequest()) throw new SoapFault('Client','Permission Denied');

  	$this->getUser()->setFlash('referal',$this->getRequest()->getUri());
  	return $this->redirect('@login');
  }
  
  public function executeLogin($request)
  {
  	$redirect = trim($request->getParameter('redirect'));
  	$referal = $this->getUser()->getFlash('referal');
  	
   	$this->login_form = new LoginForm($redirect?array('referal'=>$this->getController()->genUrl('jotag/view?jotag='.$redirect.'&sf_format='.$request->getParameter('sf_format'),true)):($referal?array('referal'=>$referal):null));
   	if($request->isMethod('post'))
   	{
   		// process login
   		$this->login_form->bind($request->getParameter('login'));
		
   		if($this->login_form->isValid())
   		{
   			if(!$this->isWebserviceCall())
   			{
	   			// logged in, forward to HOME/Referal
	   			if($this->login_form->getValue('referal'))
	   				return $this->redirect($this->login_form->getValue('referal'));
	   			else return $this->redirect('@account');
   			}
   		}
   	}
  }
  
  public function executeLogout($request)
  {
  	$this->getUser()->signOut();
  	$this->redirect('@homepage');
  }
  
  public function executeSignup($request)
  {
  	// check invite id
  	$this->invite = InvitePeer::getFromField(InvitePeer::ID,$request->getParameter('invite_id'));
  	if(!$this->invite) $this->invite = InvitePeer::getFromField(InvitePeer::ID,$this->getUser()->getInviteId());
  	
  	if($request->isMethod('post'))
  	{
  		$this->form = new SignupForm();
  		
  		// process signup
  		$this->form->bind($request->getParameter('signup'));
  		if($this->form->isValid())
  		{
  			$user = new User();
  			$profile = new Profile();
  			$email = new Email();
  			$tag = new Tag();
  			
  			// setup profile
  			$profile->setFirstName($this->form->getValue('first_name'));
  			$profile->setLastName($this->form->getValue('last_name'));
  			
  			// set prefered language
  			$current_language = LanguagePeer::retrieveByCulture($this->getUser()->getCulture());
  			if(!$current_language) $current_language = LanguagePeer::getDefaultLanguage();
  			$profile->setLanguage($current_language);
  			
  			// set email
  			$email->setEmail($this->form->getValue('email'));
  			$email->setIsConfirmed(false);
  			$email->setIsPrimary(true);
  			$email->setConfirmCode($email->generateConfirmCode());
  			$email->setType(ContactPeer::TP_PERSONAL);
  			
  			// setup new user
  			$user->setPasswd($this->form->getValue('password'));
  			
  			// add profile and contact to user
  			$user->addProfile($profile);
  			$user->addEmail($email);
  			
  			if($this->invite)
  			{
  				$user->setUserRelatedByInvitedBy($this->invite->getUser());
  				
  				// add jotags to bookmark
  				if($this->invite->getInviteTagsJoinTag())
  				{
  					foreach($this->invite->getInviteTagsJoinTag() as $tagbm)
  					{
	  					// add to bookmark
  						$b = new Bookmark();
  						$b->setTag($tagbm->getTag());
  						$user->addBookmark($b);
  					}
  				}
  					
  				// delete invite from db
  				$this->invite->delete();
  				
  				// add initial credit to the user
  				$user->setCredits(OptionPeer::retrieveOption('BONUS_INVITE_CREDIT'));
  			}
  			else $user->setCredits(OptionPeer::retrieveOption('BONUS_INIT_CREDIT'));
  			
  			// save
  			$user->save();
  			$this->getUser()->clearInviteId();
  			
  			// generate JOTAG. We must do it after save because we use ID in the algorithm
  			$tag->setJotag($user->generateRandomJOTAG());
  			$tag->setIsPrimary(true);
  			$tag->setStatus(TagPeer::ST_NEW);
  			$tag->setBadge(BadgePeer::getDefaultBadge());
  			$tag->setUser($user);
  			
  			// link primary email to tag
  			$tm = new TagEmail();
  			$tm->setEmail($email);
  			$tag->addTagEmail($tm);
  			
  			// save new tag
  			$tag->save();

		    // send confirmation email
		    Mailer::sendEmail($email->getEmail(),'signupConfirmation',array('user'=>$user,'email'=>$email),$user->getPreferedLanguage());
 	    
		    $this->setMessage("SIGNUP","SUCCESS",array($email->getEmail()));
			if(!$this->isWebserviceCall()) $this->redirect('@homepage');
  		}
  	}
  	else 
  	{
	  	$first = $last = $email = "";
	  	if($this->invite)
	  	{
	  		// pre-populate first/last name, if available from invite
	  		$first = $this->invite->getFirstName();
	  		$last = $this->invite->getLastName();
	  		$email = $this->invite->getEmail();
	  	}
	  	$this->form = new SignupForm(array('first_name'=>$first,'last_name'=>$last,'email'=>$email));
	  	
	  	// set invite id, if available
  		$this->getUser()->setInviteId($this->invite?$this->invite->getId():null);
  	}
  }
 
  public function executeLostPassword($request)
  {
  	$this->form = new ForgotPasswordForm();
  	
  	if($request->isMethod('post'))
  	{
  		$this->form->bind($request->getParameter('forgot'));
  		if($this->form->isValid())
  		{
			$passwd = UserPeer::generateRandomPassword();

			// try both actual and email
  			$user = UserPeer::getUserFromEmail($this->form->getValue('email'));
			$user->setPasswd($passwd);
			$user->save();

			// send new password via email
		    Mailer::sendEmail($this->form->getValue('email'),'passwordReset',array('user'=>$user,'password'=>$passwd),$user->getPreferedLanguage());

		    if(!$this->isWebserviceCall())
		    {
			    $this->setMessage("PASSWORD_RESET","SUCCESS");
				$this->redirect('@homepage');
		    }
  		}
  	}
  }
 
  public function executeConfirmEmail($request)
  {
  	// we only accept GET method
  	$this->forward404Unless($request->isMethod('get'));
  	
  	$email = EmailPeer::getFromField(EmailPeer::CONFIRM_CODE,$this->getRequestParameter('confirm_code'));
  	if($email)
  	{
  		if($email->getIsPrimary() && !$email->getActualEmail())
  		{
  			// if invited, send acceptance email and add to quick contact
  			$user = $email->getUser();
  			if($user->getInvitedBy())
  			{
  				// add to bookmark
  				$b = new Bookmark();
  				$b->setUser($user->getUserRelatedByInvitedBy());
  				$b->setTag($user->retrievePrimaryJotag());
  				$b->save();
  				
  				// give credit to the inviter
  				$credits = $user->getUserRelatedByInvitedBy()->giveCredit(OptionPeer::retrieveOption('BONUS_ACCEPT_CREDIT'));
		    	Mailer::sendEmail($user->getUserRelatedByInvitedBy()->getPrimaryEmail(),'inviteAccepted',array('owner'=>$user->getUserRelatedByInvitedBy(),'user'=>$user,'email'=>$email,'credits'=>$credits),$user->getUserRelatedByInvitedBy()->getPreferedLanguage());
  			}
  			// activate primary jotag
  			$jotag = $email->getUser()->retrievePrimaryJotag();
  			$jotag->setStatus(TagPeer::ST_ACTIVE);
  			$jotag->save();
  			
  			$this->setMessage('ACCOUNT_CONFIRM','SUCCESS');
  		}
  		else $this->setMessage('EMAIL_CONFIRM','SUCCESS');
  		 
  		$email->setIsConfirmed(true);
  		$email->setConfirmCode(null);
  		$email->setActualEmail(null);
  		$email->save();
  	}
  	else $this->setMessage('EMAIL_CONFIRM_ERROR','ERROR');

  	$this->redirect('@homepage');
  }
  
  public function executeAccount($request)
  {
	$user=$this->user = $this->getUser()->getSubscriber();
	// get contacts info
    $this->urls = $user->getUrls();
    $this->emails = $user->getEmails();
    $this->addresses = $user->getAddresss();
    $this->phones = $user->getPhones();
    $this->sns = $user->getSNs();
    $this->ims = $user->getIMs();
  }

  public function executeProfile($request)
  {
  	$user = $this->getUser()->getSubscriber();
  	$this->form = new ProfileForm($user->getProfile());
  	if($request->isMethod('post'))
  	{
  		$this->form->bind($request->getParameter('profile'));
  		if($this->form->isValid())
  		{
  			// keep track of current culture
  			$culture = $this->form->getObject()->getLanguage()->getCulture();
  			
  			$this->form->save();
  			if(!$this->isWebserviceCall()) 
  			{
  				if($culture != $this->form->getObject()->getLanguage()->getCulture()) 
  					$this->getUser()->setCulture($this->form->getObject()->getLanguage()->getCulture());
  					
  				$this->redirect('@account');
  			}
  		}
  	}
  	$this->user = $user;
  }
  
  public function executePassword($request)
  {
  	$this->form = new PasswordForm();
  	if($request->isMethod('post'))
  	{
  		$this->form->bind($request->getParameter('password'));
  		if($this->form->isValid())
  		{
  			$user = $this->getUser()->getSubscriber();
  			$user->setPasswd($this->form->getValue('password'));
  			$user->save();
  			
  			if(!$this->isWebserviceCall()) $this->redirect('@account');
  		}
  	}
  }
  
  public function executeInviteWebmail($request)
  {
  	$errors = null;
  	if($request->isMethod('post'))
  	{
  		$this->wbForm = new InviteWebmailForm(array('provider'=>'yahoo'));
  		$this->wbForm->bind($request->getParameter('invite'));
  		if($this->wbForm->isValid())
  		{
  			// fetch contacts
  			$fetchURL = sprintf(sfConfig::get('app_importer_url'),$this->wbForm->getValue('provider'));
  			
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$fetchURL);
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS,'username='.urlencode($this->wbForm->getValue('username')).'&password='.urlencode($this->wbForm->getValue('password')));
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			$result = curl_exec($ch);
			
			$contacts = @unserialize($result);

			// parse emails
			$this->contacts = array();
			if($contacts)
			{
				foreach((array)$contacts as $contact)
				{
					// validate email
					try
					{
						$val = new sfValidatorEmail(array('required'=>true,'trim'=>true));
						$email = $val->clean($contact["contacts_email"]);
						$this->contacts[] = array_merge(InvitePeer::splitName(trim($contact["contacts_name"])),array("email"=>$email));
					}
					catch(sfValidatorError $e)
					{
						// do nothing
					}
				}
			}
			if(!count($this->contacts)) $errors[] = "- No contacts were found, please check your login details";
  		}
  		else
  		{
			// get errors into array
			if($this->wbForm["username"]->hasError()) $errors[] = "- ".$this->wbForm["username"]->getError();
			if($this->wbForm["password"]->hasError()) $errors[] = "- ".$this->wbForm["password"]->getError();
			if($this->wbForm["provider"]->hasError() && !$this->wbForm["username"]->hasError() && !$this->wbForm["password"]->hasError()) $errors[] = "- ".$this->wbForm["provider"]->getError();
  		}
  	}
  	$this->errors = $errors;
  }
  
  public function executeInvite($request)
  {
  	$user = $this->getUser()->getSubscriber();
  	
  	// fetch list of invites already sent by this user and hydrate users
  	$this->invites = $user->getInvites();
  	
  	$this->wbForm = new InviteWebmailForm(array('provider'=>'yahoo'));
  	$this->show_more = false;
  	if($request->isMethod('post'))
  	{
  		$this->form = new InviteForm($request->getParameter('invite'));
  		if($request->getParameter('step') == 'step2')
  		{
  			$message = trim($request->getParameter('message'));
  			
  			// re-validate emails
	  		$this->form->bind($request->getParameter('invite'));
	  		if(!$this->form->isValid())
	  		{
	  			// not valid, most likely user tried to mess up, so redirect back to invite
	  			$this->redirect('@invite');
	  		}

	  		$emails = $this->form->getValue("emails");
	  		$requested = $request->getParameter("chkEmail");
	  		$jotags = $request->getParameter("jotags");
	  		$jotag_objects = array();
	  		
	  		// check selected jotags
	  		if($jotags)
	  		{
	  			foreach($jotags as $tag)
	  			{
	  				$obj = TagPeer::getFromField(TagPeer::JOTAG,$tag);
	  				if($obj && $obj->getUserId() == $user->getId() && TagPeer::isValid($obj))
	  					$jotag_objects[] = $obj;
	  			}
	  		}
	  		
	  		$sent = 0;
  			foreach($emails as $k=>$email)
  			{
  				if(!EmailPeer::getFromField(EmailPeer::EMAIL,$email["email"]) && !EmailPeer::getFromField(EmailPeer::ACTUAL_EMAIL,$email["email"]))
  				{
	  				if(in_array($k,$requested))
	  				{
		  				// create new invite
		  				$invite = InvitePeer::newInvite($email,$user,$jotag_objects);
		  				
						// send invite
					    Mailer::sendEmail($email["email"],'invite',array('user'=>$user,'email'=>$email,'invite'=>$invite,'message'=>$message),$this->getUser()->getSubscriber()->getPreferedLanguage());
					    $sent++;
	  				}
  				}
  			}
  			$this->setMessage("SENT","SUCCESS",$sent);
  			$this->redirect('@invite');
  		}
  		else
  		{
	  		$this->form->bind($request->getParameter('invite'));
	  		if($this->form->isValid())
	  		{
	  			// here we have an already parsed email address
	  			$this->emails = $this->form->getValue('emails');
	  			$this->user = $user;
	  			
	  			// check emails already registered in the system
	  			$registered_count = 0;
	  			$total_emails = 0;
	  			foreach($this->emails as $k=>$v)
	  			{
	  				if(!$v["email"]) continue;
	  				
	  				$total_emails++;
	  				if(EmailPeer::getFromField(EmailPeer::EMAIL,$v["email"]) || EmailPeer::getFromField(EmailPeer::ACTUAL_EMAIL,$v["email"]))
	  				{
	  					$this->emails[$k]["registered"] = true;
	  					$registered_count++;
	  				}
	  				else $this->emails[$k]["registered"] = false;
	  			}
	  			
	  			// if all emails are already registered, redirect back to invite page
	  			if($registered_count == $total_emails)
	  			{
	  				$this->setMessage("ALL_REGISTERED","SUCCESS");
	  				$this->redirect("@invite");
	  			}
	  			
	  			return $this->setTemplate('inviteStep2');
	  		}
	  		else
	  		{
	  			// error in form, check if we should show extra lines
	  			$invites = $request->getParameter('invite');
	  			$invites = $invites["emails"];
	  			for($i=3;$i<6;$i++)
	  			{
	  				if(@$invites[$i]["first_name"] || @$invites[$i]["last_name"] || @$invites[$i]["email"])
	  				{
	  					$this->show_more = true;
	  					break;
	  				}
	  			}
	  		}
  		}
  	}
  	else $this->form = new InviteForm();
  }
  
  
  
   public function executeUpdateCredit($request)
  {
	$user = $this->getUser()->getSubscriber();
	
  	$user->setCredits(OptionPeer::retrieveOption('BONUS_INVITE_CREDIT'));  
	$user->save();
  }
  
  public function executePhoto($request)
  {
  	$this->user = $this->getUser()->getSubscriber();
  	$this->form = new AvatarForm();
  	if($request->isMethod('post'))
  	{
  		// validate form
  		$this->form->bind(array('avatar' => $request->getParameter('avatar')), array('avatar'=>$request->getFiles('avatar')));
  		if($this->form->isValid())
  		{
  		  $file = $this->form->getValue('avatar');
  		  $fileName = $this->user->getProfile()->getPhoto(false);
  		  if(!$fileName) $fileName = $this->user->getProfile()->generateAvatarName().'.jpg';
		  $file->save(sfConfig::get('sf_userimage_dir').DIRECTORY_SEPARATOR.$fileName);
		  
		  // update user object
		  $this->user->getProfile()->setPhoto($fileName);
		  $this->user->getProfile()->save();
		  
		  $this->redirect('@account');
  		}
  	}
  }

  public function executePhotoDel($request)
  {
  	$user = $this->getUser()->getSubscriber();
  	
  	$fileName = $user->getProfile()->getPhoto(false);
	if($fileName)
	{  	
	  	$user->getProfile()->setPhoto(null);
	  	$user->getProfile()->save();
	  	
	  	// remove from filesystem
	  	unlink(sfConfig::get('sf_userimage_dir').DIRECTORY_SEPARATOR.$fileName);
	}
  	$this->redirect('@account');
  }
    
  public function executeAddQuickContact($request)
  {
  	$user = $this->getUser()->getSubscriber();
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->jotag = $jotag;
  	$this->forward404Unless(($this->isWebserviceCall() || $request->isXmlHttpRequest()) && $jotag);
  	
  	// check privacy
	$this->form = new PrivacyCheckForm($this->jotag);
	$this->forward404Unless(TagPrivacyPeer::allowedToView($this->getUser(),$this->jotag,$this->form));
  	
  	$user->addQuickContact($jotag);
  	return $this->renderPartial('jotag/toolbar',array('jotag'=>$jotag));
  }
  
  public function executeDelQuickContacts($request)
  {
  	$jotags = $request->getParameter('jotags');
  	if(count((array)$jotags))
  	{
  		// get IDS
  		$jotagIDs = array();
  		foreach($jotags as $jotag)
  		{
  			$jobj = TagPeer::getFromField(TagPeer::JOTAG,$jotag);
  			if($jobj) $jotagIDs[] = $jobj->getId();	
  		}
  		
  		if(count($jotagIDs))
  		{
	  		$c = new Criteria();
	  		$c->add(BookmarkPeer::USER_ID,$this->getUser()->getSubscriberId());
	  		foreach($jotagIDs as $jid) $c->addOr(BookmarkPeer::TAG_ID,$jid);
	  		BookmarkPeer::doDelete($c);
  		}
  	}
  	
  	if(!$this->isWebserviceCall()) return $this->redirect('@quick_contacts');
  }
  
  public function executeQuickContacts($request)
  {
  	// get quick contacts
  	$c = new Criteria();
  	$c->addJoin(TagPeer::USER_ID,UserPeer::ID,Criteria::LEFT_JOIN);
  	$c->addJoin(UserPeer::ID,ProfilePeer::USER_ID,Criteria::LEFT_JOIN);
  	$c->addAscendingOrderByColumn(ProfilePeer::FIRST_NAME);
  	$c->addAscendingOrderByColumn(ProfilePeer::LAST_NAME);
  	$c->addAscendingOrderByColumn(TagPeer::JOTAG);
  	$this->contacts = $this->getUser()->getSubscriber()->getBookmarksJoinTag(TagPeer::getValidCriteria($c));
  }
   
  public function executeAddInterest($request)
  {
  	$user = $this->getUser()->getSubscriber();
  	$jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->forward404Unless($jotag && ($jotag->getUser()->getId() != $this->getUser()->getSubscriberId()) && !$user->hasInterest($jotag) && !$jotag->getIsPrimary());
  	
  	$this->jotag = $jotag;
  	$this->form = new AddInterestForm(array('jotag'=>$jotag->getJotag()));
  	if($request->isMethod('post'))
  	{
		$this->form->bind(array(
			'confirm_jotag'=>$request->getParameter('confirm_jotag'),
			'jotag'=>$request->getParameter('jotag')));
		if($this->form->isValid())
		{  		
			$user->addJotagInterest($jotag);
			
			// notify owner
		    Mailer::sendEmail($jotag->getUser()->getPrimaryEmail(),'interestNotifyOwner',array('user'=>$user,'jotag'=>$jotag),$jotag->getUser()->getPreferedLanguage());
			
		    $this->setMessage('ADD_INTEREST','SUCCESS',$jotag->getJotag());
			if(!$this->isWebserviceCall()) $this->redirect('@account');
		}
  	}
  }
  
  public function executeDelInterest($request)
  {
  	$user = $this->getUser()->getSubscriber();
  	$jotag = trim($request->getParameter('jotag'));
  	$this->forward404Unless($jotag && $user->hasInterest($jotag));
  	
  	$this->form = new AddInterestForm(array('jotag'=>$jotag));
  	if($request->isMethod('post'))
  	{
		$this->form->bind(array(
			'confirm_jotag'=>$request->getParameter('confirm_jotag'),
			'jotag'=>$request->getParameter('jotag')));
		if($this->form->isValid())
		{  		
			$user->delInterest($this->form->getValue('jotag'));
			
			$this->setMessage('DEL_INTEREST','SUCCESS',$jotag);
			if(!$this->isWebserviceCall()) $this->redirect('@account');
		}
  	}
  }
  
  /**
  * Change current language
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeSetLanguage($request)
  {
  	$language = LanguagePeer::retrieveByCulture($request->getParameter('culture'));
  	
  	if($language && $language->getIsActive()) $this->getUser()->setCulture($language->getCulture());
  	
	if($request->getReferer()) $this->redirect($request->getReferer());
	else $this->redirect("@homepage");
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
  
  
}