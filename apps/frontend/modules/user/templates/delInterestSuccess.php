<?php slot('title',__('JoTAG - Del from interest list')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Del from interest list'))) ?>
	<?php if ($form["jotag"]->hasError()): ?>
		<p class="error"><?=$form["jotag"]->getError() ?></p>
	<?php endif; ?>
	<form action="<?php echo url_for('@del_interest?jotag='.$form["jotag"]->getValue()) ?>" method="POST">
	  <p><b><?php echo __("Confirm JoTAG to be removed from your interest list") ?>:</b></p>
	  <table>
	  	<tr>
	  		<td><b><?=$form["jotag"]->renderLabel() ?>:</b></td>
	  		<td><?=$form["jotag"]->getValue() ?></td>
	  	</tr>
	  	<tr>
	  		<td><b><?=$form["confirm_jotag"]->renderLabel() ?>:</b></td>
	  		<td><?=$form["confirm_jotag"]->render() ?></td>
	  	</tr>
	    <tr>
	      <td colspan="2">
	        <input type="submit" name="submit" value="<?php echo __("Remove") ?>" />
	        <?=button_to(__('Cancel'),'@account') ?>
	      </td>
	    </tr>
	  </table>
	</form>