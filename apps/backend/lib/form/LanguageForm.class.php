<?php

/**
 * Language form.
 *
 * @package    form
 * @subpackage parcel_languages
 * @version    SVN: $Id: sfPropelFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class LanguageForm extends BaseLanguageForm
{
  public function configure()
  {
    // remove undesired fields
    unset($this["created_at"],$this["updated_at"],$this["is_default"]);
    
    // customize is active
    $this->widgetSchema["is_active"] = new sfWidgetFormSelect(array('choices'=>array('0'=>'Disabled','1'=>'Enabled')));
    if($this->getObject()->getIsDefault()) $this->widgetSchema["is_active"]->setAttribute("disabled",true);
    $this->validatorSchema["is_active"] = new sfValidatorChoice(array('choices'=>array('1','0'),'required'=>true));
    
    // customize culture field
    if($this->getObject()->isNew())
    {
    	$this->widgetSchema["culture"] = new sfWidgetFormI18nSelectCulture();
    	$this->validatorSchema["culture"] = new sfValidatorI18nChoiceCulture();
    }
    else 
    {
    	unset($this["culture"]);
    	
    	// remove post validator
		$this->validatorSchema->setPostValidator(new sfValidatorPass());
    }
    
    // customize name
    $this->validatorSchema["name"]->setOption("trim",true);
    $this->validatorSchema["name"]->setMessage("required","Please enter the display name");
  }
  
  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
  	if($this->getObject()->getIsDefault()) $taintedValues["is_active"] = "1";
  	
  	return parent::bind($taintedValues,$taintedFiles);
  }
}
