[?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'AdvancedAdmin') ?]

[?php use_stylesheet('<?php echo $this->getParameterValue('css', sfConfig::get('sf_admin_web_dir').'/css/main') ?>') ?]

<div id="sf_admin_container">

<?php if ($this->getParameterValue('list.filters')): ?>
	<h1>[?php include_partial('create_title', array('filters' => $filters,'<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]</h1>
<?php else: ?>
	<h1>[?php include_partial('create_title', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]</h1>
<?php endif; ?>

<div id="sf_admin_header">
[?php include_partial('<?php echo $this->getModuleName() ?>/create_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]
</div>

<div id="sf_admin_content">
[?php include_partial('<?php echo $this->getModuleName() ?>/create_messages', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'labels' => $labels)) ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/create_form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'labels' => $labels)) ?]
</div>

<div id="sf_admin_footer">
[?php include_partial('<?php echo $this->getModuleName() ?>/create_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]
</div>

</div>
