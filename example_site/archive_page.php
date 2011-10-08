<?php

require EATSTATIC_ROOT.'/eatStaticBlog.class.php';

//$slug = getValue('slug');

$blog = new eatStaticBlog;
$blog->post_folder = DATA_ROOT.'/posts/';
$posts = $blog->getArchiveList($slug);
$page_title = BLOG_TITLE.' :: Archive '.$slug;

$posts = array_reverse($posts);

require ROOT.'/skin/'.SKIN.'/templates/page_top.php';
require ROOT.'/skin/'.SKIN.'/templates/body_top.php';

foreach($posts as $post){
	
	require ROOT.'/skin/'.SKIN.'/templates/post_item.php';
	
}

require ROOT.'/skin/'.SKIN.'/templates/body_bottom.php';
require ROOT.'/skin/'.SKIN.'/templates/page_bottom.php';

?>