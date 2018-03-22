<?php

/**
 * Contains DataFrame class
 *
 * @package DataFrame
 */

require_once dirname(__FILE__).'/Uploader.class.php';
require_once dirname(__FILE__).'/FrameCounter.class.php';

/**
 * Data frame processing
 *
 * Reads, writes and analyzes data frames. 
 *
 * @package DataFrame
 */

class DataFrame {

  /**
   * Contains a raw uploaded data frame 
  */
  private $raw = array();
  /**
   * Contains an uploaded data frame 
  */
  private $data = array();
  /**
   * Data frame array pointer
  */
  private $pointer = 0;
  /**
   * File path for latest data frame
  */
  public static $file;
  
  /**
   * Initializes the DataFrame class
   */
  public static function init() {
    self::$file = dirname(__FILE__).'/../uvr';
    Device::get_devices();
  }

  /**
   * Processes the uploading data frame
   * @param string $raw
  */
  public function __construct($raw) {
    $this->raw = json_decode($raw, true);
    if (Runtime::hasFeature("sensor"))
      $this->sensors();
    if (Runtime::hasFeature("heat meter"))
      $this->heat_meters();
    if (Runtime::hasFeature("output"))
      $this->outputs();
    if (Runtime::hasFeature("speed step"))
      $this->speed_steps();
  }

  /**
   * Opens the latest data frame
  */
  public static function open() {
    if (!is_file(self::$file))
      return array();
    return unserialize(file_get_contents(self::$file));
  }

  /**
   * Saves the uploaded data frame
  */
  public function save() {
  if (@file_put_contents(self::$file, serialize($this->data)) === false)
      throw new Exception(dirname(self::$file).' is not writeable');
  }
  
  public static function delete() {
    if (file_exists(self::$file))
      unlink(self::$file);
  }
  
  /**
   * Saves the uploaded data frame into the database
  */
  public function save_to_db() {
    DB::query('INSERT INTO uvr2web_data (timestamp, data_frame)
              VALUES("' . DB::escape(date('Y-m-d H:i:s')) . '", "' . 
              DB::escape(serialize($this->data)) . '")');
  }

  /**
   * Returns the last upload time
   **/
  public static function last_upload() {
    return filemtime(self::$file);
  }
  
  public static function upload_ok() {
    return self::last_upload() > time() - $GLOBALS['upload_interval'] * 2 / 1000;
  }

  /**
   * Reads sensor data from raw data frame 
  */
  private function sensors() {
    $this->data['sensors'] = array();
    foreach ($this->raw['sensors'] as $sensor) {
      $i = $sensor['number'] - 1;
      unset($sensor['number']);
      $this->data['sensors'][$i] = $sensor;
    }
  }

  /**
   * Reads heat meter data from raw data frame 
  */
  private function heat_meters() {
    $this->data['heat_meters'] = array();
    foreach ($this->raw['heat_meters'] as $heat_meter) {
      $i = $heat_meter['number'] - 1;
      unset($heat_meter['number']);
      $this->data['heat_meters'][$i] = $heat_meter;
    }
  }

  /**
   * Reads output data from raw data frame 
  */
  private function outputs() {
    $this->data['outputs'] = array();
    foreach ($this->raw['outputs'] as $output)
      $this->data['outputs'][$output['number'] - 1] = $output['value'];
  }

  /**
   * Reads speed step data from raw data frame 
  */
  private function speed_steps() {
    $this->data['speed_steps'] = array();
    for ($i = 0; $i < count($this->raw['speed_steps']); $i++) {
      $this->raw['speed_steps'][$i]['output']--;
      $this->data['speed_steps'][$i] = $this->raw['speed_steps'][$i];
    }
  }

}

?>