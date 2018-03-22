<?php

/**
 * Contains Sensors class
 *
 * @package AdminPages
 */
 
/**
 * Sensors admin page
 *
 * Allows to group sensors and set aliases.
 *
 * @package AdminPages
 */

class Sensors extends AdminRenderer {

  /**
   * Class
   */
  protected $class = 'Sensor';

  public function __construct() {
    parent::__construct();
    if (Runtime::hasFeature("single sensor"))
      throw new Exception("sensor admin deactivated");
  }
  
}

?>