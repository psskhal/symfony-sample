[?php echo form_tag('<?php echo $this->getModuleName() ?>/create', array(
  'id'        => 'sf_admin_edit_form',
  'name'      => 'sf_admin_edit_form',
  'multipart' => true,
<?php foreach ($this->getColumnCategories('create.display') as $category): ?>
<?php foreach ($this->getColumns('create.display', $category) as $name => $column): ?>
<?php if (false !== strpos($this->getParameterValue('create.fields.'.$column->getName().'.type'), 'admin_double_list')): ?>
  'onsubmit'  => 'double_list_submit(); return true;'
<?php break 2; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php endforeach; ?>
)) ?]

<?php foreach ($this->getPrimaryKey() as $pk): ?>
[?php echo object_input_hidden_tag($<?php echo $this->getSingularName() ?>, 'get<?php echo $pk->getPhpName() ?>') ?]
[?php if($form["<?php echo strtolower($pk->getColumnName()) ?>"]->isHidden()): ?]
	[?php echo $form["<?php echo strtolower($pk->getColumnName()) ?>"]->render() ?]
[?php endif; ?]
<?php endforeach; ?>

[?php include_partial('create_fields', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'labels' => $labels)) ?]
[?php include_partial('create_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]

</form>
