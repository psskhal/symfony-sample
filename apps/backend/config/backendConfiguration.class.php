<?php

class backendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
 	// upload dir
	sfConfig::add(array(
	  'sf_image_dir_name'           => $sf_image_dir_name = 'images',
	  'sf_userimage_dir_name'       => $sf_userimage_dir_name = 'userimages',
	  'sf_userimage_dir'            => sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$sf_image_dir_name.DIRECTORY_SEPARATOR.$sf_userimage_dir_name,
	  'sf_default_photo'			=> 'avatar.gif',
	  'sf_badgeimage_dir_name'		=> $sf_badgeimage_dir_name = "badgeimages",
	  'sf_badgeimage_dir'			=> sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$sf_image_dir_name.DIRECTORY_SEPARATOR.$sf_badgeimage_dir_name,
	));
  	
  	// set default formatter to DIV
  	sfWidgetFormSchemaDecorator::setDefaultFormFormatterName('div');
  }
}
