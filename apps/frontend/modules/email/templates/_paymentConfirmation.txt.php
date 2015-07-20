Thank for your recent purchase on JoTAG!

Please keep this e-mail receipt for your records.

Order Number: <?=$payment->getPaymentNumber() ?>    
Jotag: <?=$payment->getTag()->getJotag() ?> 
Duration: <?=$payment->getDuration() ?> <?php if($payment->getMethod() == PaymentPeer::PT_CREDITS): ?>days<?php else: ?><?=PaymentPeer::getYearString($payment->getDuration(),false) ?><?php endif; ?>   
Payment Method: <?=__(PaymentPeer::$PAYMENT_METHODS[$payment->getMethod()]) ?>    
Order Total: <?=sprintf(OptionPeer::retrieveOption('CURRENCY_FORMAT'),$payment->getAmount()) ?>