<?php slot('title',__('JoTAG - Customize Badge')) ?>
<?include_partial("global/header",array('class'=>'header_temporary','title'=>__('Badge for %jotag%',array("%jotag%"=>esc_entities($jotag->getJotag()))),'tshirts'=>true)) ?>
<form action="<?php echo url_for('@jotag_badge?jotag='.$jotag->getJotag()) ?>" method="POST">
	<table>
		<tr>
			<td colspan="2"><b><?php echo $form["badge_id"]->renderLabel() ?>:</b></td>
			<td><?php echo $form["badge_id"]->render() ?></td>
		</tr>
		<tr>
			<td>
				<?php echo $form["badge_options"] ?>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	    <tr>
	      <td colspan="2">
	        <input type="submit" name="submit" value="<?php echo __("Save") ?>" />
	        <?php echo button_to(__('Cancel'),"@configure?jotag=".$jotag->getJotag()) ?>
	      </td>
	    </tr>
	</table>
</form>