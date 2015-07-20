<?php
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);

// initialize instance
sfContext::createInstance($configuration);

// set default TIMEZONE
$tz = OptionPeer::retrieveOption('TIMEZONE');
if($tz) date_default_timezone_set($tz);

$c = new Criteria();
$expiration_age = OptionPeer::retrieveOption('INVITE_AGE') * 24 * 3600;
$c->add(InvitePeer::CREATED_AT, time() - $expiration_age, Criteria::LESS_EQUAL);
InvitePeer::doDelete($c);