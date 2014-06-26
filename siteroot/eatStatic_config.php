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

define('LIB_ROOT', str_replace('siteroot','library', ROOT));

$production = true;

$local_hosts = Array(
    'rick.ontheroad.macbook.local',
    'localhost'
);

if(in_array($_SERVER['HTTP_HOST'], $local_hosts)){
	$production = false;
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
define('BLOG_TITLE', 'Camper Van Things');
define('BLOG_TAG_LINE', 'Blog about mobile working and Rocky the VW T25 (T3/Vanagon) camper van');
define('BLOG_AUTHOR', 'Rick Hurst');
define('PAGE_EXT', '');
define('SITE_ROOT','/'); // change this if you move the location of the site index.php e.g. '/blog/';
define('DISQUS_ENABLED', false);
define('DISQUS_IDENTIFIER','rickontheroad2');
define('GOOGLE_ANALYTICS_ID','UA-562825-12');
define('GLOBAL_KEYWORDS', 'mobile working, camping, solar power, camper van, T25, T25 camper, VW, T3, Vanagon');
define('GLOBAL_DESCRIPTION', 'Camper van things is a blog written by Rick Hurst about his experiences of mobile working, camping and his VW T25 (T3/Vanagon) campervan');
define('LOGIN_REQUIRED', false);
define('LOGIN_URL', 'login');
define('STORAGE_TYPE', 'ES_JSON');
define('SNAPSHOT', false);
define('POSTS_PER_PAGE', 10);
define('ADMIN_ENABLED', false);

define('WP_URLS', true); // use wordpress url scheme

define('CACHE_ROOT', str_replace('siteroot','ontheroad/cache', ROOT));

// SQL fake filesystem settings
define('SQL_FS', false);
if(SQL_FS){
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', '');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', '');
    define('SQL_FS_TABLE', 'eatstatic_fs');
    require_once(EATSTATIC_ROOT."/eatStaticSQL.class.php");
    require_once(EATSTATIC_ROOT."/eatStaticFakeFS.class.php");
}

//$login_exceptions = array('login','logged-out');
if(ADMIN_ENABLED){
    require 'eatStatic_admin_local_settings.php';
    require_once(EATSTATIC_ROOT."/eatStaticAdminController.class.php");
}


// create an error object to store error messages
$err = new eatStaticError;


?>
