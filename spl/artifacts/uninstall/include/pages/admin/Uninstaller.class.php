<?php

/**
 * Contains Uninstaller class
 *
 * @package AdminPages
 */

/**
 * Uninstaller page
 *
 * Uninstalls uvr2web.
 *
 * @package AdminPages
 */

class Uninstaller {

  /**
   * Gets page title
   */
  public function title() {
    return Loc::t('uninstall');
  }

  /**
   * Renders the uninstall section
   */
  public function render() {
    if (isset($_GET['uninstall']))
      $this->uninstall();
    else {
      $uninstall_uvr2web = Loc::t('uninstall uvr2web');
      $body = Loc::t('uninstall body');
      $backup = str_replace('\\\n', '\n', addslashes(Loc::t('uninstall backup')));
      $sure = str_replace('\\\n', '\n', addslashes(Loc::t('uninstall sure')));
      echo <<<code
    $body
    <a class="btn btn-primary" href="#" onclick="c=confirm('$backup');
    if(c)location.href='index.php?p=admin&sub=backup';
    else {c=confirm('$sure');
    if(c)location.href='index.php?p=admin&sub=uninstaller&uninstall';}">$uninstall_uvr2web</a>
code;
    }
  }

  private function uninstall() {
    System::uninstall($GLOBALS['cfg']['password']);
    $body2 = Loc::t('uninstall body 2');
    echo <<<code
    <form method="post" action="index.php?p=admin&sub=uninstaller">
    <p style="color:green;font-size:20px;margin:30px 0">
    $body2
    </ol>
    </form>
code;
  }

}

?>