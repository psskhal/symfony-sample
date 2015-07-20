<?php
class sfValidatorSearchTag extends sfValidatorBase
{
	protected function configure($options = array(), $messages = array())
	{
	}
	
  protected function doClean($value)
  {
    $criteria = new Criteria();
    $criteria->add(TagPeer::JOTAG,$value);

    $object = TagPeer::doSelectOne($criteria);

    if (is_null($object))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }

    return $object->getId();
  }
}