<?php

/**
 * buy actions.
 *
 * @package    jotag
 * @subpackage buy
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class buyActions extends sfActions
{
  public function executeBuy($request)
  {
  	$this->user = $this->getUser()->getSubscriber();
  	
  	$this->step = 1;
  	$this->form = new BuyStep1Form();
  	if($request->isMethod('post') || $request->getParameter('jotag'))
  	{
  		// if direct access, stop on step 1
  		if(!$request->isMethod('post')) $request->setParameter('step',1);
  		
  		$this->form->bind(array('jotag'=>strtolower($request->getParameter('jotag'))));
  		if($this->form->isValid())
  		{
  			// step 1 OK
  			$this->jotag_object = $this->form->getValue('jotag_object');
  			$this->step = 2;
			if($this->user->getCredits() || $this->isWebserviceCall())
			{
				if(!$this->user->getCredits())
				{
					// ok, webservice call, but we don't have credits
					$this->form = null;
					return sfView::ERROR;	
				}
				
				// REDEEM FORK
				$this->setTemplate('redeem');
				
	  			$this->form = new RedeemStep2Form(array('jotag'=>strtolower($this->form->getValue('jotag'))));
	  			if($request->getParameter('step') > 1)
	  			{
	  				$this->form->bind(array
	  				(
	  					'jotag'			=>strtolower($request->getParameter('jotag')),
	  					'confirm_jotag'	=>strtolower($request->getParameter('confirm_jotag')),
	  				));
	  				if($this->form->isValid())
	  				{
  						// step 2 OK, here we create new jotag
  						$this->step = 3;
  						if($this->jotag_object) 
  						{
  							$jotag = $this->jotag_object;
  							$ptype = PaymentPeer::PT_RENEW;
  						}
  						else
			    		{
			    			$jotag = new Tag();
							$jotag->setJotag(strtolower($this->form->getValue('jotag')));
							$jotag->setStatus(TagPeer::ST_NEW);
			    			$jotag->setUser($this->getUser()->getSubscriber());
			    			$jotag->setIsPrimary(false);
			    			$ptype = PaymentPeer::PT_NEW;
			    		}
			    		
			    		// mark this jotag as FREE, so we can automatically give credits
			    		$jotag->setIsCredit(true);
			    		
			    		// calculate new expiration date
			    		$jotag->setValidUntil($jotag->calcNewDate($this->user->getCredits() * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT'),true));
			    		$jotag->setStatus(TagPeer::ST_ACTIVE);
			    		
			    		// create payment
			    		$payment = new Payment();
			    		$payment->setTag($jotag);
	  					$payment->setMethod(PaymentPeer::PT_CREDITS);
  						$payment->setAmount(0);
  						$payment->setDuration($this->user->getCredits() * OptionPeer::retrieveOption('BONUS_DAYS_PER_CREDIT'));
  						$payment->setCredits($this->user->getCredits());
  						$payment->setUser($this->getUser()->getSubscriber());
	  					$payment->setStatus(PaymentPeer::ST_PAID);
	  					$payment->setType($ptype);
	  					
	  					// save
	  					$jotag->save();
  						$payment->save();
  						
  						// remove credits from user account
  						$this->user->setCredits(0);
  						$this->user->save();
  						
  						// remove from interest list
  						$this->user->delInterest($jotag->getJotag());
  						
  						$this->payment = $payment;
  						$this->jotag = $jotag;
  						
		    			// send receipt to the user
				    	Mailer::sendEmail($payment->getUser()->getPrimaryEmail(),'paymentConfirmation',array('payment'=>$payment),$this->getUser()->getSubscriber()->getPreferedLanguage());
	  				}
	  			}
			}
			else
			{
				// BUY FORK
	  			$this->form = new BuyStep2Form(array('jotag'=>strtolower($this->form->getValue('jotag'))));
	  			if($request->getParameter('step') > 1)
	  			{
	  				$this->form->bind(array
	  				(
	  					'jotag'			=>strtolower($request->getParameter('jotag')),
	  					'confirm_jotag'	=>strtolower($request->getParameter('confirm_jotag')),
	  					'duration'		=>$request->getParameter('duration'),
	  				));
	  				if($this->form->isValid())
	  				{
	  					// step 2 OK, create payment
	  					$payment = new Payment();
	  					if($this->jotag_object)	
	  					{
	  						$payment->setTag($this->jotag_object);
	  						$payment->setType(PaymentPeer::PT_RENEW);
	  					}
	  					else 
	  					{
	  						$payment->setJotag(strtolower($this->form->getValue('jotag')));
	  						$payment->setType(PaymentPeer::PT_NEW);
	  					}
	  					$payment->setMethod(PaymentPeer::PT_PAYPAL);
	  					$payment->setAmount((float)sprintf("%0.2f",$this->form->getValue('duration')*OptionPeer::retrieveOption('BUY_PRICE')));
	  					$payment->setDuration($this->form->getValue('duration'));
	  					$payment->setUser($this->getUser()->getSubscriber());
	  					$payment->setCredits(0);
	  					$payment->setStatus(PaymentPeer::ST_NEW);
	  					$payment->save();
	  					
	  					$this->payment = $payment;
	  					$this->getUser()->setPaymentId($payment->getId());
	  					
	  					$this->step = 3;
	  					$this->form = new BuyStep3Form(array(
	  						'jotag'				=> strtolower($this->form->getValue('jotag')),
	  						'confirm_jotag'		=> strtolower($this->form->getValue('confirm_jotag')),
	  						'duration'			=> $this->form->getValue('duration'),
	  					));
	  				}
	  			}
			}
  		}
  		else
  		{
  			if(get_class($this->form["jotag"]->getError()->getValidator()) == "buyJotagValidator")
  				$this->already_exists = $this->form["jotag"]->getError()->getValidator()->getAlreadyExists();
  		}
  		
		$this->suggestions = $this->user->getSuggestions($request->getParameter('jotag'));
  	}
  	else $this->suggestions = $this->user->getSuggestions();
  }
  
  public function executeCancel($request)
  {
  	$paymentId = $this->getUser()->getPaymentId();
  	if($paymentId)
  	{
  		$c = new Criteria();
  		$c->add(PaymentPeer::ID,$paymentId);
  		$c->add(PaymentPeer::USER_ID,$this->getUser()->getSubscriberId());
  		$payment = PaymentPeer::doSelectOne($c);
  		
  		if($payment && ($payment->getStatus() == PaymentPeer::ST_NEW))
  		{
  			$payment->setStatus(PaymentPeer::ST_CANCELLED);
  			$payment->save();
  		}
  	}
  	
  	$this->setMessage('BUY_CANCEL','ERROR');
  	return $this->redirect('@buy');
  }
  
  public function executeProcess($request)
  {
  	$paymentId = $request->getParameter('invoice');
  	
  	// locate payment
  	$c = new Criteria();
  	$c->add(PaymentPeer::ID,$paymentId);
  	$c->add(PaymentPeer::METHOD,PaymentPeer::PT_PAYPAL);
  	$p = PaymentPeer::doSelectOne($c);
  	if($p)
  	{
		// check payment status
		switch($p->getStatus())
		{
			case PaymentPeer::ST_PAID: $this->setMessage("PAYMENT_PAID","SUCCESS",array('jotag'=>$p->getTag(),'type'=>$p->getType())); break;
			case PaymentPeer::ST_PENDING: $this->setMessage("PAYMENT_PENDING","SUCCESS"); break;
			case PaymentPeer::ST_FAILED: $this->setMessage("PAYMENT_FAILED","ERROR"); break;
			case PaymentPeer::ST_NEW: $this->setMessage("PAYMENT_WAITING","SUCCESS"); break;
			default: $this->setMessage("PAYMENT_ERROR","ERROR"); break;  		
		}
  	}
  	else $this->setMessage("PAYMENT_ERROR","ERROR");
  	$this->redirect('@homepage');
  }
  
  public function executeIPN($request)
  {
  	// rebuild post parameters to send back to paypal
    $req = "";
	foreach ($_POST as $var => $value)
    	$req .= "&$var=".urlencode(stripslashes($value));
  	
    // get transaction info
  	$paymentStatus = $request->getParameter('payment_status');
  	$transNum = $request->getParameter('txn_id');
  	$type = $request->getParameter('custom');
  	$paymentId = $request->getParameter('invoice');
  	$totalAmount = $request->getParameter('mc_gross');
  	$test_ipn = $request->getParameter('test_ipn');
  	
  	if($test_ipn && OptionPeer::retrieveOption('PAYPAL_MODE') == 'L') die('fail'); // we are NOT in sandbox
  	
  	// send back to paypal
    $ch = @curl_init();
    @curl_setopt($ch,CURLOPT_POST,1);
    @curl_setopt($ch,CURLOPT_URL,(OptionPeer::retrieveOption('PAYPAL_MODE') != 'L')?"https://www.sandbox.paypal.com/cgi-bin/webscr":"https://www.paypal.com/cgi-bin/webscr");
    @curl_setopt($ch,CURLOPT_POSTFIELDS,"cmd=_notify-validate".$req);
    @curl_setopt($ch,CURLOPT_TIMEOUT,20);
    @curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    @curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    @curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
    $result=@curl_exec($ch);
    @curl_close($ch);
  	
    if ($result != "VERIFIED") //can't verify the POST information, most likely fraudulent so exit.
    	die('fail');
    	
    // locate payment
    $payment = PaymentPeer::getFromField(PaymentPeer::ID,$paymentId);
    if(!$payment || !in_array($payment->getStatus(),array(PaymentPeer::ST_NEW,PaymentPeer::ST_PENDING))) 
    {
    	// tried to process an already paid order, or a cancelled one.. if not paid, alert
    	// staff
    	if($payment && ($payment->getStatus() != PaymentPeer::ST_PAID))
    	{
    		Mailer::sendEmail(OptionPeer::retrieveOption('ADMIN_EMAIL'),'paymentError',array('payment'=>$payment,'reason'=>'CANCELLED'));
    	}
    	die('fail');
    }
    
  	// check if transNum is UNIQUE
  	$c = new Criteria();
  	$c->add(PaymentPeer::REFERENCE,$transNum);
  	$c->add(PaymentPeer::METHOD,PaymentPeer::PT_PAYPAL);
  	$p = PaymentPeer::doSelectOne($c);
  	if($p && ($p->getId() != $payment->getId())) die('fail'); // duplicated transaction

    $payment->setMethod(PaymentPeer::PT_PAYPAL);
    $payment->setReference($transNum);
//    if($type == "RENEW") $payment->setType(PaymentPeer::PT_RENEW);
//    else $payment->setType(PaymentPeer::PT_NEW);
    switch($paymentStatus)
    {
    	case "Completed":
    		
    		// check if value matches
    		if((float)$payment->getAmount() != (float)$totalAmount)
    		{
    			$payment->setStatus(PaymentPeer::ST_ERROR_NOTIFY);
    			$payment->save();
    		}
    		else
    		{
	    		if(!$payment->getTag())
	    		{
	    			$jotag = new Tag();
					$jotag->setJotag($payment->getJotag());
					$jotag->setStatus(TagPeer::ST_NEW);
	    			$jotag->setUser($payment->getUser());
	    			$jotag->setIsPrimary(false);
	    		}
	    		else $jotag = $payment->getTag();
	    		
	    		// calculate new expiration date
	    		$jotag->setValidUntil($jotag->calcNewDate($payment->getDuration()));
	    		
	    		// try to save new jotag
	    		try
	    		{
	    			$jotag->setStatus(TagPeer::ST_ACTIVE);
	    			$jotag->save();
	    		}
	    		catch(PropelException $e)
	    		{
	    			// failed to save  jotag, probably due to duplicated jotag (race condition)
	    			// we must mark it as ERROR and contact user
	    			$payment->setStatus(PaymentPeer::ST_ERROR_NOTIFY);
	    			$jotag = null;
	    		}
	    		
	    		if($jotag) 
	    		{
	    			// everything OK
	    			$payment->setTag($jotag);
	    			$payment->setJotag('');
	    			$payment->setStatus(PaymentPeer::ST_PAID);
	    			
					// remove from interest list
					$payment->getUser()->delInterest($jotag->getJotag());
	    		}
	    		$payment->save();
    		}
    		
    		// send emails
    		if($payment->getStatus() == PaymentPeer::ST_PAID)
    		{
    			// payment processed, notify customer
		    	Mailer::sendEmail($payment->getUser()->getPrimaryEmail(),'paymentConfirmation',array('payment'=>$payment),$payment->getUser()->getPreferedLanguage());
    		}
    		else
    		{
    			// payment processed, but there was an error creating/updating JoTAG, notify merchant
    			$reason = ((float)$payment->getAmount() != (float)$totalAmount)?'AMMOUNT':'DBERROR';
    			
		    	Mailer::sendEmail(OptionPeer::retrieveOption('ADMIN_EMAIL'),'paymentError',array('payment'=>$payment,'reason'=>$reason));
    		}
    	break;
    	case "Pending":
    		$payment->setStatus(PaymentPeer::ST_PENDING);
    		$payment->save();
    	break;
    	case "Failed":
    		$payment->setStatus(PaymentPeer::ST_FAILED);
    		$payment->save();
    	break;
    }
    
  	return sfView::HEADER_ONLY;
  }
    
  /*
   * General routines
   */
  private function setMessage($msg,$type,$params=null)
  {
  	$this->getUser()->setFlash('message',$msg);
  	$this->getUser()->setFlash('type',$type);
	$this->getUser()->setFlash('params',$params);
  }
  
  private function isWebserviceCall()
  {
  	return $this->isSoapRequest();
  }
}
