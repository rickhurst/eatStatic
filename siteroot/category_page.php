<?
require EATSTATIC_ROOT.'/eatStaticBlog.class.php';
require EATSTATIC_ROOT.'/eatStaticTag.class.php';

$show_prev_next = false;

$tag = new eatStaticTag;
$tag->file_name = $slug.'.json'; // TODO: security validation of slug

$tag->loadFromFileName();


$page_title = BLOG_TITLE.' :: '.$tag->name;

$items = array_reverse($tag->items);

require ROOT.'/skin/'.SKIN.'/templates/page_top.php';
require ROOT.'/skin/'.SKIN.'/templates/body_top.php';

foreach($items as $post_file){
	$post = new eatStaticBlogPost;
	$post->data_file_path = $post_file;
	$post->hydrate();
	
	require ROOT.'/skin/'.SKIN.'/templates/post_item.php';
	
}

require ROOT.'/skin/'.SKIN.'/templates/body_bottom.php';
require ROOT.'/skin/'.SKIN.'/templates/page_bottom.php';

?>