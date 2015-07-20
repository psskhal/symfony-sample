<?php

class LoginForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'username'        => new sfWidgetFormInput(),
      'password'        => new sfWidgetFormInputPassword(),
    ));

    $this->setValidators(array(
      'username'        => new sfValidatorString(array('required'=>false),array()),
      'password'        => new sfValidatorString(array('required'=>false),array()),
    ));
    
    $this->validatorSchema->setPostValidator(
    	new sfValidatorLogin(array('username'=>'username','password'=>'password'))
    );

	$this->widgetSchema->setLabels(array(
		'email'	    	=> 'Username',
		'password'	  	=> 'Password',
	));
	
	$this->widgetSchema->setNameFormat('login[%s]');
    $this->getWidgetSchema()->setFormFormatterName('table');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
