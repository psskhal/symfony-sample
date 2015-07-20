<?php if (count(@$errors)): ?>
	<script type="text/javascript">
		alert('<?=implode("\\n",$errors) ?>');
	</script>
<?php else: ?>
	<form action="<?=url_for('@invite') ?>" method="post" id="webmail_form">
		<?php foreach($contacts as $k=>$contact): ?>
			<input type="hidden" name="invite[emails][<?=$k?>][first_name]" value="<?=esc_entities($contact["first_name"])?>" />
			<input type="hidden" name="invite[emails][<?=$k?>][last_name]" value="<?=esc_entities($contact["last_name"])?>" />
			<input type="hidden" name="invite[emails][<?=$k?>][email]" value="<?=esc_entities($contact["email"])?>" />
		<?php endforeach; ?>
	</form>
	<script type="text/javascript">
		$('webmail_form').submit();
	</script>
<?php endif; ?>