<?php slot('title',__('JoTAG - Cancel JoTAG')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Cancel JoTAG'))) ?>
<p><?php echo __("Remove JoTAG from your account") ?></p>
  	<?php if ($form["confirm_jotag"]->hasError() || $form["agree"]->hasError()): ?>
		<p class="error">
	  	<?php if ($form["confirm_jotag"]->hasError()): ?>
			<?=$form["confirm_jotag"]->getError() ?><br/>	
		<?php endif; ?>
	  	<?php if ($form["agree"]->hasError()): ?>
			<?=$form["agree"]->getError() ?><br/>	
		<?php endif; ?>
		</p>	
	<?php endif; ?>
	<form action="<?php echo url_for('@cancel_jotag?jotag='.$jotag->getJotag()) ?>" method="POST">
	  <table>
	  	<tr>
	  		<td><b><?=$form["jotag"]->renderLabel() ?>:</b></td>
	  		<td><?=$jotag->getJotag()?></td>
	  	</tr>
	  	<tr>
	  		<td><b><?=$form["confirm_jotag"]->renderLabel() ?>:</b></td>
	  		<td>
	  			<?=$form["confirm_jotag"]->render() ?>
	  		</td>
	  	</tr>
	  	<tr>
	  		<td colspan="2"><?=$form["agree"]->render() ?> <b><?=$form["agree"]->renderLabel() ?></b></td>
	  	</tr>
	    <tr>
	      <td colspan="2">
	        <input type="submit" name="submit" value="<?php echo __("Cancel JoTAG") ?>" />
	        <?=button_to(__('Cancel'),'@account') ?>
	      </td>
	    </tr>
	  </table>
	</form>