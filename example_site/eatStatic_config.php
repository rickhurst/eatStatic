<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

// dynamic ROOT
if (!defined('ROOT')) {
	define('ROOT', str_replace('/eatStatic_config.php', '', str_replace('\\', '/', realpath(__FILE__))));
}

// data folder path (assumes admin_site and data folders on same level)
define('DATA_ROOT', str_replace('public_site','data', ROOT));

// eatStatic library path (assumes admin_site and data folders on same level)
define('EATSTATIC_ROOT', str_replace('public_site','library/eatStatic', ROOT));

// eyegaze library path (assumes admin_site and data folders on same level)
define('EYEGAZE_ROOT', str_replace('public_site','library/eyegaze', ROOT));


require_once(EATSTATIC_ROOT."/eatStatic.class.php");
require_once(EATSTATIC_ROOT."/eatStaticError.class.php");
require_once(EATSTATIC_ROOT."/eatStaticStorage.class.php");
require_once(EYEGAZE_ROOT."/questionnaire.class.php");
require_once(ROOT."/application/modules/questionnaire/qneQuestionnaire.class.php");

define('NICE_DATE_FORMAT', 'D, d M Y');
define('SKIN','default');
define('SITE_TITLE', 'QA');
define('SITE_TAG_LINE', '');
define('SITE_AUTHOR', 'Rick Hurst');
define('PAGE_EXT', '');
define('USE_CACHE', false);
define('SITE_ROOT','/'); // change this if you move the location of the site index.php e.g. '/blog/';
define('DISQUS_ENABLED', false);
define('DISQUS_IDENTIFIER','');
define('GOOGLE_ANALYTICS_ID','');
define('GLOBAL_KEYWORDS', '');
define('GLOBAL_DESCRIPTION', '');
define('LOGIN_REQUIRED', false);
define('LOGIN_URL', 'login');
define('STORAGE_TYPE', 'ES_JSON');
define('SNAPSHOT', false);

//$login_exceptions = array('login','logged-out');

$production = false;
if($_SERVER['HTTP_HOST'] == 'ontheroad.rickhurst.co.uk'){
	$production = true;
}

// create an error object to store error messages
$err = new eatStaticError;


?>
