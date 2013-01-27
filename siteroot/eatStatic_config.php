<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

// keep php 5.3 happy
date_default_timezone_set('Europe/London');

// dynamic ROOT
if (!defined('ROOT')) {
	define('ROOT', str_replace('/eatStatic_config.php', '', str_replace('\\', '/', realpath(__FILE__))));
}

// data folder path (assumes admin_site and data folders on same level)
define('DATA_ROOT', str_replace('siteroot','ontheroad', ROOT));

// eatStatic library path (assumes admin_site and data folders on same level)
define('EATSTATIC_ROOT', str_replace('siteroot','library/eatStatic', ROOT));

$production = false;
if($_SERVER['HTTP_HOST'] == 'ontheroad.rickhurst.co.uk'){
	$production = true;
}

require_once(EATSTATIC_ROOT."/eatStatic.class.php");
require_once(EATSTATIC_ROOT."/eatStaticError.class.php");
require_once(EATSTATIC_ROOT."/eatStaticStorage.class.php");

if($production){
	define('USE_CACHE', true);
} else {
	define('USE_CACHE', false);
}

define('NICE_DATE_FORMAT', 'D, d M Y');
define('SKIN','ontheroad');
define('BLOG_TITLE', 'Rick on the Road');
define('BLOG_TAG_LINE', 'blog about mobile working and the VW T25 camper van');
define('BLOG_AUTHOR', 'Rick Hurst');
define('PAGE_EXT', '');
define('SITE_ROOT','/'); // change this if you move the location of the site index.php e.g. '/blog/';
define('DISQUS_ENABLED', true);
define('DISQUS_IDENTIFIER','rickontheroad2');
define('GOOGLE_ANALYTICS_ID','UA-562825-12');
define('GLOBAL_KEYWORDS', 'mobile working, camping, solar power, camper van, T25, T25 camper, VW');
define('GLOBAL_DESCRIPTION', 'Rick on the road is a blog written by Rick Hurst about his experiences of mobile working, camping and his VW T25 campervan');
define('LOGIN_REQUIRED', false);
define('LOGIN_URL', 'login');
define('STORAGE_TYPE', 'ES_JSON');
define('SNAPSHOT', false);
define('POSTS_PER_PAGE', 10);

define('WP_URLS', true); // use wordpress url scheme

define('CACHE_ROOT', str_replace('siteroot','ontheroad/cache', ROOT));

// SQL fake filesystem settings
define('SQL_FS', false);
if('SQL_FS'){
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', '');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', '');
    define('SQL_FS_TABLE', 'eatstatic_fs');
    require_once(EATSTATIC_ROOT."/eatStaticSQL.class.php");
    require_once(EATSTATIC_ROOT."/eatStaticFakeFS.class.php");
}

//$login_exceptions = array('login','logged-out');



// create an error object to store error messages
$err = new eatStaticError;


?>
