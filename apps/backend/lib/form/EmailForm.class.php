<?php

/**
 * Email form.
 *
 * @package    form
 * @subpackage jotag_tags
 * @version    SVN: $Id: sfPropelFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class EmailForm extends BaseEmailForm
{
  public function configure()
  {
  	// remove undesired fields
  	unset($this["created_at"],$this["updated_at"],$this["tag_email_list"],$this["is_primary"],$this["actual_email"]);
  	
  	// customize user_id
  	$this->widgetSchema["user_id"] = new sfWidgetFormSearchUser(array("src"=>"email","plain"=>$this->getObject()->getIsPrimary()));
  	$this->validatorSchema["user_id"] = new sfValidatorSearchUser();
  	$this->validatorSchema["user_id"]->setMessage('invalid','Email address not found');
  	$this->validatorSchema["user_id"]->setMessage('required','Please enter an user email address');
  	if(!$this->getObject()->isNew()) $this->getObject()->setUserId($this->getObject()->getUser()->getPrimaryEmail());
  	
  	// customize type
  	$this->widgetSchema["type"] = new sfWidgetFormSelect(array('choices'=>ContactPeer::$EMAIL_TYPES));
  	$this->validatorSchema["type"] = new sfValidatorChoice(array('choices'=>array_keys(ContactPeer::$EMAIL_TYPES)));
  	
  	// customize email
  	$this->validatorSchema["email"] = new sfValidatorEmail();
  	$this->validatorSchema["email"]->setOption("required",true);
  	$this->validatorSchema["email"]->setOption("trim",true);
  	$this->validatorSchema["email"]->setMessage("required","Please enter the email address");
  	$this->validatorSchema["email"]->setMessage("invalid","Invalid email address");
  	
  	// post validator
    $this->validatorSchema->setPostValidator(
       new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Email', 'column' => array('email'))),
        new sfValidatorPropelUnique(array('model' => 'Email', 'column' => array('confirm_code'))),
      	new contactTypeValidator(array('type'=>'type','custom_type'=>'custom_type'),array('invalid'=>'Please enter a custom type')),
      ))
    );
  }
}