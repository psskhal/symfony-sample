<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();

$browser->
  get('/admin/index')->
  isStatusCode(200)->
  isRequestParameter('module', 'admin')->
  isRequestParameter('action', 'index')->
  checkResponseElement('body', '!/This is a temporary page/');
