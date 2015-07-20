<?php

/**
 * User form.
 *
 * @package    form
 * @subpackage parcel_users
 * @version    SVN: $Id: sfPropelFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class UserForm extends BaseUserForm
{
  public function configure()
  {
    // remove undesired fields
    unset($this["updated_at"],$this["created_at"],$this["bookmark_list"]);
    
    // customize passwd field
    $this->widgetSchema["passwd"] = new sfWidgetFormInputPassword();
    $this->validatorSchema["passwd"]->setOption('required',$this->getObject()->isNew());
    $this->validatorSchema["passwd"]->setOption('min_length',5);
    $this->validatorSchema["passwd"]->setOption('max_length',10);
   	$this->validatorSchema["passwd"]->setMessage('required','Your must enter the password');
  	$this->validatorSchema["passwd"]->setMessage('min_length','Password must have at least %min_length% chars');
	$this->validatorSchema["passwd"]->setMessage('max_length','Password must not have more than %max_length% chars');
	if(!$this->getObject()->isNew()) $this->widgetSchema->setHelp("passwd","Enter a password to change it, leave the field blank to keep the current one");
	$this->widgetSchema->setLabel("passwd","Password");
      	
    // add confirm passwd field
  	$this->widgetSchema["confirm_password"] = new sfWidgetFormInputPassword();
  	$this->validatorSchema["confirm_password"] = new sfValidatorString(array('required'=>false));

  	// password check
    $this->validatorSchema->setPostValidator(
        new sfValidatorSchemaCompare('confirm_password',sfValidatorSchemaCompare::EQUAL,'passwd',array(),array('invalid'=>'Password does not match'))
    );

    // embed profile
    $this->embedForm("profile",new ProfileForm($this->getObject()->getProfile()));
    
    // if creating, add email field
    if($this->getObject()->isNew())
    {
    	$this->widgetSchema["email"] = new sfWidgetFormInput();
    	$this->validatorSchema["email"] = new sfValidatorEmail();
    	$this->validatorSchema["email"]->setOption('required',true);
    	$this->validatorSchema["email"]->setOption('trim',true);
    	$this->validatorSchema["email"]->setMessage('required','Please enter the email address');
    	$this->validatorSchema["email"]->setMessage('invalid','Invalid email address');
    	
    	// check unique email
    	$this->validatorSchema->setPostValidator(
    	  new sfValidatorAnd(array(
    	  	$this->validatorSchema->getPostValidator(),
    	    new emailValidatorUnique(array('column'=>'email'),array('invalid'=>'This e-mail address is already registered')),
    	  ))
    	);
    }
  }
  
  public function save($con = null)
  {
  	if($this->getObject()->isNew()) $signup = true;
  	else $signup = false;
  	
	$object = parent::save();
	
	// update profile
	$values = $this->getValues();
	$profile = $object->getProfile();
	
	// save and remove photo from values
	$photo = $values["profile"]["photo"];
	unset($values["profile"]["photo"]);
	
	// update profile object
	$profile->fromArray($values["profile"],BasePeer::TYPE_FIELDNAME);
	$profile->setUser($object);
	
	// new photo??
	if($photo)
	{
  		  $fileName = $profile->getPhoto(false);
  		  if(!$fileName) $fileName = $profile->generateAvatarName().'.jpg';
		  $photo->save(sfConfig::get('sf_userimage_dir').DIRECTORY_SEPARATOR.$fileName);
		  $profile->setPhoto($fileName);
	}
	
	if($values["profile"]["remove_photo"])
	{
		$fileName = $profile->getPhoto(false);
		if($fileName)
		{
	  		$profile->setPhoto(null);
	  		$profile->save();
	  	
		  	// remove from filesystem
		  	unlink(sfConfig::get('sf_userimage_dir').DIRECTORY_SEPARATOR.$fileName);
		}
		else $profile->save();
	}
	else $profile->save();
	
	// if creating, setup email and permanent jotag
	if($signup)
	{
		// setup email
		$email = new Email();
		$email->setEmail($this->getValue('email'));
		$email->setIsConfirmed(true);
		$email->setIsPrimary(true);
		$email->setType(ContactPeer::TP_PERSONAL);
		$email->setUser($object);
		$email->save();
		
  		// generate JOTAG.
  		$tag = new Tag();
  		$tag->setJotag($object->generateRandomJOTAG());
  		$tag->setIsPrimary(true);
  		$tag->setStatus(TagPeer::ST_ACTIVE);
  		$tag->setUser($object);
  		
  		// link primary email to tag
  		$tm = new TagEmail();
  		$tm->setEmail($email);
  		$tag->addTagEmail($tm);
  		
  		// save new tag
  		$tag->save();
	}
	
	return $object;
  }
}