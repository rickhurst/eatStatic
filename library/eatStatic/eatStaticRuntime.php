<?php
define('ROOT', $root);

// data folder path
define('DATA_ROOT', $es_data_root);

// eatStatic library path 
define('EATSTATIC_ROOT', $es_root);

define('LIB_ROOT', $lib_root);

require_once(EATSTATIC_ROOT."/eatStatic.class.php");
require_once(EATSTATIC_ROOT."/eatStaticError.class.php");
require_once(EATSTATIC_ROOT."/eatStaticStorage.class.php");

$production = true;

if(in_array($_SERVER['HTTP_HOST'], $local_hosts)){
	$production = false;
}

if($production){
	define('USE_CACHE', true);
} else {
	define('USE_CACHE', false);
}

define('NICE_DATE_FORMAT', $es_date_format);
define('SKIN',$es_skin);
define('BLOG_TITLE', $es_blog_title);
define('BLOG_TAG_LINE', $es_blog_tag_line);
define('BLOG_AUTHOR', $es_blog_author);
define('POSTS_PER_PAGE', $es_posts_per_page);
define('PAGE_EXT', $es_page_ext);
define('SITE_ROOT', $es_site_root);
define('DISQUS_ENABLED', $es_disqus_enabled);
define('DISQUS_IDENTIFIER', $es_disqus_identifier);
define('GOOGLE_ANALYTICS_ID', $es_ga_id);
define('GLOBAL_KEYWORDS', $es_global_keywords);
define('GLOBAL_DESCRIPTION', $es_global_description);
define('LOGIN_REQUIRED', $es_login_required);
define('LOGIN_URL', $es_login_url);
define('STORAGE_TYPE', $es_storage_type);
define('SNAPSHOT', $es_snapshot);
define('ADMIN_ENABLED', $es_admin_enabled);

define('WP_URLS', $es_wp_urls);

define('CACHE_ROOT', $es_cache_root);

// SQL fake filesystem settings
define('SQL_FS', false);
if(SQL_FS){
    define('DB_SERVER', $db_server);
    define('DB_USERNAME', $db_username);
    define('DB_PASSWORD', $db_password);
    define('DB_DATABASE', $db_name);
    define('SQL_FS_TABLE', $db_fs_table);
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