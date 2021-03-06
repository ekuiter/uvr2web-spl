<?php

/**
 * Contains Separator class
 *
 * @package Devices
 */
 
/**
 * Separator
 *
 * Separator for grouping devices.
 *
 * @package Devices
 */

class Separator {
  
  /**
   * Separator number
   */
  public $no;
  /**
   * Readable device type
   */
  public $human_type;
  /**
   * Device type
   */
  private $type;
  
  /**
   * Creates a new separator
   * @param int    $no
   * @param string $type
   */
  public function __construct($no, $type) {
    $this->no = $no;
    $this->type = $type;
    $this->human_type = Loc::t('group');
    $this->type == 'heat_meter' ? $this->human_type = Loc::t('heat meter') : 0;
  }
  
  /**
   * Gets an alias
   * @param bool $real
   */
  public function get_alias($real = false) {
    $result = DB::query("SELECT config_value FROM uvr2web_config WHERE config_key='{$this->type}_separator{$this->no}_alias'");
    if (DB::get_rows() > 0) {
      if ($result[0]['config_value'] || $real)
        return $result[0]['config_value'];
      else if (Runtime::hasFeature("single sensor"))
        return $GLOBALS['brand'];
      else
        return "$this->human_type $this->no";
    } else {
      DB::query("INSERT INTO uvr2web_config (config_key, config_value) VALUES('{$this->type}_separator{$this->no}_alias', '')");
      return $real ? '' : "$this->human_type $this->no";
    }
  }

  /**
   * Sets an alias
   * @param string $alias
   */
  public function set_alias($alias) {
    DB::query("UPDATE uvr2web_config SET config_value='" . DB::escape($alias) . "' WHERE config_key='{$this->type}_separator{$this->no}_alias'");
  }
  
  /**
   * Renders the separator
   */
  public function render() {
    $alias = $this->get_alias();
    echo "<h4>$alias</h4>";
  }
  
  public function get_enabled() {
    return true;
  }
  
}

?>