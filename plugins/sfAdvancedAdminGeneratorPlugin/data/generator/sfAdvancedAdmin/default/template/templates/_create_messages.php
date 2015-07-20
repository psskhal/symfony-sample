[?php if ($form->getErrorSchema()->getErrors()): ?]
<div class="form-errors">
<h2>[?php echo __('The form is not valid because it contains some errors.') ?]</h2>
</div>
[?php elseif ($sf_user->hasFlash('notice')): ?]
<div class="save-ok">
<h2>[?php echo __($sf_user->getFlash('notice')) ?]</h2>
</div>
[?php endif; ?]