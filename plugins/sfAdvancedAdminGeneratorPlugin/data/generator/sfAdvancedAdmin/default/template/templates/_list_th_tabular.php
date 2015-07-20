[?php $sort_array = $sf_user->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getSingularName() ?>/sort'); ?]
<?php $multisort = $this->getParameterValue('list.multisort'); ?>
<?php $hides = $this->getParameterValue('list.hide', array()) ?>
<?php foreach ($this->getColumns('list.display') as $column): ?>
<?php if (in_array($column->getName(), $hides)) continue ?>
<?php $credentials = $this->getParameterValue('list.fields.'.$column->getName().'.credentials') ?>
<?php if ($credentials): $credentials = str_replace("\n", ' ', var_export($credentials, true)) ?>
    [?php if ($sf_user->hasCredential(<?php echo $credentials ?>)): ?]
<?php endif; ?>
  <th class="sf_admin_list_th_<?php echo $column->getName()?>">
<?php $sort_column = $this->getParameterValue('list.fields.'.$column->getName().'.sort_column'); ?>
<?php $skip_sort = $this->getParameterValue('list.fields.'.$column->getName().'.skip_sort'); ?>
<?php if ( ($column->isReal() && !$skip_sort) || ($sort_column) ): ?>
    [?php if (isset($sort_array['<?php echo $column->getName() ?>'])) : ?]
      [?php $order = ($sort_array['<?php echo $column->getName() ?>']); ?]
      [?php echo link_to(__('<?php echo str_replace("'", "\\'", $this->getParameterValue('list.fields.'.$column->getName().'.name')) ?>'), '<?php echo $this->getModuleName() ?>/list?sort=<?php echo $column->getName() ?>&type='.($order == 'asc' ? 'desc' : 'asc')) ?]
      ([?php echo $order ?])
<?php if ($multisort) : ?>
      [?php echo link_to(image_tag('/sf/sf_admin/images/cancel.png', array('alt' => __('cancel'), 'title' => __('cancel'))), '<?php echo $this->getModuleName() ?>/list?sort=<?php echo $column->getName() ?>&type=none') ?]
<?php endif; ?>
    [?php else: ?]
      [?php echo link_to(__('<?php echo str_replace("'", "\\'", $this->getParameterValue('list.fields.'.$column->getName().'.name')) ?>'), '<?php echo $this->getModuleName() ?>/list?sort=<?php echo $column->getName() ?>&type=asc') ?]
    [?php endif; ?]
<?php else: ?>
    [?php echo __('<?php echo str_replace("'", "\\'", $this->getParameterValue('list.fields.'.$column->getName().'.name')) ?>') ?]
<?php endif; ?>
    <?php echo $this->getHelpAsIcon($column, 'list') ?>
  </th>
<?php if ($credentials): ?>
    [?php endif; ?]
<?php endif; ?>
<?php endforeach; ?>
