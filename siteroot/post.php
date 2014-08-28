<?php
require EATSTATIC_ROOT.'/eatStaticBlog.class.php';

//$slug = getValue('slug');

$show_prev_next = true;

$post = new eatStaticBlogPost;
if(file_exists(DATA_ROOT.'/posts/'.$slug.'.txt')){
	$post->data_file_path = DATA_ROOT.'/posts/'.$slug.'.txt';
}
if(file_exists(DATA_ROOT.'/posts/'.$slug.'.md')){
	$post->data_file_path = DATA_ROOT.'/posts/'.$slug.'.md';
}
if(file_exists($post->data_file_path)){
        $post->hydrate();
} else {
        header("HTTP/1.0 404 Not Found");
        //header("location:404");
        include ROOT.'/404.php';
        die();
}


$page_title = BLOG_TITLE.' :: '.$post->title;

if($post->keywords != ''){
        $meta_keywords = $post->keywords;
}

if($post->description != ''){
        $meta_description = $post->description;
}

eatStatic::template('page_top.php');
eatStatic::template('body_top.php');

//print_r($post);
//die();

eatStatic::template('post_item.php');

if(DISQUS_ENABLED){
        eatStatic::template('disqus_thread.php');
}

eatStatic::template('body_bottom.php');
eatStatic::template('page_bottom.php');

?>