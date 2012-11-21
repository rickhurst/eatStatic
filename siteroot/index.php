<?php

/**
 * This is a so-called "front-controller" i.e. by default all page loads and "friendly urls" are
 * controlled by the logic in this file.
 * 
 * The "friendly" URL is split into an array and a switch is used to load the appropriate page or script.
 *
 * You don't have to use this if you don't want to - feel free to go old skool and just load
 * pages directly! 
 *
 * However, bear in mind that if you don't use it, the image-cache stuff won't work, amongst other things
 *
 * An alternative is to use specific url_rewrite rules in your .htaccess file
 */

/**
 * load the config file
 */

session_start();

require 'eatStatic_config.php';

/**
 * set up a global variable so we can detect if front controller is being used
 */
define('FRONT_CONTROLLER', "1");

/**
 * get the url, and split the parts into an array
 */
$url = str_replace("?".$_SERVER["QUERY_STRING"],"",$_SERVER["REQUEST_URI"]);

/**
 * to accomodate people who can't use url rewriting, this allows a url to
 * be specified in the format ?p=/here/is/the/url
 */
// if(($url == '') && (eatStatic::getValue('p') != '')){
//  $url = eatStatic::getValue('p');
// }

$path = explode("/",trim($url,"/"));
$path = array_pad($path, 10, "");

if(WP_URLS){
    
    // TODO - block/  301 redirect for any native URL's (e.g. 'posts/2008-...) that sneak through
    // TODO - move this to eatStaticBlog::wpUrls();
    
    // deal with wordpress urls e.g 2006/11/21/this-is-a-slug/
    if(is_numeric($path[0]) && is_numeric($path[1]) && is_numeric($path[2])){
        $slug = $path[0].'-'.$path[1].'-'.$path[2].'-'.$path[3];
        $path[0] = 'posts';
        $path[1] = $slug;
    }
    
    // archive urls
    if(is_numeric($path[0]) && is_numeric($path[1]) && ($path[2] == '')){
        $slug = $path[0].'-'.$path[1];
        $path[0] = 'archive';
        $path[1] = $slug;
    }

}

// load user object (not a proper eatStaticUser instance) from session
$user = unserialize(eatStatic::getValue('user','session'));
$stub = '';

try {
	switch($path[0]) { 
		
		
		/**
		 * blog URL handling
		 */
		
		
		/**
		 * home page
		 */
		case "":

			require EATSTATIC_ROOT.'/eatStaticBlog.class.php';

			$blog = new eatStaticBlog;
			$posts = $blog->getRecentPosts();
			$page_title = BLOG_TITLE.' :: '.BLOG_TAG_LINE;
    		
    		// set up paginator
    		$paginator = new eatStaticPaginator;
    		$paginator->total = count($blog->post_files);
			

			$stub = "blog_index.php";
		break;
		
		/**
		 * blog post page
		 */
		case "posts":

			switch ($path[1]){

				case "all":

					switch ($path[2]){
						case "";
							// probably 404, as we never want to return all posts?
						break;

						default:

							require EATSTATIC_ROOT.'/eatStaticBlog.class.php';

							// return appropriate slice depending on specified page
							$blog = new eatStaticBlog;
							$posts = $blog->getSlicedPosts($path[2]-1);

							$page_title = BLOG_TITLE.' :: '.BLOG_TAG_LINE;
							$current_page = $path[2];

							// set up paginator
				    		//$blog->getPostFiles();
				    		$paginator = new eatStaticPaginator;
				    		$paginator->current = $path[2];
				    		$paginator->total = sizeof($blog->post_files);

							$stub = "blog_index.php";

						break;
					}

				break;

				default:
					$stub = "post.php";
					$slug = str_replace(PAGE_EXT,"",$path[1]);
				break;
			}

		break;
		
		/**
		 * blog archive - either direct to the blog archive index or an archive page
		 */
		case "archive":
			switch($path[1]) {
				case "":
					$stub = "archive_index.php";
				break;
				default:
					$slug = str_replace(PAGE_EXT,"",$path[1]);
					$stub = "archive_page.php";
				break;
			}
		break;
		
		/**
		 * Categories (AKA "Tags")
		*/
		case "category":
			switch($path[1]) {
				case "":
					$stub = "category_index.php";
				break;
				default:
					$slug = str_replace(PAGE_EXT,"",$path[1]);
					switch($path[2]){
						case "":
							$stub = "category_page.php";
						break;
						case "feed":
							// category RSS
							$stub = "category_rss.php";
						break;
					}
				break;
			}
		break;

		/**
		 * Image handling using the image cache
		 */
		case "images":
			require_once(EATSTATIC_ROOT."/eatStaticImageCacheController.class.php");
			new eatStaticImageCacheController();
		break;

		/**
		 * The rss feed
		 */
		case "feed":
			$stub = "rss.php";
		break;

		
		/**
		 * if we haven't found a match yet, try against simple page engine
		 */
		default:
			
			$stub = ""; // in case no other matches are found below, set this so the user gets a 404
			
			/**
			 * simple page engine - see if there is a file named e.g. page_<slug>.php in the root
			 */
			if(eatStatic::slugFormatOk($path[0]) && file_exists(ROOT."/page_".$path[0].".php")){
				$stub = "page_".$path[0].".php";
			}
			
			/**
			 * [TODO]: here is where we could redirect to EatStaticCMS engine 
			 * looking for matching folder paths
			 */

		break;
	}		

} catch (Exception $e) {	
	echo "Error: " . $e->getMessage();
}

/**
 * if we have a stub, require it, otherwise return a 404
 */
if ($stub != ''){
	
	require(ROOT."/".$stub);
} else {
	header("HTTP/1.0 404 Not Found");
	$stub = "404.php";
	require(ROOT."/".$stub);
}

?>
