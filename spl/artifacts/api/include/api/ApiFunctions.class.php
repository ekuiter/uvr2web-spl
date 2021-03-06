<?php

/**
 * Contains ApiFunctions class
 *
 * @package Api
 */

require_once dirname(__FILE__).'/ApiHelper.class.php';
require_once dirname(__FILE__).'/AccountApi.class.php';
require_once dirname(__FILE__).'/AuthApi.class.php';
require_once dirname(__FILE__).'/DeviceApi.class.php';
require_once dirname(__FILE__).'/SystemApi.class.php';
 
/**
 * uvr2web API Functions
 *
 * Provides all API functions.
 *
 * @package Api
 */

class ApiFunctions {
  
  public $account;
  public $auth;
  public $device;
  public $system;
  
  public function __construct() {
    $this->account = new AccountApi();
    $this->auth = new AuthApi();
    $this->device = new DeviceApi();
    $this->system = new SystemApi();
  }
  
}
  
?>