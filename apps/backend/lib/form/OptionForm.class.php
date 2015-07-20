<?php
class OptionForm extends BaseOptionForm
{

  static $IGNORE_OPTIONS = array(
  	'ADMIN_PASSWORD_CONF',
  );

  /**
   * Configure Options Form
   */
  public function configure()
  {
    $this->setWidgets(array(
      'TIMEZONE'        		=> new sfWidgetFormSelect(array('choices'=>call_user_func(array('Timezone','getTimezones')))),
      'MAILFROM_NAME'			=> new sfWidgetFormInput(),
	  'MAILFROM_EMAIL'			=> new sfWidgetFormInput(),
      'ADMIN_EMAIL'				=> new sfWidgetFormInput(),
      'CURRENCY_FORMAT'			=> new sfWidgetFormInput(),
      'INVITE_AGE'				=> new sfWidgetFormInput(),
      'BONUS_MAX_CREDIT'		=> new sfWidgetFormInput(),
      'BONUS_INIT_CREDIT'		=> new sfWidgetFormInput(),
      'BONUS_INVITE_CREDIT'		=> new sfWidgetFormInput(),
      'BONUS_ACCEPT_CREDIT'		=> new sfWidgetFormInput(),
      'BONUS_DAYS_PER_CREDIT'	=> new sfWidgetFormInput(),
      'BUY_MAX_YEARS'			=> new sfWidgetFormInput(),
      'BUY_PRICE'				=> new sfWidgetFormInput(),
      'BUY_ORDER_OFFSET'		=> new sfWidgetFormInput(),
      'BUY_NEW_ORDER_LIFETIME'	=> new sfWidgetFormInput(),
      'BUY_EXPIRE_ALERTS'		=> new sfWidgetFormInput(),
      'BUY_DELETE_AFTER'		=> new sfWidgetFormInput(),
      'PAYPAL_ACCOUNT'			=> new sfWidgetFormInput(),
      'PAYPAL_MODE'				=> new sfWidgetFormSelect(array('choices'=>array('S'=>'Sandbox','L'=>'Live'))),
      'ADMIN_USERNAME'			=> new sfWidgetFormInput(),
      'ADMIN_PASSWORD'			=> new sfWidgetFormInputPassword(),
      'ADMIN_PASSWORD_CONF'		=> new sfWidgetFormInputPassword(),
      'ARTICLE_DISPLAY'			=> new sfWidgetFormInput(),
      'JOTAG_MIN_SIZE'			=> new sfWidgetFormInput(),
      'JOTAG_MAX_SIZE'			=> new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'TIMEZONE'				=> new sfValidatorChoice(array('choices'=>array_keys(call_user_func(array('Timezone','getTimezones')))),array('invalid'=>'Invalid timezone')),
      'MAILFROM_NAME'			=> new sfValidatorString(array('required'=>false)),
      'MAILFROM_EMAIL'			=> new sfValidatorEmail(array('required'=>true),array('required'=>'Please enter the email','invalid'=>'Invalid email')),
      'ADMIN_EMAIL'				=> new sfValidatorEmail(array('required'=>true),array('required'=>'Please enter administration email','invalid'=>'Invalid email')),
      'CURRENCY_FORMAT'			=> new sfValidatorString(array('required'=>true),array('required'=>'Please enter the currency format')),
      'INVITE_AGE'				=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the invite expiration age','invalid'=>'Invalid number')),
      'JOTAG_MIN_SIZE'			=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the minimum size of a JoTAG','invalid'=>'Invalid number')),
      'JOTAG_MAX_SIZE'			=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the maximum size of a JoTAG','invalid'=>'Invalid number')),
      'BONUS_MAX_CREDIT'		=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the maximum credits','invalid'=>'Invalid number')),
      'BONUS_INIT_CREDIT'		=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the initial credits','invalid'=>'Invalid number')),
      'BONUS_INVITE_CREDIT'		=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the invited credits','invalid'=>'Invalid number')),
      'BONUS_ACCEPT_CREDIT'		=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the acceptance credits','invalid'=>'Invalid number')),
      'BONUS_DAYS_PER_CREDIT'	=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the days per credit','invalid'=>'Invalid number')),
      'BUY_MAX_YEARS'			=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the max years','invalid'=>'Invalid number')),
      'BUY_PRICE'				=> new sfValidatorNumber(array('required'=>true),array('required'=>'Please enter the price','invalid'=>'Invalid number')),
      'BUY_ORDER_OFFSET'		=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the order number offset','invalid'=>'Invalid number')),
      'BUY_NEW_ORDER_LIFETIME'	=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the NEW order lifetime','invalid'=>'Invalid number')),
      'BUY_EXPIRE_ALERTS'		=> new sfValidatorString(array('required'=>true),array('required'=>'Please enter the expiration alerts')),
      'BUY_DELETE_AFTER'		=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the number of days','invalid'=>'Invalid number')),
      'PAYPAL_ACCOUNT'			=> new sfValidatorEmail(array('required'=>false),array('invalid'=>'Invalid account')),
      'PAYPAL_MODE'				=> new sfValidatorChoice(array('required'=>true,'choices'=>array('S','L'))),
      'ADMIN_USERNAME'			=> new sfValidatorRegex(array('required'=>true,'pattern'=>'/^[a-zA-Z0-9_]*$/'),array('required'=>'Please enter admin username','invalid'=>'Invalid username')),
      'ADMIN_PASSWORD'			=> new sfValidatorString(array('required'=>false,'min_length'=>5,'max_length'=>10),array('min_length'=>'Password must have at least %min_length% chars','max_length'=>'Password must not have more than %max_length% chars')),
      'ADMIN_PASSWORD_CONF'		=> new sfValidatorPass(),
      'ARTICLE_DISPLAY'			=> new sfValidatorInteger(array('required'=>true),array('required'=>'Please enter the number of articles to display','invalid'=>'Invalid number')),
    ));
    
	$this->widgetSchema->setLabels(array(
	  'TIMEZONE'	   			=> 'Timezone',
	  'MAILFROM_NAME'			=> 'Default From Email Name',
	  'MAILFROM_EMAIL'			=> 'Default From Email Address',
	  'ADMIN_EMAIL'				=> 'Administration Email Address',
	  'CURRENCY_FORMAT'			=> 'Currency Format',
	  'INVITE_AGE'				=> 'Expiration age',
      'BONUS_MAX_CREDIT'		=> 'Maximum Credits',
      'BONUS_INIT_CREDIT'		=> 'Initial Credits',
      'BONUS_INVITE_CREDIT'		=> 'Invited Credits',
      'BONUS_ACCEPT_CREDIT'		=> 'Acceptance Credits',
      'BONUS_DAYS_PER_CREDIT'	=> 'Days Per Credit',
      'BUY_MAX_YEARS'			=> 'Max Years',
      'BUY_PRICE'				=> 'Price',
      'BUY_ORDER_OFFSET'		=> 'Order number offset',
      'BUY_NEW_ORDER_LIFETIME'	=> 'New Order Lifetime',
      'BUY_EXPIRE_ALERTS'		=> 'Expiration Alerts',
      'BUY_DELETE_AFTER'		=> 'Delete JoTAG after',
      'PAYPAL_ACCOUNT'			=> 'Account',
      'PAYPAL_MODE'				=> 'Mode',
	  'ADMIN_USERNAME'			=> 'Username',
	  'ADMIN_PASSWORD'			=> 'Password',
	  'ADMIN_PASSWORD_CONF'		=> 'Confirm Password',
	  'ARTICLE_DISPLAY'			=> 'Number of Articles',
      'JOTAG_MIN_SIZE'			=> 'Minimum Size',
      'JOTAG_MAX_SIZE'			=> 'Maximum Size',
	));
	
	$this->widgetSchema->setHelps(array(
	  'ADMIN_EMAIL'				=> 'Email address where internal error emails will be sent to',
	  'CURRENCY_FORMAT'			=> 'sprintf format',
	  'INVITE_AGE'				=> 'How many days an invite is valid',
      'BONUS_MAX_CREDIT'		=> 'Maximum number of credits a user can earn',
      'BONUS_INIT_CREDIT'		=> 'Initial credits for a new account',
      'BONUS_INVITE_CREDIT'		=> 'Initial credits for an new account, created from an invite',
      'BONUS_ACCEPT_CREDIT'		=> 'Number of credits an user receives when an invite is accepted',
      'BONUS_DAYS_PER_CREDIT'	=> 'Number of DAYS each credit represents',
      'BUY_NEW_ORDER_LIFETIME'	=> 'Delete NEW (non-paid) orders after X SECONDS',
      'BUY_EXPIRE_ALERTS'		=> 'Expiration alert triggers, ex: 10, 5, 0, -5, -10',
      'BUY_DELETE_AFTER'		=> 'Delete a JoTAG from user account if expired for more than X days',
	  'ADMIN_USERNAME'			=> 'Letters, numbers and _ only',
	  'ADMIN_PASSWORD'			=> 'Leave blank to keep current password',
	  'ADMIN_PASSWORD_CONF'		=> 'Confirm Password',
	  'ARTICLE_DISPLAY'			=> 'Number of articles to display in homepage',
	));
	
	$this->widgetSchema->setNameFormat('option[%s]');
    $this->getWidgetSchema()->setFormFormatterName('div');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  	// post validator
    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorSchemaCompare('ADMIN_PASSWORD_CONF',sfValidatorSchemaCompare::EQUAL,'ADMIN_PASSWORD',array(),array('invalid'=>'Password does not match')),
      ))
    );
    
    // set default values
    foreach($this->getWidgetSchema()->getFields() as $name=>$obj)
    	$this->setDefault($name,OptionPeer::retrieveOption($name));
  }
  
  /**
   * Save Options Form
   */
  public function save($con = null)
  {
	foreach($this->getValues() as $option=>$value)
	{
		if(in_array($option,self::$IGNORE_OPTIONS)) continue;
		
		OptionPeer::updateOption($option,$value);
	}
  }
}