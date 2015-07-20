<p>Thank for your recent purchase on JoTAG!</p>
<p>Please keep this e-mail receipt for your records.</p>
<p>Order Number: <?=$payment->getPaymentNumber() ?><br/> 
Jotag: <?=$payment->getTag()->getJotag() ?><br/>
Duration: <?=$payment->getDuration() ?> <?php if($payment->getMethod() == PaymentPeer::PT_CREDITS): ?>days<?php else: ?><?=PaymentPeer::getYearString($payment->getDuration(),false) ?><?php endif; ?><br/>
Payment Method: <?=__(PaymentPeer::$PAYMENT_METHODS[$payment->getMethod()]) ?><br/>    
Order Total: <?=sprintf(OptionPeer::retrieveOption('CURRENCY_FORMAT'),$payment->getAmount()) ?></p>