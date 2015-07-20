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

// get last time it was executed
$last_run = OptionPeer::retrieveOption("NOTIFY_TAG_CHANGES_LAST_RUN");
$this_run = time();
OptionPeer::updateOption("NOTIFY_TAG_CHANGES_LAST_RUN",$this_run);
if(!$last_run) exit; // this is the very first time we run, just mark last run time

// convert to SQL standard
$last_run_sql = date('Y-m-d H:i:s',$last_run);
$this_run_sql = date('Y-m-d H:i:s',$this_run);

// get all changed info
$changed_objects = array();
foreach(ContactPeer::$CONTACT_CLASSES as $class)
{
	// build criteria
	$c = new Criteria();
	$c->add(eval("return {$class}Peer::UPDATED_AT;"),$last_run_sql,Criteria::GREATER_THAN);
	$c->addAnd(eval("return {$class}Peer::UPDATED_AT;"),$this_run_sql,Criteria::LESS_EQUAL);
	$c->addAnd(BookmarkPeer::USER_ID,null,Criteria::ISNOTNULL);
	if($class == "Email") $c->add(EmailPeer::IS_CONFIRMED,true);
	$c->addJoin(eval("return {$class}Peer::ID;"),eval("return Tag{$class}Peer::".strtoupper($class)."_ID;"),Criteria::LEFT_JOIN);
	$c->addJoin(eval("return Tag{$class}Peer::TAG_ID;"),TagPeer::ID,Criteria::LEFT_JOIN);
	$c->addJoin(TagPeer::ID,BookmarkPeer::TAG_ID,Criteria::LEFT_JOIN);

	// add select columns
	$c->addSelectColumn(TagPeer::ID);
	$c->addSelectColumn(BookmarkPeer::USER_ID);
	$c->addSelectColumn(eval("return {$class}Peer::ID;"));
	
	// find changed objects
	$changed_objects[$class] = call_user_func(array("{$class}Peer","doSelectRS"),$c);
}

// build a list of jotag->user->contact that will be notified
$changed_jotags = array();
foreach($changed_objects as $class=>$rs)
	while($rs->next())
	{
		$changed_jotags[$rs->getInt(1)][$rs->getInt(2)][$class][] = call_user_func(array("{$class}Peer","retrieveByPK"),$rs->getInt(3));
	}

//print_r($changed_jotags);exit;
// nofity each user
foreach($changed_jotags as $jotagID=>$data)
{
	$jotag = TagPeer::retrieveByPK($jotagID);
	$vcard = new Swift_Message_Attachment($jotag->getVCard()->fetch(),$jotag->getTagProfile()->__toString().'.vcf',"text/plain");
	foreach($data as $userID=>$contacts)
	{
		$user = UserPeer::retrieveByPK($userID);
		Mailer::sendEmail($user->getPrimaryEmail(),'changedJotag',array('jotag'=>$jotag,'user'=>$user,'contacts'=>$contacts),$user->getPreferedLanguage(),$vcard);
	}
}