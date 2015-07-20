Dear <?php echo $user ?>,
The owner of jotag <?php echo $jotag ?> accepted your authorization request.
You can view this jotag information by clicking the following link:

<?php echo link_to(url_for('@view_jotag?jotag='.$jotag,true),'@view_jotag?jotag='.$jotag,array('absolute'=>true)) ?>

Also, a vCard was attached to this email with this jotag information.