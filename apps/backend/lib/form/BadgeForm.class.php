<?php

/**
 * Badge form.
 *
 * @package    form
 * @subpackage jotag_badges
 * @version    SVN: $Id: sfPropelFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class BadgeForm extends BaseBadgeForm
{
  public function configure()
  {
    // remove undesired fields
    unset($this["created_at"],$this["updated_at"],$this["is_default"]);
    
    // customize is active
    $this->widgetSchema["is_active"] = new sfWidgetFormSelect(array('choices'=>array('0'=>'Disabled','1'=>'Enabled')));
    if($this->getObject()->getIsDefault()) $this->widgetSchema["is_active"]->setAttribute("disabled",true);
    $this->validatorSchema["is_active"] = new sfValidatorChoice(array('choices'=>array('1','0'),'required'=>true));

    // customize template
    $this->widgetSchema["template"] = new sfWidgetFormSelect(array('choices'=>BadgePeer::retrieveTemplates()));
    $this->validatorSchema["template"] = new sfValidatorChoice(array('choices'=>array_keys(BadgePeer::retrieveTemplates())));
    
    // customize name
    $this->validatorSchema["name"]->setOption("trim",true);
    $this->validatorSchema["name"]->setMessage("required","Please enter the badge name");
    
   	// customize thumbnail
   	$this->widgetSchema["thumbnail"] = new sfWidgetFormInputFile();
	$this->validatorSchema["thumbnail"] = new sfValidatorFile(array('required'=>false,'max_size'=> 1024*1024,'mime_types'=>array('image/jpeg','image/pjpeg')),array('required' => 'Please upload a file','invalid'  => 'Only JPEG images are allowed'));
	$this->widgetSchema->setLabel('thumbnail','Upload thumbnail (JPEG max 1M)');
	
	// remove thumbnail
	$this->widgetSchema["remove_thumbnail"] = new sfWidgetFormInputCheckbox();
	$this->validatorSchema["remove_thumbnail"] = new sfValidatorBoolean();
  }
  
  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
  	if($this->getObject()->getIsDefault()) $taintedValues["is_active"] = "1";
  	
  	return parent::bind($taintedValues,$taintedFiles);
  }
  
  public function save($con = null)
  {
  	$values = $this->getValues();
  	
  	// save and remove thumbnail
  	$thumbnail = $values["thumbnail"];
  	unset($values["thumbnail"]);

  	// update object
  	$this->getObject()->fromArray($values,BasePeer::TYPE_FIELDNAME);
  	
	// new photo??
	if($thumbnail)
	{
  		  $fileName = $this->getObject()->getThumbnail();
  		  if(!$fileName) $fileName = md5($this->getObject()->getName().$this->getObject()->getTemplate().rand(0,999999)).".jpg";
		  $thumbnail->save(sfConfig::get('sf_badgeimage_dir').DIRECTORY_SEPARATOR.$fileName);
		  $this->getObject()->setThumbnail($fileName);
	}
	
	// save
	$this->getObject()->save();
	
	return $this->getObject();
  }
}
