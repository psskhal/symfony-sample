<?php
class jtBasicFilter extends sfFilter
{
  public function execute ($filterChain)
  {
    if ($this->isFirstCall() and !$this->getContext()->getUser()->isAuthenticated())
    {
      if ($cookie = $this->getContext()->getRequest()->getCookie(sfConfig::get('app_rememberme_cookie_name', 'jtRemember')))
      {
      	// remove old keys
	    $c = new Criteria();
	    $expiration_age = sfConfig::get('app_rememberme_expiration_age', 15 * 24 * 3600);
	    $c->add(RememberKeyPeer::CREATED_AT, time() - $expiration_age, Criteria::LESS_THAN);
	    RememberKeyPeer::doDelete($c);
      	
        $c = new Criteria();
        $c->add(RememberKeyPeer::REMEMBER_KEY, $cookie);
        $rk = RememberKeyPeer::doSelectOne($c);
        if ($rk && $rk->getUser())
        {
          $this->getContext()->getUser()->signIn($rk->getUser());
        }
      }
    }

    $filterChain->execute();
  }
}
?>