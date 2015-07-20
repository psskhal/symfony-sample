<?php
/**
 * This file is part of the ckWebServicePlugin
 *
 * @package   ckWsdlGenerator
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id: ckXsdType.class.php 10840 2008-08-13 12:50:01Z chrisk $
 */

/**
 * Enter description here...
 *
 * @package    ckWsdlGenerator
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
abstract class ckXsdType implements ckDOMSerializable
{
  protected static $typeRegistry = array();
  protected $typeElement = false;

  /**
   * Enter description here...
   *
   * @param string $key
   *
   * @return ckXsdType
   */
  public static function get($key)
  {
    if(isset(self::$typeRegistry[$key]))
    {
      return self::$typeRegistry[$key];
    }
    else if(ckXsdSimpleType::isSimpleType($key))
    {
      return self::set($key, ckXsdSimpleType::create($key));
    }
    else if(ckXsdArrayType::isArrayType($key))
    {
      return self::set($key, ckXsdArrayType::create($key));
    }
    else if(class_exists($key, true))
    {
      return self::set($key, ckXsdComplexType::create($key));
    }
    else
    {
      return null;
    }
  }

  /**
   * Enter description here...
   *
   * @return array
   */
  public static function getAll()
  {
    return self::$typeRegistry;
  }

  /**
   * Enter description here...
   *
   * @return array
   */
  public static function getComplexAndArrayTypes()
  {
    return array_filter(ckXsdType::getAll(), array(__CLASS__, 'isComplexOrArrayType'));
  }

  /**
   * Enter description here...
   *
   * @param string $key
   * @param ckXsdType $url
   *
   * @return ckXsdType
   */
  public static function set($key, $type)
  {
    self::$typeRegistry[$key] = $type;

    return $type;
  }

  private static function isComplexOrArrayType($input)
  {
    return $input instanceof ckXsdComplexType || $input instanceof ckXsdArrayType;
  }

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $name;

  /**
   * Enter description here...
   *
   * @var ckXsdNamespace
   */
  protected $namespace;

  /**
   * Enter description here...
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Enter description here...
   *
   * @param string $value
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Enter description here...
   *
   * @return ckXsdNamespace
   */
  public function getNamespace()
  {
    return $this->namespace;
  }

  /**
   * Enter description here...
   *
   * @param ckXsdNamespace $value
   */
  public function setNamespace(ckXsdNamespace $value)
  {
    $this->namespace = $value;
  }

  public function getNodeName()
  {
    return '';
  }

  protected function __construct($name = null, ckXsdNamespace $namespace = null)
  {
    $this->setName($name);
    $this->setNamespace($namespace);
  }

  /**
   * Enter description here...
   *
   * @return string
   */
  public function getQualifiedName()
  {
    return $this->getNamespace()->qualify($this->getName());
  }
  
  public function serializeElement($document)
  {
  	$xsd = ckXsdNamespace::get('xsd');
  	$tns = ckXsdNamespace::get('tns');
  	
  	$node = $document->createElementNS($xsd->getUrl(), $xsd->qualify("element"));
  	$node->setAttribute('name', $this->getName());
  	$node->setAttribute('type', $tns->qualify($this->getName()));
    
    return $node;
  }
  
  public function setIsElement($bool)
  {
  	$this->typeElement = $bool;
  }
  
  public function getIsElement()
  {
  	return $this->typeElement;
  }
}