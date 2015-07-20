<?php slot('title',__('JoTAG - Account')) ?>
<?include_partial("global/header",array('title'=>__('Auhtorizations for %jotag%',array('%jotag%'=>$jotag->getJotag())),'tshirts'=>true)) ?>
	<?php if ($sf_user->hasFlash('message')): ?>
		<div id="message_<?=strtolower($sf_user->getFlash('type')) ?>">
			<?php 
				switch($sf_user->getFlash('message'))
				{
					case "AUTH_REJECTED": print __("Authorization request successfully rejected!"); break;
					case "AUTH_ACCEPTED": print __("Authorization request successfully accepted!"); break;
					case "AUTH_DISCARDED": print __("Authorization request successfully discarded!"); break;
					case "AUTH_DELETED": print __("Authorization request successfully deleted!"); break;
				}
			?>
		</div>	
	<?php endif; ?>
	
	<h4><?php echo __('Pending Requests') ?></h4>
	<?php if($pending): ?>
		<center>
			<table border="0" width="90%" align="center">
				<?php foreach($pending as $p): ?>
					<tr>
						<td><?php echo $p->getUser() ?> (<?php echo $p->getUser()->getPrimaryEmail() ?>)</td>
						<td width="220px" align="right">
							<?php echo button_to(__('Accept'),'@accept_auth_request?jotag='.$jotag->getJotag().'&user='.$p->getUser()->getId(),array('confirm'=>__('Are you sure you want to accept this authorization request?'))) ?>
							<?php echo button_to(__('Reject'),'@reject_auth_request?jotag='.$jotag->getJotag().'&user='.$p->getUser()->getId(),array('confirm'=>__('Are you sure you want to reject this authorization request?'))) ?>
							<?php echo button_to(__('Discard'),'@discard_auth_request?jotag='.$jotag->getJotag().'&user='.$p->getUser()->getId(),array('confirm'=>__('Are you sure you want to discard this authorization request?'))) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</center>
	<?php else: ?>
		<p align="center"><em><?php echo __('This JoTAG does not have any pending request') ?></em></p>
	<?php endif; ?><br/>
	<h4><?php echo __('Accepted Requests') ?></h4>
	<?php if($authorized): ?>
		<center>
			<table border="0" width="90%" align="center">
				<?php foreach($authorized as $p): ?>
					<tr>
						<td><?php echo $p->getUser() ?> (<?php echo $p->getUser()->getPrimaryEmail() ?>)</td>
						<td width="220px" align="right">
							<?php echo button_to(__('Reject'),'@reject_auth_request?jotag='.$jotag->getJotag().'&user='.$p->getUser()->getId(),array('confirm'=>__('Are you sure you want to reject this authorization request?'))) ?>
							<?php echo button_to(__('Delete'),'@discard_auth_request?jotag='.$jotag->getJotag().'&user='.$p->getUser()->getId(),array('confirm'=>__('Are you sure you want to discard this authorization request?'))) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</center>
	<?php else: ?>
		<p align="center"><em><?php echo __('This JoTAG does not have any accepted request') ?></em></p>
	<?php endif; ?><br/>
	<h4><?php echo __('Rejected Requests') ?></h4>
	<?php if($denied): ?>
		<center>
			<table border="0" width="90%" align="center">
				<?php foreach($denied as $p): ?>
					<tr>
						<td><?php echo $p->getUser() ?> (<?php echo $p->getUser()->getPrimaryEmail() ?>)</td>
						<td width="220px" align="right">
							<?php echo button_to(__('Accept'),'@accept_auth_request?jotag='.$jotag->getJotag().'&user='.$p->getUser()->getId(),array('confirm'=>__('Are you sure you want to accept this authorization request?'))) ?>
							<?php echo button_to(__('Delete'),'@discard_auth_request?jotag='.$jotag->getJotag().'&user='.$p->getUser()->getId(),array('confirm'=>__('Are you sure you want to discard this authorization request?'))) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</center>
	<?php else: ?>
		<p align="center"><em><?php echo __('This JoTAG does not have any rejected request') ?></em></p>
	<?php endif; ?><br/>