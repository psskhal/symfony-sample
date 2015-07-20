<?php echo $user ?> requested to view your JoTAG <?php echo $jotag ?>    
<?php if($message): ?>  
----
<?php echo $message ?>  
----
<?php endif ?>  

Accept - <?php echo url_for('@accept_auth_request?jotag='.$jotag.'&user='.$user->getId(),true) ?>  
Reject - <?php echo url_for('@reject_auth_request?jotag='.$jotag.'&user='.$user->getId(),true) ?>  

You can manage your authorizations by clicking the following link:

<?php echo url_for('@manage_auth_request?jotag='.$jotag,true) ?>