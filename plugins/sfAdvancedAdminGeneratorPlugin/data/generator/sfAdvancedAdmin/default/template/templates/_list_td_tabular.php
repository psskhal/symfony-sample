<?php $hs = $this->getParameterValue('list.hide', array()) ?>
<?php foreach ($this->getColumns('list.display') as $column): ?>
<?php if (in_array($column->getName(), $hs)) continue ?>
<?php $credentials = $this->getParameterValue('list.fields.'.$column->getName().'.credentials') ?>
<?php if ($credentials): $credentials = str_replace("\n", ' ', var_export($credentials, true)) ?>
    [?php if ($sf_user->hasCredential(<?php echo $credentials ?>)): ?]
<?php endif; ?>
  <?php if ($column->isLink()): ?>
  <td class="sf_admin_list_th_<?php echo $column->getName()?>">[?php echo link_to(<?php echo $this->getColumnListTag($column) ?> ? <?php echo $this->getColumnListTag($column) ?> : __('-'), '<?php echo $this->getModuleName() ?>/<?php echo $this->getParameterValue('list.click_action', 'edit') ?>?<?php echo $this->getPrimaryKeyUrlParams() ?>) ?]</td>
<?php else: ?>
  <td class="sf_admin_list_th_<?php echo $column->getName()?>">[?php echo <?php echo $this->getColumnListTag($column) ?> ?]</td>
  <?php endif; ?>
<?php if ($credentials): ?>
    [?php endif; ?]
<?php endif; ?>
<?php endforeach; ?>
