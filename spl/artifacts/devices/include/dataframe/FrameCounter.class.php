<?php

/**
 * Contains FrameCounter class
 *
 * @package DataFrame
 */
 
/**
 * Counts data frames
 *
 * Counts data frames and saves them to the database.
 *
 * @package DataFrame
 */

class FrameCounter {

  /**
   * Gets the frame counter from the databse 
  */
  public static function get() {
    $result = DB::query('SELECT * FROM uvr2web_config WHERE config_key="frame_counter"');
    if ($result == array()) {
      DB::query('INSERT INTO uvr2web_config VALUES("frame_counter", "0")');
      return 0;
    }
    return (int) ($result[0]['config_value']);
  }

  /**
   * Increments the frame counter 
  */
  public static function add() {
    $count = self::get();
    DB::query('UPDATE uvr2web_config SET config_value="' . ($count + 1) . '" WHERE config_key="frame_counter"');
  }
  
  /**
   * Sets the frame counter 
  */
  public static function set($count) {
    if (!is_numeric($count))
      return;
    self::get();
    DB::query('UPDATE uvr2web_config SET config_value="' . DB::escape($count) . '" WHERE config_key="frame_counter"');
  }

  /**
   * Resets the frame counter
  */
  public static function reset() {
    DB::query('DELETE FROM uvr2web_config WHERE config_key="frame_counter"');
  }

}

?>