<?php

class Loc {
    protected function get_default_language() {
        return "en";
    }

    public function get_language_options() {
        return parent::get_language_options()
            . "<option value=\"en\" " . (Loc::get_language() == 'en' ? ' selected' : '') . ">" . Loc::t('english') . "</option>";
    }
    
    protected function get_translations() {
        return array_merge(parent::get_translations(), array(
            "en" => array(
                'status' => 'Status',
                'sensor' => 'Sensor',
                'sensors' => 'Sensors',
                'output' => 'Output',
                'outputs' => 'Outputs',
                'heat meter' => 'Heat meter',
                'heat meters' => 'Heat meters',
                'speed step' => 'Speed step',
                'speed steps' => 'Speed steps',
                'admin' => 'Admin',
                'logout' => 'Logout',
                'about' => 'About '.$GLOBALS['brand'].'',
                'docs' => 'Documentation',
                'imprint' => 'Imprint',
                'users' => 'Users',
                'user' => 'User',
                'overview' => 'Overview',
                'admin body' => 'You can browse through the settings on the left side.',
                'change aliases' => 'Change aliases',
                'change order' => 'Change order',
                'here you can' => 'Here you can change the aliases for the elements in the',
                'specified order' => 'specified order',
                'here you can 2' => '',
                'here you can heat meters' => 'Here you can change the aliases for the activated heat meters.',
                'save' => 'Save',
                'cancel' => 'Cancel',
                'all aliases' => 'All aliases have been saved.',
                'drag to' => 'Drag to rearrange the elements. Settings are saved immediately.',
                'add separator' => 'Add separator',
                'name separators' => 'you can name the separators',
                'here' => 'here',
                'name separators 2' => '',
                'group' => 'Group',
                'add user' => 'Add user',
                'username' => 'Username',
                'password hash' => 'Password hash',
                'role' => 'Role',
                'password' => 'Password',
                'password confirmation' => 'Confirm password',
                'edit' => 'Edit',
                'remove' => 'Remove',
                'language' => 'Language',
                'english' => 'English',
                'german' => 'German',
                'french' => 'French',
                'admin deleted' => 'Admin successfully deleted.',
                'user deleted' => 'User successfully deleted.',
                'last admin' => 'The last Admin can\'t be deleted.',
                'remove 1' => 'Are you sure you want do remove ',
                'remove 2' => '?',
                'remove 3' => 'You can\'t undo this.',
                'remove 4' => ' Remove ',
                'remove 5' => '',
                'sure' => 'I\'m sure',
                'passwords dont match' => 'Passwords don\'t match.',
                'edit 1' => 'Successfully updated ',
                'edit 2' => '.',
                'edit 3' => 'Edit ',
                'edit 4' => '',
                'add 1' => 'New user <em>dummy</em> generated. Please change username and password.',
                'add 2' => 'Adding a new user failed. Does <em>dummy</em> already exist?',
                'current power' => 'Current power',
                'kwh' => 'kWh',
                'mwh' => 'MWh',
                'log in' => 'Log in',
                'login incorrect' => 'Login incorrect.',
                'smallest value' => 'Smallest value',
                'highest value' => 'Highest value',
                'notifications' => 'Notifications',
                'email' => 'E-Mail address',
                'emails' => 'E-Mail addresses',
                'comma-separated' => '(comma-separated)',
                'notifications body' => 'Notifications are sent to your e-mail addresses. They contain status information or possible problems.',
                'notifications body 2' => 'Notify if no data has been uploaded for ',
                'notifications body 4' => 'Remind every ',
                'notifications body 5' => ' days that a backup should be created.',
                'notifications body 3' => ' minutes.',
                'data record' => 'New data record saved!',
                'md5 hash' => 'MD5 hash',
                'frames uploaded' => 'data frames uploaded',
                'frames until' => 'data frames until next data record (~',
                'frames until 2' => ' minutes)',
                'current data frame' => 'Current data frame',
                'last data record' => 'Last data record on ',
                'last data record 2' => ' at ',
                'last data record 3' => '',
                'upload issues' => 'Upload issues',
                'notification' => ''.$GLOBALS['brand'].' notification',
                'no upload notification body' => 'Apparently there are upload issues with your '.$GLOBALS['brand'].' installation.',
                'no upload notification body 2' => 'The last data frame was uploaded more than',
                'no upload notification body 3' => 'minutes ago (on',
                'no upload notification body 4' => 'at',
                'no upload notification body 5' => 'If you don\'t take action, no <strong>new data frames</strong> will be uploaded.<br />
    You should make sure that the device is connected correctly.',
                'notification footer' => 'You received this mail because you activated the appropriate option',
                'notification footer 2' => 'here',
                'notification footer 3' => '.',
                'notification footer 4' => 'Please do not answer this mail. It was generated automatically.',
                'backup notification' => 'Backup',
                'backup notification body' => 'The last backup of '.$GLOBALS['brand'].' was',
                'backup notification body 2' => 'days ago.',
                'backup notification body 3' => 'Here',
                'backup notification body 4' => 'you can download the most recent backup.',
                'backup' => 'Backup',
                'do backup' => 'Create backup',
                'backup body' => 'The backup contains all database tables of '.$GLOBALS['brand'].'.
    <ul>
    <li>Settings</li>
    <li>Data frames</li>
    <li>Users</li>
    </ul>
    It can be restored while installing '.$GLOBALS['brand'].'.',
                'uninstall' => 'Uninstall',
                'uninstall uvr2web' => 'Uninstall '.$GLOBALS['brand'].'',
                'uninstall body' => '<p><strong>Pity! You want to deinstall '.$GLOBALS['brand'].' :(</strong></p>
    <p>Please tell me <a href="mailto:info@elias-kuiter.de">here</a> why, hence I can improve the program.</a></p>
    <p>The deinstallation consists of two steps:</p>
    <ol>
    <li>Deleting the database tables</li>
    <li>Deleting the files</li>
    </ol>
    <p>
    '.$GLOBALS['brand'].' can take care of step 1.<br />
    But deleting the files on the FTP server afterwards is up to you.
    <p>It is recommended to create a <a href="index.php?p=admin&sub=backup">backup</a> before the deinstallation.</p>',
                'uninstall backup' => 'Do you want to create a backup before the deinstallation?\nIf you did this already, click Cancel.',
                'uninstall sure' => 'Are you REALLY SURE you want to deinstall '.$GLOBALS['brand'].'?',
                'uninstall body 2' => 'The database tables have been deleted.<br />
    '.$GLOBALS['brand'].' is now disabled.</p>
    <p>Please delete the files on the FTP server now:</p>
    <ol>
    <li>Open your FTP client (z.B. <a href="http://sourceforge.net/projects/filezilla/" target="_blank">Filezilla</a>).</li>
    <li>Connect to this server.</li>
    <li>Delete the '.$GLOBALS['brand'].' folder.</li>',
                'no data frames' => '<h4>No data frames!</h4>
    No data frames are in the database.<br />
    Make sure that the device is configured correctly.<br />
    If it is, this warning should disappear if you reload the page in ~',
                'no data frames 2' => 'seconds.',
                'months' => array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
                'object removed' => 'Object removed successfully.',
                'object enabled' => 'Object enabled successfully.',
                'disabled' => 'is disabled',
                'enable' => 'enable',
                'status ok' => 'Everything alright!',
                'status failed' => 'Upload problems!',
                'no data' => 'No data for this month!',
                'day' => 'Day',
                'week' => 'Week',
                'month' => 'Month',
                'all' => 'All',
            )));
    }
}

?>