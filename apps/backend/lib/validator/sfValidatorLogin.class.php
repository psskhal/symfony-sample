<?
class sfValidatorLogin extends sfValidatorSchema
{
	public function __construct($options = array(), $messages = array())
	{
		parent::__construct(null, $options, $messages);
	}
	
	protected function configure($options = array(), $messages = array())
	{
		$this->addRequiredOption('username');
		$this->addRequiredOption('password');
		$this->setMessage('invalid','Invalid username/password pair');
	}
	
	protected function doClean($values)
	{
		$username = isset($values[$this->getOption('username')])?$values[$this->getOption('username')]:null;
		$password = isset($values[$this->getOption('password')])?$values[$this->getOption('password')]:null;
		
		if(($username != OptionPeer::retrieveOption('ADMIN_USERNAME')) || (md5($password) != OptionPeer::retrieveOption('ADMIN_PASSWORD'))) 
			throw new sfValidatorError($this,'invalid');
		
		// login user
		sfContext::getInstance()->getUser()->signIn();
		return $values;
	}
}
?>