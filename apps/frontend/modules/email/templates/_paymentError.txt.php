There was a problem processing the following payment:

Payment Number (Real): <?=$payment->getNumber() ?>  
Payment Number (Logical): <?=$payment->getPaymentNumber() ?>  
Payment ID: <?=$payment->getId() ?>  
PayPal Reference: <?=$payment->getReference() ?>  
Jotag: <?=$payment->getTag()?$payment->getTag()->getJotag():$payment->getJotag() ?>  
Duration: <?=$payment->getDuration() ?> <?=PaymentPeer::getYearString($payment->getDuration(),false) ?>  
Order Total: <?=sprintf(OptionPeer::retrieveOption('CURRENCY_FORMAT'),$payment->getAmount()) ?>     
User: <?=$payment->getUser() ?>  
User Email: <?=$payment->getUser()->getPrimaryEmail() ?>   
Reason: <?php if($reason == 'CANCELLED'): ?> Tried to process a cancelled order, please verify payment on PayPal<?php elseif($reason == 'AMMOUNT'): ?>Amount mismatch, probably fraud attempt<?php else: ?>Couldn't save JoTAG to the database, probably a race condition<?php endif; ?>  