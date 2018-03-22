<?php

/**
 * Contains System class
 *
 * @package System
 */

/**
 * System utilities
 *
 * @package System
 */

class System {

  public static function backup() {
    if (!Runtime::hasFeature("backup"))
      throw new Exception("backup deactivated");
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$GLOBALS['brand'].'-'.date('Y-m-d').'.sql"');
    require_once __DIR__ . '/pages/admin/Backup.class.php';
    (new Backup())->do_backup();
  }
  
  public static function uninstall($confirm) {
    if (!Runtime::hasFeature("uninstall"))
      throw new Exception("uninstall deactivated");
    if ($confirm != $GLOBALS['cfg']['password'])
      throw new Exception('confirm with database password');
    Config::delete_config();
    DataFrame::delete();
    $this->delete_tables();
    session_destroy();
    return 'uninstalled';
  }
  
  private function delete_tables() {
    DB::query('DROP TABLE uvr2web_config');
    DB::query('DROP TABLE uvr2web_data');
    DB::query('DROP TABLE uvr2web_users');
  }

}

?>