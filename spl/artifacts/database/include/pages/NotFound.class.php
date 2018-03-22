<?php

/**
 * Contains NotFound class
 *
 * @package Pages
 */
 
/**
 * Renders a 404 page
 *
 * Renders a 404 page if the requested page doesn't exist.
 *
 * @package Pages
 */

class NotFound {
  
  /**
   * Gets the page title
   */
  public function title() {
    return '404 Not Found';
  }
  
  /**
   * Renders a 404 page
   */
  public function render() {
  }
  
} 

?>