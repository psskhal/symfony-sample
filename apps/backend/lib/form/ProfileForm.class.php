<?php

/**
 * User form.
 *
 * @package    form
 * @subpackage parcel_users
 * @version    SVN: $Id: sfPropelFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ProfileForm extends BaseProfileForm
{
  public function configure()
  {
    // remove undesired fields
    unset($this["updated_at"]);
    
    // customize fist name
    $this->validatorSchema["first_name"]->setOption('trim',true);
    $this->validatorSchema["first_name"]->setMessage('required','Please enter the First Name');
    
    // customize last name
    $this->validatorSchema["last_name"]->setOption('trim',true);
    $this->validatorSchema["last_name"]->setMessage('required','Please enter the First Name');
    
   	// customize photo
   	if(!$this->getObject()->isNew())
   	{
	   	$this->widgetSchema["photo"] = new sfWidgetFormInputFile();
		$this->validatorSchema["photo"] = new sfValidatorFile(array('required'=>false,'max_size'=> 1024*1024,'mime_types'=>array('image/jpeg','image/pjpeg')),array('required' => 'Please upload a file','invalid'  => 'Only JPEG images are allowed'));
		$this->widgetSchema->setLabel('avatar','Upload photo (JPEG max 1M)');
		
		// remove photo
		$this->widgetSchema["remove_photo"] = new sfWidgetFormInputCheckbox();
		$this->validatorSchema["remove_photo"] = new sfValidatorBoolean();
   	}
   	else unset($this["photo"]);
   	
   	// customize culture
   	$this->widgetSchema->setLabel("language_id","Prefered Language");
  }
}