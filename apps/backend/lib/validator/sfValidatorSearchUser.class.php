<?php
class sfValidatorSearchUser extends sfValidatorBase
{
	protected function configure($options = array(), $messages = array())
	{
	}
	
  protected function doClean($value)
  {
    $criteria = new Criteria();
    $criteria->add(EmailPeer::EMAIL,$value);
    $criteria->add(EmailPeer::IS_PRIMARY,true);

    $object = EmailPeer::doSelectOne($criteria);

    if (is_null($object))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }

    return $object->getUserId();
  }
}