<?php

/**
 * Initializes uvr2web
 *
 * Also contains important configuration values.
 *
 * @package default
 */

require_once dirname(__FILE__).'/Runtime.class.php';

date_default_timezone_set('Europe/Berlin');
ini_set('memory_limit', -1);
ini_set('serialize_precision', 4);
error_reporting(0);
$GLOBALS['brand'] = '{{brand}}';

require_once dirname(__FILE__).'/Loc.class.php';
require_once dirname(__FILE__).'/Config.class.php';
require_once dirname(__FILE__).'/Password.class.php';
require_once dirname(__FILE__).'/DB.class.php';
require_once dirname(__FILE__).'/Renderer.class.php';
require_once dirname(__FILE__).'/DeviceRenderer.class.php';
require_once dirname(__FILE__).'/AdminRenderer.class.php';
require_once dirname(__FILE__).'/System.class.php';
require_once dirname(__FILE__).'/highcharts/Highchart.php';
require_once dirname(__FILE__).'/dataframe/Device.class.php';
require_once dirname(__FILE__).'/dataframe/DataFrame.class.php';

if (file_exists(dirname(__FILE__).'/api/Api.class.php'))
  require_once dirname(__FILE__).'/api/Api.class.php';

if (file_exists(dirname(__FILE__).'/notifications/Notifier.class.php'))
  require_once dirname(__FILE__).'/notifications/Notifier.class.php';

Config::init();

try {
  $GLOBALS['cfg'] = Config::get_config();
} catch (Exception $e) {
  $GLOBALS['cfg']['active'] = 'false';
}

$header = Loc::t('header');
$footer = Loc::t('footer');
if ($GLOBALS['cfg']['active'] != 'true') {
  $code = <<<code
  $header
	<p style="margin:30px">$GLOBALS[brand] is currently disabled.</p>
	$footer
code;
  die($code);
}
if (file_exists('install.php')) {
  $code = <<<code
  $header
	<p>To finish the installation, you have to delete <em>install.php</em> with your FTP client.</p>
  <p><a href="index.php">I deleted <em>install.php</em></a>.</p>
	$footer
code;
  die($code);
}

DB::start($GLOBALS['cfg']['server'], $GLOBALS['cfg']['username'], $GLOBALS['cfg']['password'], $GLOBALS['cfg']['database']);
DB::connect();

if (Runtime::hasFeature("single sensor"))
  $GLOBALS['id'] = $GLOBALS['cfg']['id'];
$GLOBALS['pass']            = Config::upload_password();
$GLOBALS['db_frame']        = $GLOBALS['cfg']['data_record_interval'];
$GLOBALS['upload_interval'] = $GLOBALS['cfg']['upload_interval'];

Loc::init();
DataFrame::init();

$data = DataFrame::open();
if (Runtime::hasFeature("sensor"))
  Sensor::detect_order($data);
if (Runtime::hasFeature("output"))
  Output::detect_order($data);
if (Runtime::hasFeature("heat meter"))
  HeatMeter::detect_order($data);
if (Runtime::hasFeature("speed step"))
  SpeedStep::detect_order($data);

if (Runtime::hasFeature("notifications"))
  Notifier::notify();

session_name(Runtime::hasFeature("single sensor") ? $GLOBALS['id'] : 'uvr2web');

?>
