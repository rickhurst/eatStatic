<?php

require EATSTATIC_ROOT.'/eatStaticBlog.class.php';

$blog = new eatStaticBlog;
$blog->post_folder = DATA_ROOT.'/posts/';
$posts = $blog->getRecentPosts();

// translate into RSS object/ items
$feed = new eatStaticBlogFeed;
$feed->blog_title = BLOG_TITLE.' :: '.BLOG_TAG_LINE;
$feed->blog_link = 'http://'.$_SERVER['HTTP_HOST'];


if(sizeof($posts) > 0){
	// get the date of the the most recent item in format Tue, 01 Jun 2010 13:35:09 +0000
	$pub_date = date('D, d M y 00:00:00 +0000',strtotime($posts[0]->date));
	$feed->pub_date = $pub_date;
	
	foreach($posts as $post){
		$item = new eatStaticBlogFeedItem;
		$item->title = $post->title;
		$item->pub_date = date('D, d M y 00:00:00 +0000',strtotime($post->date));
		$item->author = $post->author;
		
		if(WP_URLS){
		    
		    $date_str = date('Y', strtotime($post->date)).'-'.date('m', strtotime($post->date)).'-'.date('d', strtotime($post->date));
		    $item->uri = SITE_ROOT.date('Y', strtotime($post->date)).'/'.date('m', strtotime($post->date)).'/'.date('d', strtotime($post->date)).'/'.str_replace($date_str .'-','',$post->slug).'/';
		} else {
		    $item->uri = SITE_ROOT.'posts/'.$post->slug.PAGE_EXT;
		}
		
		$item->url = 'http://'.$_SERVER['HTTP_HOST'].$item->uri;
		$item->summary = substr($post->body, 0, 200).'...';
		$item->formatted_body = $post->formatted_body;
		
		$feed->items[] = $item;
		
	}
	
}

header("Content-Type: application/xml; charset=ISO-8859-1");
require ROOT.'/skin/global/templates/rss_2_feed.php'




?>