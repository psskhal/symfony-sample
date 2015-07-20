<?php
class sfWidgetFormSimpleCaptcha extends sfWidgetForm
{
  public function configure($options = array(), $messages = array())
  {
  	$this->addOption('template','%image% %inputbox%');
  	$this->addOption('inputbox_options',array());
  	$this->addOption('inputbox_attributes',array());
  }

  /**
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
  	sfLoader::loadHelpers(array('Url'));
  	
  	$inputboxWidget = new sfWidgetFormInput($this->getOption('inputbox_options'),$this->getOption('inputbox_attributes'));
    return strtr($this->getOption('template'), array(
      '%image%'		=> '<img src="'.url_for('@sfSimpleCaptcha').'" alt="Captcha" border="0" align="left" />',
      '%inputbox%'	=> $inputboxWidget->render($name),
    ));
  }
}