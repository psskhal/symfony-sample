<?php slot('title',__('JoTAG - Change Password')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Change Password'))) ?>
	<form action="<?php echo url_for('@password') ?>" method="POST">
	  <table>
	    <?php echo $form ?>
	    <tr>
	      <td colspan="2">
	        <input type="submit" name="submit" value="<?php echo __("Change Password") ?>" />
	        <?=button_to(__('Cancel'),'@account') ?>
	      </td>
	    </tr>
	  </table>
	</form>