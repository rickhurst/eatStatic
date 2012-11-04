<?php
/**
 * @desc - go through live posts and create an index of tags
 */
require '../eatStatic_config.php';

require_once(EATSTATIC_ROOT."/eatStaticBlog.class.php");
require_once(EATSTATIC_ROOT."/eatStaticTag.class.php");

$blog = new eatStaticBlog;
$blog->getPostFiles();

print_r($blog);

// delete tag cache files
eatStaticTag::deleteAll();

foreach($blog->post_files as $post_file){
	$post = new eatStaticBlogPost;
	$post->data_file_path = $post_file;
	$post->hydrate();
	echo $post->title;
	//print_r($post->tags);
	foreach($post->tags as $tag){
		
		// create tag object -> open existing or create new
		$tag_object = new eatStaticTag();
		$tag_object->name = $tag;
		
		// load existing items if there are any
		$tag_object->load(); 		
		
		// add data file path to tag items array
		$tag_object->addItem($post->data_file_path);
		
		// save tag json
		$tag_object->save();
		
	}
	
}


?>