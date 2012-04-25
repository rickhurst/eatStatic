<?php
require EATSTATIC_ROOT.'/eatStaticBlog.class.php';

//$slug = getValue('slug');

$post = new eatStaticBlogPost;

$post->data_file_path = DATA_ROOT.'/posts/'.$slug.'.txt';
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

require ROOT.'/skin/'.SKIN.'/templates/page_top.php';
require ROOT.'/skin/'.SKIN.'/templates/body_top.php';

//print_r($post->description);
//die();

require ROOT.'/skin/'.SKIN.'/templates/post_item.php';

if(DISQUS_ENABLED){
        require ROOT.'/skin/global/templates/disqus_thread.php';
}

require ROOT.'/skin/'.SKIN.'/templates/body_bottom.php';
require ROOT.'/skin/'.SKIN.'/templates/page_bottom.php';

?>