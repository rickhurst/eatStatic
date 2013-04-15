<?php

class eatStaticAdminController {


	function __construct(){

		global $stub,$path;

		switch($path[0]){
			case "admin":
				
			break;
			case "api":
				switch($path[1]){
					case "":
						die('no api key');
					break;
					default:
						// check api key
						if($path[1] != API_KEY){
							die('Invalid API key');
						} else {

							switch($path[2]){

								case "post-list":
									// get all posts and return as JSON
									require EATSTATIC_ROOT.'/eatStaticBlog.class.php';
									$blog = new eatStaticBlog;
									$posts = $blog->getPostList();
									echo json_encode($posts);
									die();
								break;

								case "post-file-list":
									// get all posts and return as JSON
									require EATSTATIC_ROOT.'/eatStaticBlog.class.php';
									$blog = new eatStaticBlog;
									$blog->getPostFiles($use_cache=False);
									echo json_encode($blog->post_files);
									die();
								break;
							}
						}
					break;
				}
			break;
		}

	}

}

?>