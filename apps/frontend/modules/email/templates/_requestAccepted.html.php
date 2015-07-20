<p>Dear <?php echo $user ?>,<p>
<p>The owner of jotag <?php echo $jotag ?> accepted your authorization request.</p>
<p>You can view this jotag information by clicking the following link:</p>
<p><?php echo link_to(url_for('@view_jotag?jotag='.$jotag,true),'@view_jotag?jotag='.$jotag,array('absolute'=>true)) ?></p>
<p>Also, a vCard was attached to this email with this jotag information.</p>