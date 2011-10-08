<?php
require '../eatStatic_config.php';

if(file_exists(CACHE_ROOT.'/all_posts.json')){
	unlink(CACHE_ROOT.'/all_posts.json');
	echo 'all posts cache removed<br />';
}
if(file_exists(CACHE_ROOT.'/recent_files.json')){
	unlink(CACHE_ROOT.'/recent_files.json');
	echo 'recent posts cache removed';
}
?>
<a href="/">home</a>