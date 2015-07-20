[?php

/**
 * <?php echo $this->getGeneratedModuleName() ?> actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getGeneratedModuleName() ?>

 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 8313 2008-05-03 11:57:00Z h0nIg $
 */
class <?php echo $this->getGeneratedModuleName() ?>Actions extends sfActions
{
  public function preExecute()
  {
    $this->maps = $this->getMaps();
  }
  
  public function executeToggleActive($request)
  {
	$<?php echo $this->getSingularName() ?> = $this->get<?php echo $this->getClassName() ?>OrCreate();
	if($<?php echo $this->getSingularName() ?>)
  	{
  		$<?php echo $this->getSingularName() ?>->setIsActive(!$<?php echo $this->getSingularName() ?>->getIsActive());
  		$<?php echo $this->getSingularName() ?>->save();
  	}
  	$this->redirect('<?php echo $this->getModuleName() ?>/list');
  }
  
  public function executeUp($request)
  {
    $<?php echo $this->getSingularName() ?> = $this->get<?php echo $this->getClassName() ?>OrCreate();
    if($<?php echo $this->getSingularName() ?>) $<?php echo $this->getSingularName() ?>->moveUp();
    
    $this->redirect('<?php echo $this->getModuleName() ?>/list');
  }
  
  public function executeDown($request)
  {
    $<?php echo $this->getSingularName() ?> = $this->get<?php echo $this->getClassName() ?>OrCreate();
    if($<?php echo $this->getSingularName() ?>) $<?php echo $this->getSingularName() ?>->moveDown();
    
    $this->redirect('<?php echo $this->getModuleName() ?>/list');
  }

  public function executeTop($request)
  {
    $<?php echo $this->getSingularName() ?> = $this->get<?php echo $this->getClassName() ?>OrCreate();
    if($<?php echo $this->getSingularName() ?>) $<?php echo $this->getSingularName() ?>->moveToTop();
    
    $this->redirect('<?php echo $this->getModuleName() ?>/list');
  }
  
  public function executeBottom($request)
  {
    $<?php echo $this->getSingularName() ?> = $this->get<?php echo $this->getClassName() ?>OrCreate();
    if($<?php echo $this->getSingularName() ?>) $<?php echo $this->getSingularName() ?>->moveToBottom();
    
    $this->redirect('<?php echo $this->getModuleName() ?>/list');
  }
  
  public function executeAutocomplete() {
    $table  = sfInflector::camelize($this->getRequestParameter('table'));
    $field  = sfInflector::camelize($this->getRequestParameter('field'));
    $search = $this->getRequestParameter("${table}_${field}_search");
    $return = '';
    $c = new Criteria();
    $c->add(constant($table.'Peer::'.strtoupper($field)), '%'.$search.'%', Criteria::LIKE);
    foreach (call_user_func(array($table.'Peer', 'doSelect'), $c) as $item) {
      $return .= '<li id="'.$item->getId().'">'.call_user_func(array($item, 'get'.$this->getRequestParameter('field'))).'</li>';
    }
    return $this->renderText('<ul>'.$return.'</ul>');
  }
  
  public function executeIndex()
  {
    return $this->forward('<?php echo $this->getModuleName() ?>', 'list');
  }

  public function executeList()
  {
    $this->processSort();

    $this->processFilters();

<?php if ($this->getParameterValue('list.filters')): ?>
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getSingularName() ?>/filters');
<?php endif ?>

    // pager
    $this->pager = new sfPropelPager('<?php echo $this->getClassName() ?>', <?php echo $this->getParameterValue('list.max_per_page', 20) ?>);
    $c = new Criteria();
    $this->addSortCriteria($c);
<?php if ($fields = $this->getParameterValue('list.fields')): ?>
<?php foreach ($fields as $key => $field): ?>
<?php if ($join_fields= $this->getParameterValue('list.fields.'.$key.'.join_fields')): ?>
    $c->addJoin(<?=$join_fields[0]?>,<?=$join_fields[1]?>);
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
    $this->addFiltersCriteria($c);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
<?php if ($this->getParameterValue('list.peer_method')): ?>
    $this->pager->setPeerMethod('<?php echo $this->getParameterValue('list.peer_method') ?>');
<?php endif ?>
<?php if ($this->getParameterValue('list.peer_count_method')): ?>
    $this->pager->setPeerCountMethod('<?php echo $this->getParameterValue('list.peer_count_method') ?>');
<?php endif ?>
    $this->pager->init();
  }

  public function executeShow()
  {
    $this-><?php echo $this->getSingularName() ?> = $this->get<?php echo $this->getClassName() ?>OrCreate();
    if ($this-><?php echo $this->getSingularName() ?>->isNew()) {
    	return $this->forward('<?php echo $this->getModuleName() ?>', 'create');
    }
    $this->labels = $this->getLabels();
  }

  public function executeCreate()
  {
<?php if (null === $this->getParameterValue('create')): ?>
    return $this->forward('<?php echo $this->getModuleName() ?>', 'edit');
<?php else: ?>    
    $this-><?php echo $this->getSingularName() ?> = new <?php echo $this->getClassName() ?>();
    
	$this->processFilters();

<?php if ($this->getParameterValue('list.filters')): ?>
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getSingularName() ?>/filters');
<?php endif ?>
    
    $this->form = new <?php echo $this->getClassName() ?>Form($this-><?php echo $this->getSingularName() ?>);
    $this->labels = $this->getLabels();

    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      return $this->handlePost('create');
    }
<?php endif; ?>
  }

  public function executeSave()
  {
    return $this->forward('<?php echo $this->getModuleName() ?>', 'edit');
  }

<?php $listActions = $this->getParameterValue('list.batch_actions') ?>
<?php if (null !== $listActions): ?>
  public function executeBatchAction()
  {
    $action = $this->getRequestParameter('sf_admin_batch_action');
    switch($action)
    {
<?php foreach ((array) $listActions as $actionName => $params): ?>
<?php
// default values
if ($actionName[0] == '_')
{
  $actionName = substr($actionName, 1);
  $name       = $actionName;
  $action     = $actionName;
}
else
{
  $name   = $actionName;
  $action = isset($params['action']) ? $params['action'] : sfInflector::camelize($actionName);
}
?>
      case "<?php echo $name ?>":
        $this->forward('<?php echo $this->getModuleName() ?>', '<?php echo $action ?>');
        break;
<?php endforeach; ?>
    }

    return $this->redirect('<?php echo $this->getModuleName() ?>/list');
  }
<?php endif; ?>

  public function executeDeleteSelected()
  {
    $this->selectedItems = $this->getRequestParameter('sf_admin_batch_selection', array());

    try
    {
      <?php echo $this->getClassName() ?>Peer::doDelete($this->selectedItems);
    }
    catch (PropelException $e)
    {
      $this->getRequest()->setError('delete', 'Could not delete the selected <?php echo sfInflector::humanize($this->getPluralName()) ?>. Make sure they do not have any associated items.');
      return $this->forward('<?php echo $this->getModuleName() ?>', 'list');
    }

    return $this->redirect('<?php echo $this->getModuleName() ?>/list');
  }

  public function executeEdit()
  {
    $this->processFilters();

<?php if ($this->getParameterValue('list.filters')): ?>
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getSingularName() ?>/filters');
<?php endif ?>

    $this-><?php echo $this->getSingularName() ?> = $this->get<?php echo $this->getClassName() ?>OrCreate();

    $this->form = new <?php echo $this->getClassName() ?>Form($this-><?php echo $this->getSingularName() ?>);
    $this->labels = $this->getLabels();

    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      return $this->handlePost('edit');
    }
  }

  public function executeDelete()
  {
    $this-><?php echo $this->getSingularName() ?> = <?php echo $this->getClassName() ?>Peer::retrieveByPk(<?php echo $this->getRetrieveByPkParamsForAction(40) ?>);
    $this->forward404Unless($this-><?php echo $this->getSingularName() ?>);

    try
    {
      $this->delete<?php echo $this->getClassName() ?>($this-><?php echo $this->getSingularName() ?>);
    }
    catch (PropelException $e)
    {
      $this->getRequest()->setError('delete', 'Could not delete the selected <?php echo sfInflector::humanize($this->getSingularName()) ?>. Make sure it does not have any associated items.');
      return $this->forward('<?php echo $this->getModuleName() ?>', 'list');
    }
    
    switch ($this->getActionName()) {
<?php foreach (array('create', 'edit') as $action): ?>
      case '<?php echo $action; ?>':
<?php foreach ($this->getColumnCategories($action.'.display') as $category): ?>
<?php foreach ($this->getColumns($action.'.display', $category) as $name => $column): ?>
<?php $input_type = $this->getParameterValue($action.'.fields.'.$column->getName().'.type') ?>
<?php if ($input_type == 'admin_input_file_tag'): ?>
<?php $upload_dir = $this->replaceConstants($this->getParameterValue($action.'.fields.'.$column->getName().'.upload_dir')) ?>
        $currentFile = sfConfig::get('sf_upload_dir')."/<?php echo $upload_dir ?>/".$this-><?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>();
        if (is_file($currentFile))
        {
          unlink($currentFile);
        }

<?php endif; ?>
<?php endforeach; ?>
<?php endforeach; ?>
        break;
<?php endforeach; ?>
    }

    return $this->redirect('<?php echo $this->getModuleName() ?>/list');
  }

  public function handlePost($type)
  {
    $this->update<?php echo $this->getClassName() ?>FromRequest();
	if($this->form->isValid())
	{
		$this->form->save();
	    $this->getUser()->setFlash('notice', 'Your modifications have been saved');
	
	    if ($this->getRequestParameter('save_and_add'))
	    {
	      return $this->redirect('<?php echo $this->getModuleName() ?>/create');
	    }
	    else if ($this->getRequestParameter('save_and_list'))
	    {
	      return $this->redirect('<?php echo $this->getModuleName() ?>/');
	    }
	    else
	    {
	      return $this->redirect('<?php echo $this->getModuleName() ?>/edit?<?php echo $this->getPrimaryKeyUrlParams('this->') ?>);
	    }
	}
  }
  
  protected function delete<?php echo $this->getClassName() ?>($<?php echo $this->getSingularName() ?>)
  {
    $<?php echo $this->getSingularName() ?>->delete();
  }

  protected function update<?php echo $this->getClassName() ?>FromRequest()
  {
	$this->form->bind($this->getRequestParameter('<?php echo $this->getSingularName() ?>'),$this->getRequest()->getFiles('<?php echo $this->getSingularName() ?>'));
  }

  protected function get<?php echo $this->getClassName() ?>OrCreate(<?php echo $this->getMethodParamsForGetOrCreate() ?>)
  {
    if (<?php echo $this->getTestPksForGetOrCreate() ?>)
    {
      $<?php echo $this->getSingularName() ?> = new <?php echo $this->getClassName() ?>();
    }
    else
    {
      $<?php echo $this->getSingularName() ?> = <?php echo $this->getClassName() ?>Peer::retrieveByPk(<?php echo $this->getRetrieveByPkParamsForGetOrCreate() ?>);

      $this->forward404Unless($<?php echo $this->getSingularName() ?>);
    }

    return $<?php echo $this->getSingularName() ?>;
  }

  protected function processFilters()
  {
<?php if ($this->getParameterValue('list.filters')): ?>
    if ($this->getRequest()->hasParameter('filter'))
    {
      $filters = $this->getRequestParameter('filters');
<?php foreach ($this->getColumns('list.filters') as $column): $type = $column->getCreoleType() ?>
<?php if ($type == CreoleTypes::DATE || $type == CreoleTypes::TIMESTAMP): ?>
      if (isset($filters['<?php echo $column->getName() ?>']['from']) && $filters['<?php echo $column->getName() ?>']['from'] !== '')
      {
        $filters['<?php echo $column->getName() ?>']['from'] = $this->getContext()->getI18N()->getTimestampForCulture($filters['<?php echo $column->getName() ?>']['from'], $this->getUser()->getCulture());
      }
      if (isset($filters['<?php echo $column->getName() ?>']['to']) && $filters['<?php echo $column->getName() ?>']['to'] !== '')
      {
        $filters['<?php echo $column->getName() ?>']['to'] = $this->getContext()->getI18N()->getTimestampForCulture($filters['<?php echo $column->getName() ?>']['to'], $this->getUser()->getCulture());
      }
<?php endif; ?>
<?php endforeach; ?>

      // reset Multi-sort
      if (!is_array($filters)) 
      {
        $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/<?php echo $this->getSingularName() ?>/sort');

        if (!$this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getSingularName() ?>/sort'))
        {
<?php $multisort = $this->getParameterValue('list.multisort'); ?>
<?php if ($sort = $this->getParameterValue('list.sort')): ?>
<?php if (is_array($sort)): ?>
<?php if (!$multisort) :?>
          $this->getUser()->setAttribute('<?php echo $sort[0] ?>', '<?php echo $sort[1] ?>', 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
<?php else: ?>
<?php foreach ($sort as $s) : ?>
<?php if (is_array($s)): ?>
          $this->getUser()->setAttribute('<?php echo $s[0] ?>', '<?php echo $s[1] ?>', 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
<?php else: ?>
          $this->getUser()->setAttribute('<?php echo $s ?>', 'asc', 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php else: ?>
          $this->getUser()->setAttribute('<?php echo $sort ?>', 'asc', 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
<?php endif; ?>
<?php endif; ?>
        }

      }

      $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/<?php echo $this->getSingularName() ?>/filters');
      $this->getUser()->getAttributeHolder()->add($filters, 'sf_admin/<?php echo $this->getSingularName() ?>/filters');
    }
<?php endif; ?>
  }

  protected function processSort()
  {
<?php $multisort = $this->getParameterValue('list.multisort'); ?>
    $sort = $this->getRequestParameter('sort');
    $type = $this->getRequestParameter('type');
    
    if ($sort)
    {
<?php if (!$multisort) :?>
      $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/<?php echo $this->getSingularName() ?>/sort');
<?php endif; ?>      

      $this->getUser()->setAttribute($sort, $type, 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
    }

    if (!$this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getSingularName() ?>/sort'))
    {
<?php if ($sort = $this->getParameterValue('list.sort')): ?>

<?php if (is_array($sort)): ?>

<?php if (!$multisort) :?>
      $this->getUser()->setAttribute('<?php echo $sort[0] ?>', '<?php echo $sort[1] ?>', 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
<?php else: ?>
<?php foreach ($sort as $s) : ?>
<?php if (is_array($s)): ?>
      $this->getUser()->setAttribute('<?php echo $s[0] ?>', '<?php echo $s[1] ?>', 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
<?php else: ?>
      $this->getUser()->setAttribute('<?php echo $s ?>', 'asc', 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>

<?php else: ?>
      $this->getUser()->setAttribute('<?php echo $sort ?>', 'asc', 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
<?php endif; ?>

<?php endif; ?>
    }
  }

  protected function addFiltersCriteria($c)
  {
<?php if ($this->getParameterValue('list.filters')): ?>
<?php foreach ($this->getColumns('list.filters') as $column): $type = $column->getCreoleType() ?>
<?php if (($column->isPartial() || $column->isComponent()) && $this->getParameterValue('list.fields.'.$column->getName().'.filter_criteria_disabled')) continue ?>
    if (isset($this->filters['<?php echo $column->getName() ?>_is_empty']))
    {
      $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, '');
      $criterion->addOr($c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, null, Criteria::ISNULL));
      $c->add($criterion);
    }
<?php if ($type == CreoleTypes::DATE || $type == CreoleTypes::TIMESTAMP): ?>
    else if (isset($this->filters['<?php echo $column->getName() ?>']))
    {
      if (isset($this->filters['<?php echo $column->getName() ?>']['from']) && $this->filters['<?php echo $column->getName() ?>']['from'] !== '')
      {
<?php if ($type == CreoleTypes::DATE): ?>
        $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, date('Y-m-d', $this->filters['<?php echo $column->getName() ?>']['from']), Criteria::GREATER_EQUAL);
<?php else: ?>
        $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $column->getName() ?>']['from'], Criteria::GREATER_EQUAL);
<?php endif; ?>
      }
      if (isset($this->filters['<?php echo $column->getName() ?>']['to']) && $this->filters['<?php echo $column->getName() ?>']['to'] !== '')
      {
        if (isset($criterion))
        {
<?php if ($type == CreoleTypes::DATE): ?>
          $criterion->addAnd($c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, date('Y-m-d', $this->filters['<?php echo $column->getName() ?>']['to']), Criteria::LESS_EQUAL));
<?php else: ?>
          $criterion->addAnd($c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $column->getName() ?>']['to'], Criteria::LESS_EQUAL));
<?php endif; ?>
        }
        else
        {
<?php if ($type == CreoleTypes::DATE): ?>
          $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, date('Y-m-d', $this->filters['<?php echo $column->getName() ?>']['to']), Criteria::LESS_EQUAL);
<?php else: ?>
          $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $column->getName() ?>']['to'], Criteria::LESS_EQUAL);
<?php endif; ?>
        }
      }

      if (isset($criterion))
      {
        $c->add($criterion);
      }
    }
<?php else: ?>
    else if (isset($this->filters['<?php echo $column->getName() ?>']) && $this->filters['<?php echo $column->getName() ?>'] !== '')
    {
<?php if ($type == CreoleTypes::CHAR || $type == CreoleTypes::VARCHAR || $type == CreoleTypes::LONGVARCHAR): ?>
      $c->add(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, '%'.$this->filters['<?php echo $column->getName() ?>'].'%', Criteria::LIKE);
<?php else: ?>
      $c->add(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $column->getName() ?>']);
<?php endif; ?>
    }
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
  }

  protected function addSortCriteria($c)
  {
    $sort_array = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getSingularName() ?>/sort');

    if ($sort_array) 
    {
      $sort_columns = Array();
      foreach($sort_array as $sort_column => $sort_type) 
      {
        switch ($sort_column) 
        {
<?php if ($fields = $this->getParameterValue('list.fields')): ?>
<?php foreach ($fields as $key => $field): ?>
<?php if ($this->getParameterValue('list.fields.'.$key.'.sort_column')): ?>
          case '<?=$key?>':
<?php $column = $this->getParameterValue('list.fields.'.$key.'.sort_column');
      if ( is_array($column) ) : ?> 
<?php foreach ($column as $c) : ?>
            $sort_columns[<?= $c ?>] = $sort_type;
<?php endforeach; ?>
<?php else: ?> 
            $sort_columns[<?= $column ?>] = $sort_type;
<?php endif; ?>
            break;
            
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
          default:
			$sort_column = strtolower($sort_column);
			$sort_column_php = sfInflector::camelize($sort_column);
            $sort_columns[<?php echo $this->getClassName() ?>Peer::translateFieldName($sort_column_php, BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME)] = $sort_type;
            break;
        }
        
        if ($sort_type=='none') 
        {
          $this->getUser()->getAttributeHolder()->remove($sort_column, null, 'sf_admin/<?php echo $this->getSingularName() ?>/sort');
        }
      }

      foreach($sort_columns as $sort_column => $sort_type) 
      {
        switch ($sort_type)
        {
          case 'asc':
            $c->addAscendingOrderByColumn($sort_column);
            break;
          case 'desc': 
            $c->addDescendingOrderByColumn($sort_column);
            break;
        }
      }
    }
  }


  protected function getLabels()
  {
    switch ($this->getActionName()) {
<?php foreach (array('create', 'edit', 'show') as $action): ?>
      case '<?php echo $action; ?>':
        return array(
<?php foreach ($this->getColumnCategories($action.'.display') as $category): ?>
<?php foreach ($this->getColumns($action.'.display', $category) as $name => $column): ?>
          '<?php echo $this->getSingularName() ?>{<?php echo $column->getName() ?>}' => '<?php $label_name = str_replace("'", "\\'", $this->getParameterValue($action.'.fields.'.$column->getName().'.name')); echo $label_name ?><?php if ($label_name): ?>:<?php endif ?>',
<?php endforeach; ?>
<?php endforeach; ?>
        );
        break;
<?php endforeach; ?>
    }
  }

  protected function getMaps()
  {
    return <?php var_export($this->getParameterValue('maps'))?>;
  }
}

