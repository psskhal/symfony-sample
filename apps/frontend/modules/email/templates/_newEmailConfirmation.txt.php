Dear <?=$profile->getFirstName() ?> <?=$profile->getLastName() ?>,
You recently added the address <?=$email->getEmail() ?> to your JoTAG account.  Please confirm that this address is yours by by clicking the following link:
<?=link_to(url_for('@confirm_email?confirm_code='.$email->getConfirmCode(),true),'@confirm_email?confirm_code='.$email->getConfirmCode(),array("absolute"=>true)) ?>