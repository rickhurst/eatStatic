<?




require ROOT.'/skin/'.SKIN.'/templates/page_top.php';
require ROOT.'/skin/'.SKIN.'/templates/body_top.php';

foreach($items as $post_file){
	$post = new eatStaticBlogPost;
	$post->data_file_path = $post_file;
	$post->hydrate();
	
	require ROOT.'/skin/'.SKIN.'/templates/post_item.php';
	
}

$paginator->render();

require ROOT.'/skin/'.SKIN.'/templates/body_bottom.php';
require ROOT.'/skin/'.SKIN.'/templates/page_bottom.php';

?>