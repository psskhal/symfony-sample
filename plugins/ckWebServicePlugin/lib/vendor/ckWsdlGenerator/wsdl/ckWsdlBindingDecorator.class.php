<?php
/**
 * This file is part of the ckWebServicePlugin
 *
 * @package   ckWsdlGenerator
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id: ckWsdlBindingDecorator.class.php 10759 2008-08-09 22:57:27Z chrisk $
 */

/**
 * Enter description here...
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
abstract class ckWsdlBindingDecorator implements ckDOMSerializable
{
  const ELEMENT_NAME = 'binding';

  protected $name;
  protected $portType = null;

  public function getName()
  {
    return $this->name;
  }

  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Enter description here...
   *
   * @return ckWsdlPortType
   */
  public function getPortType()
  {
    return $this->portType;
  }

  /**
   * Enter description here...
   *
   * @param ckWsdlPortType $value
   */
  public function setPortType(ckWsdlPortType $value)
  {
    $this->portType = $value;
  }

  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

//  public abstract function serialize(DOMDocument $document);
}