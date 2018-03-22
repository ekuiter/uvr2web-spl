<?php

/**
 * Contains Uploader class
 *
 * @package Uploader
 */
 
/**
 * Data frame uploader
 *
 * Uploads a data frame.
 *
 * @package Uploader
 */

class Uploader {

  /**
   * Uploads a data frame.
   *
   * Uses GET for writing the data frame to the database. Counts data frames.
   */
  public function __construct() {
    if (Runtime::hasFeature("single sensor")) {
      if (!isset($_GET['p']) || ($_GET['p'] !== $GLOBALS['pass']) || !isset($_GET['t']))
        die;

      $temperature = str_replace(',', '.', $_GET['t']);
      $frame = '{"sensors":[{"number":1,"value":' . $temperature . ',"type":"temperature"}]}';
    } else {
      if ($_GET['pass'] !== $GLOBALS['pass'])
      die;

      $frame = $_GET['frame'];
    }

    $df = new DataFrame($frame);
    $df->save();
    FrameCounter::add();

    if (FrameCounter::get() >= $GLOBALS['db_frame']) {
      $df->save_to_db();
      FrameCounter::reset();
    }

    if (Runtime::hasFeature("single sensor"))
      echo md5($_GET['t'].$_GET['p']);
  }

}

?>