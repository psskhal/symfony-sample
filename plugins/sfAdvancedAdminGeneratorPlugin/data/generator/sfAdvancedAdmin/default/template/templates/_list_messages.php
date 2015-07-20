[?php if ($sf_request->hasError('delete')): ?]
<div class="form-errors">
  <h2>[?php echo __('Could not delete the selected %name%', array('%name%' => '<?php echo sfInflector::humanize($this->getSingularName()) ?>')) ?]</h2>
  <dl>
    <dd>[?php echo __($sf_request->getError('delete')) ?]</dd>
  </dl>
</div>
[?php elseif ($sf_user->hasFlash('notice')): ?]
<div class="save-ok">
 <h2>[?php echo __($sf_user->getFlash('notice')) ?]</h2>
</div>
[?php endif; ?]