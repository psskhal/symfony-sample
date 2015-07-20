<p>There was a problem processing the following payment:<p>

<p>Payment Number (Real): <?=$payment->getNumber() ?><br/> 
Payment Number (Logical): <?=$payment->getPaymentNumber() ?><br/> 
Payment ID: <?=$payment->getId() ?><br/>
PayPal Reference: <?=$payment->getReference() ?><br/> 
Jotag: <?=$payment->getTag()?$payment->getTag()->getJotag():$payment->getJotag() ?><br/> 
Duration: <?=$payment->getDuration() ?> <?=PaymentPeer::getYearString($payment->getDuration(),false) ?><br/>
Order Total: <?=sprintf(OptionPeer::retrieveOption('CURRENCY_FORMAT'),$payment->getAmount()) ?><br/> 
User: <?=$payment->getUser() ?><br/>
User Email: <?=$payment->getUser()->getPrimaryEmail() ?><br/> 
Reason: <?php if($reason == 'CANCELLED'): ?> Tried to process a cancelled order, please verify payment on PayPal<?php elseif($reason == 'AMMOUNT'): ?>Amount mismatch, probably fraud attempt<?php else: ?>Couldn't save JoTAG to the database, probably a race condition<?php endif; ?></p>  