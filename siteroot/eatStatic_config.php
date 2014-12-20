<?php
session_start();
//error_reporting(E_ALL);
//error_reporting(E_ALL ^ E_STRICT);
error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors','On');

// keep php 5.3 happy
date_default_timezone_set('Europe/London');

// dynamic ROOT
$root = str_replace('/eatStatic_config.php', '', str_replace('\\', '/', realpath(__FILE__)));

// data folder path (assumes siteroot and data folders on same level)
$es_data_root = str_replace('siteroot','data', $root);

// eatStatic library path (assumes siteroot and library folders are on same level)
$es_root = str_replace('siteroot','library/eatStatic', $root);

// general library folder location
$lib_root = str_replace('siteroot','library', $root);

$es_cache_root = str_replace('siteroot','data/cache', $root);

$local_hosts = Array(
    'localhost',
    'rick.ontheroad.macbook.local'
);

$es_date_format = 'D, d M Y';
$es_skin = 'default';
$es_blog_title = 'eatStatic Blog';
$es_blog_tag_line = 'Demo and documentation site for eatStatic';
$es_blog_author = 'Rick Hurst';
$es_page_ext = '';
$es_site_root = '/';
$es_disqus_enabled = false;
$es_disqus_identifier = '';
$es_wp_urls = true;
$es_ga_id = '';
$es_global_keywords = 'static file CMS, static site generator, static file blog, flat file blog';
$es_global_description = '';
$es_login_required = false;
$es_login_url = '/login';
$es_storage_type = 'ES_JSON';
$es_snapshot = false;
$es_posts_per_page = 10;
$es_admin_enabled = false;
$es_admin_root = '/admin/';

$db_server = 'localhost';
$db_username = '';
$db_password = '';
$db_name = '';
$db_fs_table = '';

// if you want to override the default settings, add a local_settings.php file
if(file_exists($root."/local_settings.php")){
	require($root."/local_settings.php");
}


require $es_root .'/eatStaticRuntime.php';

?>
