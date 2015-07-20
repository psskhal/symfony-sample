<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Propel Admin generator.
 *
 * This class generates an admin module with propel.
 *
 * @package    symfony
 * @subpackage generator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfPropelAdminGenerator.class.php 3302 2007-01-18 13:42:46Z fabien $
 */

class sfAdvancedAdminGenerator extends sfPropelAdminGenerator
{
  /**
   * Initializes the current sfGenerator instance.
   *
   * @param sfGeneratorManager A sfGeneratorManager instance
   */
  public function initialize(sfGeneratorManager $generatorManager)
  {
    parent::initialize($generatorManager);

    $this->setGeneratorClass('sfAdvancedAdmin');
  }
  
  public function getColumnCreateTag($column, $params = array())
  {
    // user defined parameters
    $user_params = $this->getParameterValue('create.fields.'.$column->getName().'.params');
    $user_params = is_array($user_params) ? $user_params : sfToolkit::stringToArray($user_params);
    $params      = $user_params ? array_merge($params, $user_params) : $params;

    if ($column->isComponent())
    {
      return "get_component('".$this->getModuleName()."', '".$column->getName()."', array('type' => 'create', '{$this->getSingularName()}' => \${$this->getSingularName()}))";
    }
    else if ($column->isPartial())
    {
      return "get_partial('".$column->getName()."', array('type' => 'create', '{$this->getSingularName()}' => \${$this->getSingularName()}))";
    }

    if($this->getParameterValue('create.fields.'.$column->getName().'.type') == "plain") return "\${$this->getSingularName()}->get".sfInflector::camelize($column->getName())."()";
    else return '$form["'.$column->getName().'"]->render('.$this->getObjectTagParams($params).')';
  }
  
  public function getColumnEditTag($column, $params = array())
  {
    // user defined parameters
    $user_params = $this->getParameterValue('edit.fields.'.$column->getName().'.params');
    $user_params = is_array($user_params) ? $user_params : sfToolkit::stringToArray($user_params);
    $params      = $user_params ? array_merge($params, $user_params) : $params;

    if ($column->isComponent())
    {
      return "get_component('".$this->getModuleName()."', '".$column->getName()."', array('type' => 'edit', '{$this->getSingularName()}' => \${$this->getSingularName()}))";
    }
    else if ($column->isPartial())
    {
      return "get_partial('".$column->getName()."', array('type' => 'edit', '{$this->getSingularName()}' => \${$this->getSingularName()}))";
    }

    if($this->getParameterValue('edit.fields.'.$column->getName().'.type') == "plain") return "'<div class=\"sf_admin_plain_field\">'.\${$this->getSingularName()}->get".sfInflector::camelize($column->getName())."().'</div>'";
    else return '$form["'.$column->getName().'"]->render('.$this->getObjectTagParams($params).')';
  }
  
  /**
   * Generates a PHP call to an object helper.
   *
   * @param string The helper name
   * @param string The column name
   * @param array  An array of parameters
   * @param array  An array of local parameters
   *
   * @return string PHP code
   */
  function getPHPObjectHelper($helperName, $column, $params, $localParams = array())
  {
  	if (null !== ($map = $this->getParameterValue('maps.'.$column->getName()))) {
  		// Load map
  		$params['map'] = $map;
  		$helperName    = 'select_map_tag'; 
  	}
  	
  	return parent::getPHPObjectHelper($helperName, $column, $params, $localParams);
  }
  
  public function getColumnShowTag($column, $params = array())
  {
  	return $this->getColumnListTag($column, $params);
  }
  
  public function getColumnListTag($column, $params = array()) {
  	$return = parent::getColumnListTag($column, $params);
  	if (!$column->isComponent() && !$column->isPartial()) {
  		$return = '(null !== ($val = '.$return.') && isset($maps["'.$column->getName().'"][$val])?$maps["'.$column->getName().'"][$val]:$val)';
  	}
  	return $return;
  }
  
  public function getLinkToAction($actionName, $params, $pk_link = false) {
    $ret = parent::getLinkToAction($actionName, $params, $pk_link);
  	if ($actionName === '_show') {
  	  return preg_replace('/\/show_icon.png/', '/filter.png', $ret);
    }
    else {
      return $ret;
    }
  }
}
