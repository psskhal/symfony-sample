<?
class buyJotagValidator extends sfValidatorSchema
{
	protected $already_exist;
	
	public function __construct($options = array(), $messages = array())
	{
		parent::__construct(null, $options, $messages);
	}
	
	protected function configure($options = array(), $messages = array())
	{
		$this->addRequiredOption('jotag');
		$this->addMessage('exist','We are sorry, the JoTAG you requested is not available');
	}
	
	protected function doClean($values)
	{
		$this->already_exists = null;
		
		$jotag = $values[$this->getOption('jotag')];
		$user = sfContext::getInstance()->getUser()->getSubscriber();

		$tag = TagPeer::getFromField(TagPeer::JOTAG,$jotag);
		if($tag && (!$user || ($tag->getUserId() != $user->getId())))
		{
			$this->already_exists = $tag;
			
			$error = new sfValidatorError($this,'exist',array(
							$this->getOption('jotag')=>$jotag
			));
				
			throw new sfValidatorErrorSchema($this,array($this->getOption('jotag')=>$error));
		}
		elseif($tag) $values["jotag_object"] = $tag; // renewing jotag
		else $values["jotag_object"] = null;
		
		return $values;
	}
	
	public function getAlreadyExists() { return $this->already_exists; }
}
?>