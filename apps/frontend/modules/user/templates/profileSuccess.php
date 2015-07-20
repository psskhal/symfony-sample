<?php slot('title',__('JoTAG - Profile')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Profile'))) ?>
	<form action="<?php echo url_for('@profile') ?>" method="POST">
	  <table>
	    <?php echo $form ?>
	    <tr>
	      <td colspan="2">
	        <input type="submit" name="submit" value="<?php echo __("Update Profile") ?>" />
	        <?=button_to(__('Cancel'),'@account') ?>
	      </td>
	    </tr>
	  </table>
	</form>