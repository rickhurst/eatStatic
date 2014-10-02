<?

eatStatic::template('page_top.php');
eatStatic::template('body_top.php');

foreach($items as $post_file){
	$post = new eatStaticBlogPost;
	$post->data_file_path = $post_file;
	$post->hydrate();
	
	require ROOT.'/skin/'.SKIN.'/templates/post_item.php';
	
}

$paginator->render();

eatStatic::template('body_bottom.php');
eatStatic::template('page_bottom.php');

?>