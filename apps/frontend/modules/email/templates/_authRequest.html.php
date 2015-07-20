<p><?php echo $user ?> requested to view your JoTAG <?php echo $jotag ?></p>    
<?php if($message): ?>
<p>----<br/>
<?php echo $message ?><br/>  
----</p>
<?php endif ?>  

<p>Accept - <?php echo link_to(url_for('@accept_auth_request?jotag='.$jotag.'&user='.$user->getId(),true),'@accept_auth_request?jotag='.$jotag.'&user='.$user->getId(),array('absolute'=>true)) ?><br/>  
Reject - <?php echo link_to(url_for('@reject_auth_request?jotag='.$jotag.'&user='.$user->getId(),true),'@reject_auth_request?jotag='.$jotag.'&user='.$user->getId(),array('absolute'=>true)) ?></p>  

<p>You can manage your authorizations by clicking the following link:<br/><br/>
<?php echo link_to(url_for('@manage_auth_request?jotag='.$jotag,true),'@manage_auth_request?jotag='.$jotag,array('absolute'=>true)) ?></p>