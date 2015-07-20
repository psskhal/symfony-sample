<?php

/**
 * Payment form.
 *
 * @package    form
 * @subpackage jotag_payments
 * @version    SVN: $Id: sfPropelFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class PaymentForm extends BasePaymentForm
{
  public function configure()
  {
  	// unset undesired fields
  	unset($this["id"],$this["created_at"],$this["jotag"],$this["credits"],$this["user_id"]);
  	
  	// customize jotag
  	if($this->getObject()->isNew())
  	{
	  	$this->widgetSchema["tag_id"] = new sfWidgetFormSearchTag(array("src"=>"payment","plain"=>!$this->getObject()->isNew()));
  		$this->validatorSchema["tag_id"] = new sfValidatorSearchTag();
  		$this->validatorSchema["tag_id"]->setMessage('invalid','JoTAG not found');
  		$this->validatorSchema["tag_id"]->setMessage('required','Please enter a JoTAG');
  	}
  	else unset($this["tag_id"]);
	
	// customize method
	$this->widgetSchema["method"] = new sfWidgetFormSelect(array('choices'=>PaymentPeer::$PAYMENT_METHODS));
	$this->validatorSchema["method"] = new sfValidatorChoice(array("choices"=>array_keys(PaymentPeer::$PAYMENT_METHODS)));
	
	// customize duration
	$this->widgetSchema["duration"]->setAttribute("size",10);
	$this->widgetSchema->setHelp("duration","For \"Redeemed Credits\" enter number of DAYS, otherwise enter number of YEARS");
	$this->validatorSchema["duration"]->setMessage("required","Please enter duration");
	$this->validatorSchema["duration"]->setMessage("invalid","Invalid number");
	
	// customize amount
	$this->widgetSchema["amount"]->setAttribute("size",10);
	$this->widgetSchema->setHelp("amount","For \"Redeemed Credits\", use enter number of credits, otherwise enter currency");
	$this->validatorSchema["amount"]->setOption("required",true);
	$this->validatorSchema["amount"]->setMessage("required","Please enter amount");
	$this->validatorSchema["amount"]->setMessage("invalid","Invalid number");
	if($this->getObject()->getMethod() == PaymentPeer::PT_CREDITS) $this->getObject()->setAmount($this->getObject()->getCredits());
	
	// customize type
	$this->widgetSchema["type"] = new sfWidgetFormSelect(array('choices'=>PaymentPeer::$PAYMENT_TYPES));
	$this->validatorSchema["type"] = new sfValidatorChoice(array("choices"=>array_keys(PaymentPeer::$PAYMENT_TYPES)));
	
	// customize status
	$this->widgetSchema["status"] = new sfWidgetFormSelect(array('choices'=>PaymentPeer::$PAYMENT_STATUSES));
	$this->validatorSchema["status"] = new sfValidatorChoice(array("choices"=>array_keys(PaymentPeer::$PAYMENT_STATUSES)));
	
	$this->validatorSchema->setPostValidator(
      new sfValidatorPass()
    );
  }
  
  public function updateObject()
  {
  	$object = parent::updateObject();

  	if($object->isNew())
  	{
  		// set userid
  		$object->setUser($object->getTag()->getUser());
  	}
  	
  	// check payment method
  	if($object->getMethod() == PaymentPeer::PT_CREDITS)
  	{
  		$object->setCredits($object->getAmount());
  		$object->setAmount(0);
  	}
  	else
  	{
  		$object->setCredits(0);
  	}
  	
  	return $object;
  }
}
