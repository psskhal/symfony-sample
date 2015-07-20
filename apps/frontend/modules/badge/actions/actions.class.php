<?php

/**
 * badge actions.
 *
 * @package    jotag
 * @subpackage badge
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class badgeActions extends sfActions
{
  /**
  * Handles comm action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeComm($request)
  {
  	$this->getUser()->setAttribute("domain",$request->getParameter("domain"),"badge");
  }
  
  /**
  * Handles badge action
  *
  * @param sfWebRequest $request Web request object
  */
  public function executeBadge($request)
  {
  	$this->jotag = TagPeer::getFromField(TagPeer::JOTAG,$request->getParameter('jotag'));
  	$this->forward404Unless($this->jotag && ($this->jotag->getStatus() == TagPeer::ST_ACTIVE));
  	
  	// get badge
  	$this->badge = $this->jotag->getBadge();
  	
  	// is authorized
  	$this->authorized = TagPrivacyPeer::allowedToView($this->getUser(),$this->jotag);
  	
  	// reload
  	$this->reload = $request->getParameter('reload')?true:false;
  	
  	// build list of contact info
	$this->contacts = Array();
	  	
	$jotag =& $this->jotag;
	if($jotag->getTagEmailsJoinEmail(EmailPeer::buildConfirmedCriteria()))
		foreach ($jotag->getTagEmailsJoinEmail(EmailPeer::buildConfirmedCriteria()) as $k=>$email)
			$this->contacts["EMAIL"][] = $email->getEmail()->getEmail($this->authorized);
	

	if($jotag->getTagPhonesJoinPhone())
		foreach ($jotag->getTagPhonesJoinPhone() as $k=>$phone)
			$this->contacts["PHONE"][] = array(
				"number"	=> $phone->getPhone()->getNumber($this->authorized),
				"exten"	=> $phone->getPhone()->getExten($this->authorized)
			);
	
	if($jotag->getTagUrlsJoinUrl())
		foreach ($jotag->getTagUrlsJoinUrl() as $k=>$url)
			$this->contacts["URL"][] = $url->getUrl()->getUrl($this->authorized);
	
	if($jotag->getTagSNsJoinSN())
		foreach ($jotag->getTagSNsJoinSN() as $k=>$sn)
			$this->contacts["SN"][] = array(
				"network"		=> $sn->getSN()->getNetwork(),
				"identifier"	=> $sn->getSN()->getIdentifier($this->authorized)
			);
			
	if($jotag->getTagIMsJoinIM())
		foreach ($jotag->getTagIMsJoinIM() as $k=>$im)
			$this->contacts["IM"][] = array(
				"network"		=> $im->getIM()->getNetwork(),
				"identifier"	=> $im->getIM()->getIdentifier($this->authorized)
			);
	
	if($jotag->getTagCustomsJoinCustom())
		foreach ($jotag->getTagCustomsJoinCustom() as $k=>$custom)
			$this->contacts["CUSTOM"][] = array(
				"netname"		=> $custom->getCustom()->getNetName(),
				"netid"	=> $custom->getCustom()->getNetId($this->authorized)
			);
  }
}
?>