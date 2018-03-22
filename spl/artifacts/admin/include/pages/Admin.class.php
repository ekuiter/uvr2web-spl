<?php

/**
 * Contains Admin class
 *
 * @package Pages
 */
 
/**
 * Renders admin area
 *
 * Renders admin area and determines the specific admin page.
 *
 * @package Pages
 */

class Admin {
  
  /**
   * Role
   *
   * Admin role is required to use the admin section.
   */
  public $role = 'admin';
  /**
   * Sub section
   */
  private $sub = 'Start';
  /**
   * Sub section object
   */
  private $obj;

  /**
   * Creates the admin area
   */
  public function __construct() {
    if (isset($_GET['sub'])) {
      $this->sub = ucfirst(preg_replace('/[^a-zA-Z0-9_]+/', '', $_GET['sub']));
      $this->sub = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->sub)));
      if (!is_file(dirname(__FILE__).'/admin/' . $this->sub . '.class.php'))
        $this->sub = 'Start';
    }
  }

  /**
   * Gets the page title
   */
  public function title() {
    return Loc::t('admin');
  }
  
  /**
   * Renders the admin area
   */
  public function render($show_page) {
    if ($this->sub == 'Start')
      $this->start();
    else {
      require_once dirname(__FILE__).'/admin/' . $this->sub . '.class.php';
      $this->obj = new $this->sub();
      echo '<h2>' . $this->obj->title() . '</h2>';
      return $this->obj->render($show_page);
    }
  }

  /**
   * Renders the sidebar
   */
  public function sidebar() {
    $this->sidebar_sub(Loc::t('language'), 'start');
    if (Runtime::hasFeature("user management") || Runtime::hasFeature("single sensor"))
        $this->sidebar_sub(Loc::t('users'), 'users');
    if (Runtime::hasFeature("notifications"))
      $this->sidebar_sub(Loc::t('notifications'), 'notifications');
    if (Runtime::hasFeature("sensor") && !Runtime::hasFeature("single sensor"))
      $this->sidebar_sub(Loc::t('sensors'), 'sensors');
    if (Runtime::hasFeature("output"))
      $this->sidebar_sub(Loc::t('outputs'), 'outputs');
    if (Runtime::hasFeature("heat meter"))
      $this->sidebar_sub(Loc::t('heat meters'), 'heat_meters');
    if (Runtime::hasFeature("speed step"))
      $this->sidebar_sub(Loc::t('speed steps'), 'speed_steps');
    if (Runtime::hasFeature("backup"))
      $this->sidebar_sub(Loc::t('backup'), 'backup');
    if (Runtime::hasFeature("uninstall"))
      $this->sidebar_sub(Loc::t('uninstall'), 'uninstaller');
  }
  
  /**
   * Adds a sidebar link
   * @param string $title
   * @param string $sub
   */
  private function sidebar_sub($title, $sub) {
    Renderer::sidebar_link($title, "?p=admin&amp;sub=$sub", str_replace(' ', '', ucwords(str_replace('_', ' ', $sub))) == $this->sub);
  }

  /**
   * Renders the language section
   */
  private function start() {
    if (isset($_POST['language'])) {
      if (in_array($_POST['language'], Loc::languages()))
        Loc::set_language($_POST['language']);
      echo <<<code
<script type="text/javascript">
  /* <![CDATA[ */
  window.location = "?p=admin";
  /* ]]> */
</script>
code;
    }
    $admin_body = Loc::t('admin body');
    $save = Loc::t('save');
    $cancel = Loc::t('cancel');
    $language = Loc::t('language');
    $options = (new Loc())->get_language_options();
    echo <<<code
    <h2>$language</h2>
    <p style="margin-bottom:30px">$admin_body</p>
    <form method="post" action="?p=admin" class="form-horizontal">
        <div class="control-group">
          <label class="control-label" for="language">$language</label>
          <div class="controls">
            <select name="language" id="language" size="1">
              $options
            </select>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <input type="submit" value="$save" class="btn btn-primary" />
            <a href="?p=admin" class="btn">$cancel</a>
          </div>
        </div>
      </form>
code;
  }
  
  function live() {
    System::backup();
  }

}

?>