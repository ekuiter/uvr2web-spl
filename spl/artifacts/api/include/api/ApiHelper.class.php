<?php

/**
 * Contains ApiHelper class
 *
 * @package Api
 */
 
/**
 * API Helper
 *
 * Several API helper functions.
 *
 * @package Api
 */

class ApiHelper {
  
  public static function ensure($array) {
    if (is_array($array)) {
      foreach ($array as $function)
        if ($function === '') throw new Exception('blank parameter');
    } else
      if ($array === '') throw new Exception('blank parameter');
  }
  
  public static function logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
  }
  
  public static function authenticate($admin_only = false) {
    if (!self::logged_in())
      throw new Exception('not logged in');
    if ($admin_only && $_SESSION['role'] != 'admin')
      throw new Exception('administrator only');
  }
  
}
  
?>