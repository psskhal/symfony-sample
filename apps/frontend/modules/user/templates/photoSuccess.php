<?php slot('title',__('JoTAG - Upload Photo')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Upload Photo'))) ?>
	<table>
		<tr>
			<td width="150px" valign="top" align="center">
				<?=image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$user->getProfile()->getPhoto(),array('width'=>'150px')) ?><br/>
				<?php if ($user->getProfile()->getPhoto(false)): ?>
					<?=link_to(__('[Delete]'),'@photo_del',array('confirm'=>__('Are you sure you want to delete this photo?'))) ?>
				<?php endif; ?>
			</td>
			<td valign="top">
				<form action="<?php echo url_for('@photo') ?>" enctype="multipart/form-data" method="POST">
				  <table>
				    <?php echo $form ?>
				    <tr>
				      <td colspan="2">
				        <input type="submit" name="submit" value="<?php echo __("Upload Photo") ?>" />
				        <?=button_to(__('Cancel'),'@account') ?>
				      </td>
				    </tr>
				  </table>
				</form>
			</td>
		</tr>
	</table>