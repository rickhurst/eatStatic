<?php

require EATSTATIC_ROOT.'/eatStaticBlog.class.php';

$show_prev_next = false;

$blog = new eatStaticBlog;
$posts = $blog->getArchiveList($slug);
$page_title = BLOG_TITLE.' :: Archive '.$slug;

$posts = array_reverse($posts);

eatStatic::template('page_top.php');
eatStatic::template('body_top.php');

foreach($posts as $post){
	
	eatStatic::template('post_item.php');
	
}

eatStatic::template('body_bottom.php');
eatStatic::template('page_bottom.php');
?>