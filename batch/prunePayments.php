<?php
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);

// initialize instance
sfContext::createInstance($configuration);

// set default TIMEZONE
$tz = OptionPeer::retrieveOption('TIMEZONE');
if($tz) date_default_timezone_set($tz);

$c = new Criteria();
$expiration_age = OptionPeer::retrieveOption('BUY_NEW_ORDER_LIFETIME');
$c->add(PaymentPeer::CREATED_AT, time() - $expiration_age, Criteria::LESS_EQUAL);
$c->add(PaymentPeer::STATUS,PaymentPeer::ST_NEW);

$payments = PaymentPeer::doSelect($c);
if($payments)
{
	foreach((array)$payments as $payment)
	{
		$payment->setStatus(PaymentPeer::ST_CANCELLED);
		$payment->save();
	}
}