<?php $first = true ?>
<?php foreach ($this->getColumnCategories('edit.display') as $category): ?>
<?php
  if ($category[0] == '-')
  {
    $category_name = substr($category, 1);
    $collapse = true;

    if ($first)
    {
      $first = false;
      echo "[?php use_javascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype') ?]\n";
      echo "[?php use_javascript(sfConfig::get('sf_admin_web_dir').'/js/collapse') ?]\n";
    }
  }
  else
  {
    $category_name = $category;
    $collapse = false;
  }
?>
<fieldset id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($category_name)) ?>" class="<?php if ($collapse): ?> collapse<?php endif; ?>">
<?php if ($category != 'NONE'): ?><h2>[?php echo __('<?php echo $category_name ?>') ?]</h2>

<?php endif; ?>

<?php $hides = $this->getParameterValue('edit.hide', array()) ?>
<?php foreach ($this->getColumns('edit.display', $category) as $name => $column): ?>
<?php if (in_array($column->getName(), $hides)) continue ?>
<?php $credentials = $this->getParameterValue('edit.fields.'.$column->getName().'.credentials') ?>
<?php if ($credentials): $credentials = str_replace("\n", ' ', var_export($credentials, true)) ?>
    [?php if ($sf_user->hasCredential(<?php echo $credentials ?>)): ?]
<?php endif; ?>

<?php if ($column->isPrimaryKey() && !$column->isPartial() && !$column->isComponent()): ?>
[?php if(!$form["<?php echo $column->getName() ?>"]->isHidden()): ?]
<?php endif; ?>

<div class="form-row">
  [?php echo $form["<?php echo $column->getName() ?>"]->renderLabel(__($labels['<?php echo $this->getSingularName() ?>{<?php echo $column->getName() ?>}'])) ?]
  <div class="content[?php if ($form["<?php echo $column->getName() ?>"]->hasError()): ?] form-error[?php endif; ?]">
  [?php $value = <?php echo $this->getColumnEditTag($column); ?>; echo $value ? $value : '&nbsp;' ?]
  [?php if ($form["<?php echo $column->getName() ?>"]->hasError()): ?]
    [?php echo $form["<?php echo $column->getName() ?>"]->renderError() ?]
  [?php endif; ?]
  </div>
  <?php echo $this->getHelp($column, 'edit') ?>
</div>

<?php if ($column->isPrimaryKey() && !$column->isPartial() && !$column->isComponent()): ?>
[?php endif; ?]
<?php endif; ?>

<?php if ($credentials): ?>
    [?php endif; ?]
<?php endif; ?>

<?php endforeach; ?>
</fieldset>
<?php endforeach; ?>