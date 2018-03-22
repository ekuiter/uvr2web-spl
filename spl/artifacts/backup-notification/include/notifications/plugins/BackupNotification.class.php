<?php

/**
 * Contains BackupNotification class
 *
 * @package Notifications
 */

/**
 * Backup notification
 *
 * Reminds of backups in a given interval.
 *
 * @package Notifications
 */

class BackupNotification extends Notification {

  /*
   * Time
   *
   * Time in days after that notification is sent.
   */
  private $time;
  /*
   * Default time
   */
  private $default_time = 7;

  /*
   * Fetches time from the database
   */
  function get_time() {
    if (!$this->time) {
      $this->time = $this->default_time;
      $result = DB::query('SELECT * FROM uvr2web_config WHERE config_key="notification_backup_time"');
      if ($result == array())
        DB::query('INSERT INTO uvr2web_config VALUES("notification_backup_time", "'.$this->default_time.'")');
      else {
        $this->time = (int) $result[0]['config_value'];
      }
    }
    return $this->time;
  }

  /**
   * Saves the time
   */
  function set_time($time) {
    DB::query('UPDATE uvr2web_config SET config_value="' . (int) $time . '" WHERE config_key="notification_backup_time"');
    $this->time = (int) $time;
  }

  function check() {
    $sent = $this->get_sent();
    if ($sent == 'false')
      return true;
    $time = $this->get_time();
    $time = $time * 24 * 60 * 60;
    if (($sent + $time) < time())
      return true;
    return false;
  }

  function render() {
    $backup_time = $this->get_time();
    $script = dirname($_SERVER['SCRIPT_NAME']) . 'index.php';
    $link = "http://$_SERVER[SERVER_NAME]$script?p=admin&sub=notifications";
    $backup = Loc::t('backup');
    $notification = Loc::t('notification');
    $body1 = Loc::t('backup notification body');
    $body2 = Loc::t('backup notification body 2');
    $body3 = Loc::t('backup notification body 3');
    $body4 = Loc::t('backup notification body 4');
    $footer1 = Loc::t('notification footer');
    $footer2 = Loc::t('notification footer 2');
    $footer3 = Loc::t('notification footer 3');
    $footer4 = Loc::t('notification footer 4');
    $message = <<<code
    <html>
    <head>
    <title>
    $notification: $backup
    </title>
    </head>
    <body>
    <div style="width:800px;margin:20px auto;font-family:Arial">
    <div style="border:1px solid black;padding:20px;background-color:#eee">
    <h1 style="margin-top:10px;border-bottom:1px solid #999">$notification</h1>
    <h2 style="font-size:1.8em">$backup</h2>
    <p style="font-size:16px;line-height:1.8em;padding:0 0 10px 0">
    $body1 <strong>$backup_time</strong> $body2<br />
    <a href="http://$_SERVER[SERVER_NAME]$script?p=admin&live">$body3</a> $body4
    </p>
    </div>
    <small style="display:block;margin-top:10px;text-align:center">$footer1 <a href="$link">$footer2</a>$footer3<br />
    $footer4</small> 
    </div>
    </body>
    </html>
code;
    return array('subject' => "$notification: $backup", 'message' => $message);
  }
  
  public function render_settings() {
    $notifications_body_4 = Loc::t('notifications body 4');
    $notifications_body_5 = Loc::t('notifications body 5');
    $backup_checked = $this->get_enabled() ? 'checked' : '';
    $backup_time = $this->get_time();
    return <<<code
        <div class="control-group">
          <div class="controls">
            <input style="margin:-3px 3px 0 0" type="checkbox" name="backup" id="backup" value="backup" $backup_checked />
            <label style="display:inline" for="backup">$notifications_body_4 <input style="width:40px;margin:0 5px 0 5px" type="text" name="backup_time" id="backup_time" value="$backup_time" /> $notifications_body_5</label>
          </div>
        </div>
code;
  }

  public function update_settings() {
    if (isset($_POST['backup']))
      $enabled = true;
    else
      $enabled = false;
    $this->set_enabled($enabled);
    if (isset($_POST['backup_time']))
      $this->set_time($_POST['backup_time']);
  }

}

?>