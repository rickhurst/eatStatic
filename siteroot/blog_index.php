<?php

require EATSTATIC_ROOT.'/eatStaticBlog.class.php';

$blog = new eatStaticBlog;
$posts = $blog->getRecentPosts();
$page_title = BLOG_TITLE.' :: '.BLOG_TAG_LINE;
$pages = $blog->getPaginated();

$show_prev_next = false;

require ROOT.'/skin/'.SKIN.'/templates/page_top.php';
require ROOT.'/skin/'.SKIN.'/templates/body_top.php';

foreach($posts as $post){
	require ROOT.'/skin/'.SKIN.'/templates/post_item.php';
}

for($i=1; $i<=$pages; $i++){
	echo '<a href="'.SITE_ROOT.'posts/all">'.$i.'</a> ';
}

require ROOT.'/skin/'.SKIN.'/templates/body_bottom.php';
require ROOT.'/skin/'.SKIN.'/templates/page_bottom.php';

?>