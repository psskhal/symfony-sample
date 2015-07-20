<?php
/**
 * This file is part of the ckWebServicePlugin
 *
 * @package   ckWsdlGenerator
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id: ckDOMSerializable.class.php 10759 2008-08-09 22:57:27Z chrisk $
 */

/**
 * Enter description here...
 *
 * @package    ckWsdlGenerator
 * @author     Christian Kerl <christian-kerl@web.de>
 */
interface ckDOMSerializable
{
  public function getNodeName();
  public function serialize(DOMDocument $document);
}