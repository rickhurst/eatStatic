<?php
/**
 * @desc standalone script renders HTML for 5 recent posts, for use in other websites
 */
require 'eatStatic_config.php';
require EATSTATIC_ROOT.'/eatStaticBlog.class.php';

$blog = new eatStaticBlog;
$posts = $blog->getRecentPosts();

foreach($posts as $post):
	// get a summary - first x words

	// replace main image with smaller version and append full URL
	// TODO - this needs to be done with a MAIN_IMAGE tag
?>
<div class="summary">
	<a href="http://<?php echo $_SERVER['HTTP_HOST']. $post->uri ?>"><?php echo $post->title ?></a>
</div>
<?php 
endforeach;
?>