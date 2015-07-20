<?php slot('title',__('JoTAG - Lost your password?')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Lost your password?'))) ?>
	<form action="<?php echo url_for('@forgotpwd') ?>" method="POST">
	  <table>
	    <?php echo $form ?>
	    <tr>
	      <td colspan="2">
	        <input type="submit" name="submit" value="<?php echo __("reset password") ?>" />
	      </td>
	    </tr>
	  </table>
	</form>