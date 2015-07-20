<?
class userOldPasswordValidator extends sfValidatorSchema
{
	public function __construct($options = array(), $messages = array())
	{
		parent::__construct(null, $options, $messages);
	}
	
	protected function configure($options = array(), $messages = array())
	{
		$this->addRequiredOption('password');
		$this->setMessage('invalid','Old password does not match');
	}
	
	protected function doClean($values)
	{
		$password = isset($values[$this->getOption('password')])?$values[$this->getOption('password')]:null;
		$user = sfContext::getInstance()->getUser()->getSubscriber();

		if($user && ($user->getPasswd() == md5($password))) return $values;
		
		$error = new sfValidatorError($this,'invalid',array(
						$this->getOption('password')=>$password
		));
			
		throw new sfValidatorErrorSchema($this,array($this->getOption('password')=>$error));
	}
}

class userLoginValidator extends sfValidatorSchema
{
	public function __construct($options = array(), $messages = array())
	{
		parent::__construct(null, $options, $messages);
	}
	
	protected function configure($options = array(), $messages = array())
	{
		$this->addRequiredOption('email');
		$this->addRequiredOption('password');
		$this->addRequiredOption('remember');
		$this->setMessage('invalid','Invalid email/password pair');
	}
	
	protected function doClean($values)
	{
		$email = isset($values[$this->getOption('email')])?$values[$this->getOption('email')]:null;
		$password = isset($values[$this->getOption('password')])?$values[$this->getOption('password')]:null;
		$remember = isset($values[$this->getOption('remember')])?$values[$this->getOption('remember')]:null;
		
		if($user = UserPeer::getAuthenticatedUser($email,$password))
		{
			sfContext::getInstance()->getUser()->signIn($user,($remember == 'Y'));
			return $values;
		}
		$error = new sfValidatorError($this,'invalid',array(
						$this->getOption('email')=>$email,
						$this->getOption('password')=>$password
		));
			
		throw new sfValidatorErrorSchema($this,array($this->getOption('email')=>$error));
	}
}

class userResetPwdValidator extends sfValidatorBase 
{
  protected function doClean($value)
  {
    // try both actual and email
    $user = UserPeer::getUserFromEmail($value);
    if($user) return $value;

    throw new sfValidatorError($this, 'invalid', array('value' => $value));
  }
}

class userInviteValidator extends sfValidatorBase
{
	protected function configure($options = array(), $messages = array())
	{
		$this->addOption('remove_invalid');
	}
	
	protected function doClean($value)
	{
		// this validator will return already parsed emails, in an array format
		// we store on cleanEmails array
		$cleanEmails = array();
		
		// split emails
		$emails = explode(",",$value);
		
		// check if all emails are really email address
		foreach($emails as $k=>$v)
		{
			// clear input
			$v = trim(preg_replace("/[\r\n]/","",$v));
			if(!$v) continue;
			
			if(preg_match("/^(.*?)<(.*?)>$/",$v,$matches))
			{
				$name = trim($matches[1]);
				$email = trim($matches[2]);
			}
			else
			{
				$name = "";
				$email = $v;
			}

			$validator = new sfValidatorEmail(array('trim'=>true));
			try
			{
				$validator->clean($email);
				
				// passed, push to array
				$cleanEmails[] = array("name"=>$name,"email"=>$email);
			}catch(sfValidatorError $e)
			{
				if(!$this->getOption('remove_invalid'))
				{
					$this->setMessage('invalid',sprintf($this->getMessage('invalid'),htmlentities($v,ENT_QUOTES,sfConfig::get('sf_charset'))));
					throw new sfValidatorError($this, 'invalid', array('value' => $value));
				}
			}
		}
		
		return $cleanEmails;
	}
}
?>
