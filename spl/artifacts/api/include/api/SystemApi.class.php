<?php

/**
 * Contains SystemApi class
 *
 * @package Api
 */

/**
 * System API
 *
 * Manipulates system-wide settings.
 *
 * @package Api
 */

class SystemApi {
  
  public $language = 'Returns or sets (admin-only) language.';
  public $language_ex = array('system.language', 'system.language(en)');
  public $backup = 'Downloads a backup file (admin-only).';
  public $backup_ex = array('system.backup');
  public $uninstall = 'Uninstalls uvr2web (admin-only).';
  public $uninstall_ex = array('system.uninstall(db_pass)');
  public $status = 'Returns information regarding the upload status (admin-only).';
  public $status_ex = array('system.status');

  function language($language = null) {
    if (in_array($language, Loc::languages())) {
      ApiHelper::authenticate('admin');
      Loc::set_language($language);
    }
    return Loc::get_language();
  }
  
  function backup() {
    ApiHelper::authenticate('admin');
    System::backup();
  }
  
  function uninstall($confirm) {
    ApiHelper::authenticate('admin');
    return System::uninstall($confirm);
  }
  
  private function delete_tables() {
    DB::query('DROP TABLE uvr2web_config');
    DB::query('DROP TABLE uvr2web_data');
    DB::query('DROP TABLE uvr2web_users');
  }
  
  function status() {
    ApiHelper::authenticate('admin');
    $frames_uploaded = FrameCounter::get();
    $frames_remaining = $GLOBALS['db_frame'] - $frames_uploaded;
    return array(
      'uploading' => DataFrame::upload_ok(),
      'last_upload' => DataFrame::last_upload(),
      'frames_uploaded' => $frames_uploaded,
      'frames_remaining' => $frames_remaining,
      'minutes_remaining' => $GLOBALS['upload_interval'] / 1000 * $frames_remaining / 60
    );
  }

}

?>