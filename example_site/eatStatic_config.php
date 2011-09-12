<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

// dynamic ROOT
if (!defined('ROOT')) {
	define('ROOT', str_replace('/eatStatic_config.php', '', str_replace('\\', '/', realpath(__FILE__))));
}

// data folder path (assumes admin_site and data folders on same level)
define('DATA_ROOT', str_replace('example_site','data', ROOT));

// eatStatic library path (assumes admin_site and data folders on same level)
define('EATSTATIC_ROOT', str_replace('example_site','library/eatStatic', ROOT));

$production = false;
if($_SERVER['HTTP_HOST'] == 'eatstatic.blog.olivewoodstudio.com'){
	$production = true;
}


require_once(EATSTATIC_ROOT."/eatStatic.class.php");
require_once(EATSTATIC_ROOT."/eatStaticError.class.php");
require_once(EATSTATIC_ROOT."/eatStaticStorage.class.php");

define('NICE_DATE_FORMAT', 'D, d M Y');
define('SKIN','default');
define('BLOG_TITLE', 'eatStatic blog example site');
define('BLOG_TAG_LINE', '');
define('BLOG_AUTHOR', 'Rick Hurst');
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

define('WP_URLS', true); // use wordpress url scheme

// SQL fake filesystem settings
define('SQL_FS', true);
if('SQL_FS'){
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'eatstatic');
    define('DB_PASSWORD', 'eatstatic');
    define('DB_DATABASE', 'eatstatic');
    define('SQL_FS_TABLE', 'fs');
    require_once(EATSTATIC_ROOT."/eatStaticSQL.class.php");
    require_once(EATSTATIC_ROOT."/eatStaticFakeFS.class.php");
}

//$login_exceptions = array('login','logged-out');



// create an error object to store error messages
$err = new eatStaticError;


?>
