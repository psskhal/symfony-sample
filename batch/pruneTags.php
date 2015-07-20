<?php
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);

// initialize instance
sfContext::createInstance($configuration);

// set default TIMEZONE
$tz = OptionPeer::retrieveOption('TIMEZONE');
if($tz) date_default_timezone_set($tz);

// load URL helper
sfLoader::loadHelpers('Url');
sfConfig::set('sf_relative_url_root',sfConfig::get('app_general_base_url')); 

$c = new Criteria();
$expiration_age = OptionPeer::retrieveOption('BUY_DELETE_AFTER') * 24 * 3600;
$c->add(TagPeer::VALID_UNTIL, time() - $expiration_age, Criteria::LESS_EQUAL);
$c->add(TagPeer::STATUS,TagPeer::ST_EXPIRED);
$c->add(TagPeer::IS_PRIMARY,false);
$tags = TagPeer::doSelect($c);
if($tags)
{
	foreach($tags as $tag)
	{
		$interesteds = $tag->getInteresteds();
		
		$jotag = $tag->getJotag();
		$tag->deleteFromUser();
		
    	Mailer::sendEmail($tag->getUser()->getPrimaryEmail(),'deletedJotag',array('jotag'=>$tag,'jotag_name'=>$jotag),$tag->getUser()->getPreferedLanguage());
    	
		if($interesteds)
		{
			foreach($interesteds as $interested)
			{
				// notify interested users that this jotag is available again
			    Mailer::sendEmail($interested->getUser()->getPrimaryEmail(),'interestNotifyInterested',array('user'=>$interested->getUser(),'jotag'=>$interested->getJotag()),$interested->getUser()->getPreferedLanguage());
			}
		}
	}
}
?>