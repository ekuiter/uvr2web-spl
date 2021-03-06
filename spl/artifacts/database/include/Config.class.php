<?php

/**
 * Contains Config class
 *
 * @package Config
 */

/**
 * uvr2web configuration
 *
 * Manages the configuration file.
 *
 * @package Config
 */

class Config {

  /*
   * Path to the configuration file
   */
  static $config_file;
  /*
   * Default configuration
   */
  static $default_config = array('active' => 'false');
  
  /**
   * Initializies the Config class
   */
  public static function init() {
    self::$config_file = dirname(__FILE__).'/cfg';
  }

  /*
   * Reads configuration file
   */
  public static function get_config() {
    if (file_exists(self::$config_file))
      return unserialize(file_get_contents(self::$config_file));
    else
      return self::set_config(self::$default_config);
  }

  /*
   * Writes configuration file
   */
  public static function set_config($config) {
    if (@file_put_contents(self::$config_file, serialize($config)) === false)
      throw new Exception(dirname(self::$config_file).' is not writeable');
    return $config;
  }
  
  /*
   * Deletes configuration file and directory
   */
  public static function delete_config() {
    if (file_exists(self::$config_file))
      unlink(self::$config_file);
  }

  public static function upload_password() {
    if (Runtime::hasFeature("single sensor")) {
      $result = DB::query("SELECT * FROM uvr2web_users WHERE username='$GLOBALS[id]'");
      return $result[0]['password'];
    } else
      return self::get_config()['upload_password'];
  }

}

?>