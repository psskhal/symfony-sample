<?php

/**
 * Tag form.
 *
 * @package    form
 * @subpackage jotag_tags
 * @version    SVN: $Id: sfPropelFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class TagForm extends BaseTagForm
{
  public function configure()
  {
  	// remove undesired fields
  	unset($this["is_primary"],$this["is_credit"],$this["created_at"],$this["updated_at"]);
  	
  	// customize valid_until
  	$this->widgetSchema["valid_until"] = new sfWidgetFormDate();
  	$this->widgetSchema["valid_until"]->setOption("format","%month%<span>/</span>%day%<span>/</span>%year%");
  	$this->validatorSchema["valid_until"]->setMessage('required',"Please enter the expiration date");
  	$this->validatorSchema["valid_until"]->setOption('required',$this->getObject()->isNew() || !$this->getObject()->getIsPrimary());
  	
  	// customize status
  	$this->widgetSchema["status"] = new sfWidgetFormSelect(array('choices'=>TagPeer::$STATUS_NAMES));
  	$this->validatorSchema["status"] = new sfValidatorChoice(array('choices'=>array_keys(TagPeer::$STATUS_NAMES)));
  	$this->validatorSchema["status"]->setOption('required',true);
  	
  	// customize user_id
  	$this->widgetSchema["user_id"] = new sfWidgetFormSearchUser(array("src"=>"tag","plain"=>$this->getObject()->getIsPrimary()));
  	$this->validatorSchema["user_id"] = new sfValidatorSearchUser();
  	$this->validatorSchema["user_id"]->setMessage('invalid','Email address not found');
  	$this->validatorSchema["user_id"]->setMessage('required','Please enter an user email address');
  	if(!$this->getObject()->isNew()) $this->getObject()->setUserId($this->getObject()->getUser()->getPrimaryEmail());
  }
}
