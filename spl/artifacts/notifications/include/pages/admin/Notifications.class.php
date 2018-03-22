<?php

/**
 * Contains Notifications class
 *
 * @package AdminPages
 */
 
/**
 * Notifications page
 *
 * Allows to manage notifications.
 *
 * @package AdminPages
 */

class Notifications {

  /**
   * Gets page title 
   */
  public function title() {
    return Loc::t('notifications');
  }
  
  /**
   * Renders the notifications section
   */
  public function render() {
    if ($_POST)
      $this->save();
    $notifications_body = Loc::t('notifications body');
    $comma_separated = Loc::t('comma-separated');
    $save = Loc::t('save');
    $cancel = Loc::t('cancel');
    $email_number = count(Notifier::get_emails());
    $emails = $email_number == 1 ? Loc::t('email') : Loc::t('emails');
    $emails_string = Notifier::get_emails_string();
    $notification_settings = "";
    foreach (Notifier::get_notifications() as $notification)
      $notification_settings .= $notification->render_settings();
    echo <<<code
    <p style="margin-bottom:30px">$notifications_body</p>
    <form method="post" action="?p=admin&sub=notifications" class="form-horizontal">
        <div class="control-group">
          <label class="control-label" for="email"><strong>$email_number</strong> $emails</label>
          <div class="controls">
            <input style="margin-right:20px;width:300px" type="text" name="email" id="email" value="$emails_string" /> <em>$comma_separated</em>
          </div>
        </div>
        $notification_settings
        <div class="control-group">
          <div class="controls">
            <input type="submit" value="$save" class="btn btn-primary" />
            <a href="?p=admin&sub=notifications" class="btn">$cancel</a>
          </div>
        </div>
      </form>
code;
  }
  
  /*
   * Saves notification settings
   */
  function save() {
    if (isset($_POST['email']))
      Notifier::set_emails_string($_POST['email']);
    foreach (Notifier::get_notifications() as $notification)
      $notification->update_settings();
  }

}

?>