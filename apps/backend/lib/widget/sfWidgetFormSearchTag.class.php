<?php
class sfWidgetFormSearchTag extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
  	$this->addOption("plain",false);
  	$this->addRequiredOption("src");
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
  	sfLoader::loadHelpers('Javascript');
  	
  	if($this->getOption("plain")) return $value.input_hidden_tag($name,$value);
  	else return input_auto_complete_tag($name, $value, 'tag/searchTag?src='.$this->getOption('src'), array('autocomplete' => 'off', 'size' => '15'), array('use_style' => 'true'));
  }
}
