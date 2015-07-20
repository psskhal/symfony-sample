<?php

/**
 * Template form.
 *
 * @package    form
 * @subpackage parcel_reviews
 * @version    SVN: $Id: sfPropelFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class TemplateForm extends sfForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'file'        => new sfWidgetFormInputHidden(),
      'm'           => new sfWidgetFormInputHidden(),
      'filename'    => new sfWidgetFormInput(),
      'contents'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'm'        	=> new sfValidatorPass(),	// we validate it on the action itself
      'file'       	=> new sfValidatorPass(),	// we validate it on the action itself
      'filename'	=> new sfValidatorRegex(array('trim'=>true,'required'=>'true','pattern'=>'/^[0-9a-zA-Z-_.]*\.php$/'),array('required'=>'Please enter the file name','invalid'=>'File name must only contain letters, numbers, . (period), - (dash), _ (underscore) and end with .php extension')),
      'contents' 	=> new sfValidatorString(array('required'=>false)),
    ));
    
    $this->widgetSchema->setHelps(array(
    	'filename'	=> 'Save file as...'
    ));

    $this->widgetSchema->setNameFormat('%s');
    $this->getWidgetSchema()->setFormFormatterName('div');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
