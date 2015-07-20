<?php
/**
 * sfSimpleCaptchaRouting class
 *
 * @package sfSimpleCaptcha
 * @author Carlos Eduardo O. A. Barros
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class sfSimpleCaptchaRouting
{
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $routing = $event->getSubject();
    // add plug-in routing rules on top of the existing ones
    $routing->prependRoute('sfSimpleCaptcha', sfConfig::get('app_simple_captcha_route'), array('module' => 'captcha'));
  }
}
