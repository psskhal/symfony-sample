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

// set expired tags as EXPIRED
$con = Propel::getConnection(TagPeer::DATABASE_NAME);
try
{
	$con->begin();
	
	$query = sprintf("UPDATE %s SET %s = %d WHERE %s <= ? AND %s = %d AND %s = 0",TagPeer::TABLE_NAME,TagPeer::STATUS,TagPeer::ST_EXPIRED,TagPeer::VALID_UNTIL,TagPeer::STATUS,TagPeer::ST_ACTIVE,TagPeer::IS_PRIMARY);
	$stmt = $con->prepareStatement($query);
	$stmt->setString(1,strftime("%Y-%m-%d 00:00:00"));
	$stmt->executeQuery();
	$con->commit();
}
catch(Exception $e)
{
	$con->rollback();
	throw $e;
}

$alert_days = explode(",",OptionPeer::retrieveOption('BUY_EXPIRE_ALERTS'));
$today = getdate();
foreach($alert_days as $day)
{
	// build range
	$start = strftime('%Y-%m-%d %H:%M:%S',mktime(0,0,0,$today['mon'],$today['mday']+$day,$today['year']));
	$end = strftime('%Y-%m-%d %H:%M:%S',mktime(0,0,0,$today['mon'],$today['mday']+$day+1,$today['year']));
	
	// fetch jotags
	$c = new Criteria();
	$c->add(TagPeer::IS_PRIMARY,false);
	if($day > 0) $c->add(TagPeer::STATUS,TagPeer::ST_ACTIVE);
	else $c->add(TagPeer::STATUS,TagPeer::ST_EXPIRED);
	$c->add(TagPeer::VALID_UNTIL,$start,Criteria::GREATER_EQUAL);
	$c->addAnd(TagPeer::VALID_UNTIL,$end,Criteria::LESS_THAN);
	$tags = TagPeer::doSelect($c);
	if($tags)
	{
		foreach($tags as $tag)
		{
    		Mailer::sendEmail($tag->getUser()->getPrimaryEmail(),'expireReminder',array('jotag'=>$tag,'days'=>$day),$tag->getUser()->getPreferedLanguage());
		}
	}
}