<?php slot('title',__('JoTAG - Upload Photo')) ?>
<?include_partial("global/header",array('title'=>__('Upload photo for %jotag%',array("%jotag%"=>$jotag->getJotag())),'tshirts'=>true)) ?>
	<table>
		<tr>
			<td width="150px" valign="top" align="center">
				<div id="photo"><?=image_tag(sfConfig::get('sf_userimage_dir_name').'/'.$jotag->getTagProfile()->getPhoto(),array('width'=>'144px','height'=>'162px')) ?></div>
				<?php if ($jotag->getTagProfile()->getPhoto(false)): ?>
					<?=link_to(__('[Use profile photo]'),'@jotag_photo_del?jotag='.$jotag->getJotag(),array('confirm'=>__('Are you sure you want to delete this photo and use your profile photo?'))) ?>
				<?php else: ?>
					<em>Profile photo!</em>
				<?php endif; ?>
			</td>
			<td valign="top">
				<form action="<?php echo url_for('@jotag_photo?jotag='.$jotag->getJotag()) ?>" enctype="multipart/form-data" method="POST">
				  <table>
				    <?php echo $form ?>
				    <tr>
				      <td colspan="2">
				        <input type="submit" name="submit" value="<?php echo __("Upload Photo") ?>" />
				        <?=button_to(__('Cancel'),'@configure?jotag='.$jotag->getJotag()) ?>
				      </td>
				    </tr>
				  </table>
				</form>
			</td>
		</tr>
	</table>