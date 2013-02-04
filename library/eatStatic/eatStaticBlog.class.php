<?php

/**
 * @version 0.1.2
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 * 2011-09-05 - Rick Hurst merged with working version from www.rickhurst.co.uk
 *            - Rick Hurst ES_ROOT replaced with SITE_ROOT
 *            - Rick Hurst added search function
 * 2011-09-20 - Rick Hurst removed pipe from line splitting, upped version to 0.1.2
 */


class eatStaticBlog extends eatStatic {
	
	var $post_folder;
	var $recent_limit = POSTS_PER_PAGE;
	var $post_files = array();

	function __construct() {
		$this->post_folder = DATA_ROOT.'/posts/';
	}
	
	public function getPostFiles(){
		
		if(USE_CACHE){
			// see if cache file exists
			if(file_exists(CACHE_ROOT.'/all_posts.json')){
				$this->post_files = json_decode(eatStatic::read_file(CACHE_ROOT.'/all_posts.json'));
			} else {
				// load posts from disk
				$this->getPostFilesFromDisk();
				
				// write array of post files to disk as JSON
				eatStatic::write_file(json_encode($this->post_files), CACHE_ROOT.'/all_posts.json');
			}
		} else {
			$this->getPostFilesFromDisk();
		}
		
	}
	
	private function getPostFilesFromDisk(){
		if (is_dir($this->post_folder)) {
		    if ($dh = opendir($this->post_folder)) {
		        while (($file = readdir($dh)) !== false) {
		            //echo "filename: $file : filetype: " . filetype($this->post_folder . $file) . "\n";
					if(
						(filetype($this->post_folder . $file) == 'file') && 
						(substr($file,-3) == "txt")
					){
						// for each post found
						$this->post_files[] = $this->post_folder . $file;
					}
		        }
		        sort($this->post_files);
		        closedir($dh);
		    }
		}
	}
	
	public function getRecentPosts(){
		
		$posts = array();
		//$post_count = 0;
		
		if(USE_CACHE){
			// see if cache file exists
			if(file_exists(CACHE_ROOT.'/recent_files.json')){
				$recent_files = json_decode($this->read_file(CACHE_ROOT.'/recent_files.json'));
			} else {
				$recent_files = $this->getRecentPostsArray();
				$this->write_file(json_encode($recent_files), CACHE_ROOT.'/recent_files.json');
			}
		} else {
			$recent_files = $this->getRecentPostsArray();
		}
		
		foreach($recent_files as $post_file){
		
			// for each post found
			$post = new eatStaticBlogPost;
			$post->data_file_path = $post_file;
			$post->hydrate();
			//$post_count++;
			$posts[] = $post;
		
		}

		return $posts;
		
	}

	public function getSlicedPosts($page){
		$this->getPostFiles();
		$all_files = array_reverse($this->post_files);

		//print_r($all_files);

		$sliced = array_slice($all_files, (POSTS_PER_PAGE*$page), POSTS_PER_PAGE);

		//echo (POSTS_PER_PAGE*$page);

		//print_r($sliced);
		//die();
		foreach($sliced as $post_file){
		
			// for each post found
			$post = new eatStaticBlogPost;
			$post->data_file_path = $post_file;
			$post->hydrate();
			//$post_count++;
			$posts[] = $post;
		
		}

		return $posts;


	}
	
	public function getDrafts(){
		
		$posts = array();
		
		$this->getPostFilesFromDisk();
		sort($this->post_files);

		$drafts = array_reverse($this->post_files);

		foreach($drafts as $post_file){
		
			// for each post found
			$post = new eatStaticBlogPost;
			$post->data_file_path = $post_file;
			$post->hydrate();
			//$post_count++;
			$posts[] = $post;
		
		}

		return $posts;
		
	}
	
	private function getRecentPostsArray(){
		$this->getPostFiles();
		sort($this->post_files);
		//print_r($this->post_files);
		
		$recent_files = array_reverse($this->post_files);
		array_splice($recent_files, $this->recent_limit);
		return $recent_files;
	}
	
	
	public function getArchiveIndex(){
		$this->getPostFiles();
		$last_month = '';
		$items = array();
		sort($this->post_files);
		foreach($this->post_files as $file){
			$current_month = substr(basename($file), 0, 7);
			if($current_month != $last_month){
				$item = new eatStaticBlogArchiveItem;
				$item->month_slug = $current_month;
				$item->month_desc = date('F Y', strtotime($current_month."-01 00:00:00"));
				$item->month = date('F', strtotime($current_month."-01 00:00:00"));
				$item->year = date('Y', strtotime($current_month."-01 00:00:00"));
				
				if(WP_URLS){
				    $item->uri = SITE_ROOT.date('Y', strtotime($current_month."-01 00:00:00")).'/'.date('m', strtotime($current_month."-01 00:00:00")).'/';
				} else {
				    $item->uri = SITE_ROOT.'archive/'.$item->month_slug.PAGE_EXT;
				}
				
				$items[] = $item;
			}
			$last_month = $current_month;	
		}
		$items = array_reverse($items);
		return $items;
	}
	
	public function getArchiveList($month_slug){
		$this->getPostFiles();
		$posts = array();
		//echo '['.$month_slug.']';
		$post_count = 0;
		foreach($this->post_files as $post_file){
			//echo '['.substr(basename($file), 0, 7).']';
			if(substr(basename($post_file), 0, 7) == $month_slug){
				//echo 'yes';
				// for each post found
				$post = new eatStaticBlogPost;
				$post->data_file_path = $post_file;
				$post->hydrate();
				$post_count++;
				$posts[] = $post;
			}
		}
		return $posts;
	}
	
	// taken from http://www.zachstronaut.com/posts/2009/01/20/php-relative-date-time-string.html
	public function time_elapsed_string($ptime) {
        $etime = time() - $ptime;

        if ($etime < 1) {
            return '0 seconds';
        }

        $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
                    );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . $str . ($r > 1 ? 's' : '');
            }
        }
    }
    
    public function obsoleteWarning($ptime){
         $etime = time() - $ptime;
         
         $years = round($etime /(12 * 30 * 24 * 60 * 60));
         
         if ($years > 4 ){
             ?>
             <div class="warning">
             This post was written <b><?php echo $years ?> years ago</b>, which in internet time is <em>really, really</em> old. This means that what is written above, and the links contained within, may now be obsolete, inaccurate or wildly out of context, so please bear that in mind :)
             </div>
             <?php
         }
         
    }
    
    /**
     * @desc search all posts and return array of post slugs
     */
    public function search($term){
        $matches = array();
        
        $dir = DATA_ROOT.'/posts/';
		//echo $dir;
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		        while (($file = readdir($dh)) !== false) {
		            //echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
					if(
						(filetype($dir . $file) == 'file') && 
						(substr($file,-4) == '.txt')
					){
						// for each post found
						
						$content = eatStatic::read_file($dir.$file);
						$match_count = substr_count($content,$term);
						if($match_count > 0){
						    $matches[] = array('count'=>$match_count, 'file'=>$file);
						}
						//$matches[] = array('1', $file);
						
					}
		        }
		        closedir($dh);
		    }
		}
        
        // see http://php.net/manual/en/function.array-multisort.php
        
        // sort the array by matches
        // Obtain a list of columns
        foreach ($matches as $key => $row) {
            $count[$key]  = $row['count'];
            $file[$key] = $row['file'];
        }

        // Sort the data with volume descending, edition ascending
        // Add $data as the last parameter, to sort by the common key
        array_multisort($count, SORT_DESC, $file, SORT_ASC, $matches);
        
        return $matches;
    }
    	
}

class eatStaticPaginator {
	var $cat='';
	var $page_size=POSTS_PER_PAGE;
	var $current=1;
	var $partial='skin/global/templates/paginator.php';
	var $total = 0;
	var $pages = 0;
	var $pagination_root = '';

	public function render(){
		if ($this->cat == ''){

    		if($this->total > $this->page_size){
    			$this->pages = ceil($this->total/$this->page_size);

    		}
    		if ($this->pages > 1 ){
    			require ROOT."/".$this->partial;
    		}
    	}
	}
}

class eatStaticBlogPost extends eatStatic {
	var $title;
	var $body;
	var $formatted_body;
	var $data_file_path;
	var $raw_data;
	var $file_name;
	var $slug;
	var $date;
	var $nice_date;
	var $gallery_items = array();
	var $tags=array();
	var $author = BLOG_AUTHOR;
	var $keywords = '';
	var $description = '';
	var $uri;
	var $next_url = '';
	var $prev_url = '';
	
	function hydrate(){
		
		$this->raw_data = $this->read_file($this->data_file_path);
		if($this->raw_data == ''){
			// no post content found
		}
		$parts =  explode("\n", $this->raw_data);
		
		$str = '';
		$format_str = '';
		
		// get title from first line
		$this->title = $parts[0];
		
		$body = true;
		$meta = false;
		
		// the rest is body
		for($i=1; $i<sizeof($parts); $i++){
			
			$str = $str.$parts[$i];
			
			if($i > 1){
				
				// the body section can be the rest of the file,
				// or you can mark the end of the body section with --
				// you can then put meta data fields in the file 
				if(eatStatic::stripLineBreaks($parts[$i]) == '--' && $meta == false){
					$body = false;
					$meta = true;
				}
				
				if($body){
					// formatted body - line breaks need to be replaced with br, but not between html elements
					if(substr($parts[$i],-1) != '>'){
						$format_str = $format_str.$parts[$i]."<br />\n";
					} else {
						$format_str = $format_str.$parts[$i]."\n";
					}
				}
				
				// get meta info
				if($meta && eatStatic::stripLineBreaks($parts[$i]) != '--'){
					//die('meta:'.$parts[$i]);
					if($parts[$i] != ''){
						$this->handleMeta($parts[$i]);
					}
				}
				
			}
			
		}
		
		$this->body = $str;
		$this->formatted_body = $format_str;
		
		$this->file_name = basename($this->data_file_path);
		$this->slug = str_replace('.txt','',$this->file_name);
		$this->date = substr($this->file_name, 0, 10);
		$this->nice_date = date(NICE_DATE_FORMAT, strtotime($this->date));
		$this->timestamp = strtotime($this->date);
		
		// get gallery items if there are any
		$gallery = new eatStaticGallery(str_replace('.txt','/', $this->file_name ));
		$this->gallery_items = $gallery->gallery_items;
		
		// set up the URI
		if(WP_URLS){
		    
		    $date_str = date('Y', strtotime($this->date)).'-'.date('m', strtotime($this->date)).'-'.date('d', strtotime($this->date));
		    
		    $this->uri = SITE_ROOT.date('Y', strtotime($this->date)).'/'.date('m', strtotime($this->date)).'/'.date('d', strtotime($this->date)).'/'.str_replace($date_str .'-','',$this->slug).'/';
		} else {
		    $this->uri = SITE_ROOT.'posts/'.$this->slug.PAGE_EXT;
		}

		// get the next and previous urls
		$blog = new eatStaticBlog();
		$blog->getPostFiles();
		foreach($blog->post_files as $key=>$val){
			if($val == $this->data_file_path){
				if($key > 0){
					$this->prev_url = $this->uriFromFilename(basename($blog->post_files[$key - 1]));
				}
				if($key < (count($blog->post_files)-1)){
					$this->next_url = $this->uriFromFilename(basename($blog->post_files[$key + 1]));
				}
			}

		}
		
	}

	private function uriFromFilename($file_name){
		$post_date = substr($file_name, 0, 10);
		$post_time = strtotime($post_date);
		$post_slug = str_replace('.txt','',$file_name);

		if(WP_URLS){
		    $date_str = date('Y', $post_time).'-'.date('m', $post_time).'-'.date('d', $post_time);
		    $uri = SITE_ROOT.date('Y', $post_time).'/'.date('m', $post_time).'/'.date('d', $post_time).'/'.str_replace($date_str .'-','',$post_slug).'/';
		} else {
		    $uri = SITE_ROOT.'posts/'.$post_slug.PAGE_EXT;
		}

		return $uri;

	}
	
	private function handleMeta($str){
		$parts = explode(":",$str);
		$key = $parts[0];
		$value = $parts[1];
		switch($key){
			case "tags":
				$tags = explode(",", $value);
				foreach($tags as $tag){
				    if(trim($tag) != ''){
					    $this->tags[] = trim($tag);
				    }
				}
			break;
			case "keywords":
				$this->keywords = $value;
			break;
			case "description":
				$this->description = $value;
			break;
		}
	}
	
}


class eatStaticBlogArchiveItem {
	var $month_desc;
	var $month_slug;
}

class eatStaticGallery extends eatStatic {
	var $folder;
	var $thumb_width = 150;
	var $view_width = 700;
	var $gallery_folder;
	var $gallery_items = array();
	var $captions = array();
	var $allowed_extensions = array('JPG','jpg','png');
	
	function __construct($folder, $thumb_width=''){
		$this->folder = $folder;
		$this->gallery_folder = DATA_ROOT.'/images/'.$this->folder;
		if($thumb_width != '') $this->thumb_width = $thumb_width;
		$this->doGallery();
	}
	
	function doGallery(){
		$this->getCaptions();
		$this->getGalleryFiles();
	}
	
	/**
	 *@desc load array of captions from index.txt if it exists
	 */
	private function getCaptions(){
		if (is_dir($this->gallery_folder) && file_exists($this->gallery_folder.'index.txt')){
			$captions = $this->read_file($this->gallery_folder.'index.txt');
			$caption_lines = explode("\n", $captions);
			foreach($caption_lines as $line){
				$parts = explode(":", $line);
				$this->captions[$parts[0]] = trim($parts[1]);
			}		
		}
		//print_r($this->captions);
		//die();
	}	
	
	private function getGalleryFiles(){
		if (is_dir($this->gallery_folder)) {
		    if ($dh = opendir($this->gallery_folder)) {
		        while (($file = readdir($dh)) !== false) {
					
					$ext = end(explode(".", $file));
					
					
					
					$ext = strtolower($ext);
					
						//print_r($this->captions);
						//die();
					//echo $ext;
		            //echo "filename: $file : filetype: " . filetype($this->gallery_folder . $file) . "\n";
					if((filetype($this->gallery_folder . $file) == 'file') && (in_array($ext, $this->allowed_extensions))){
						// for each post found
						$item = new eatStaticGalleryItem;
						$item->ext = $this->getExtension($file);
						$item->source_file_path = $this->gallery_folder . $file;
						$item->thumb_url = "/images/".$this->folder.str_replace('.'.$item->ext, '_'.$this->thumb_width.'.'.$ext , $file);
						$item->view_url = "/images/".$this->folder.str_replace('.'.$item->ext, '_'.$this->view_width.'.'.$ext, $file);
						$file = str_replace($ext, strtolower($ext), $file);
						if(isset($this->captions[$file])){
							$item->caption = $this->captions[$file];						
						}
					
						//$item->caption = $file;
						$this->gallery_items[] = $item;
					}
		        }
		        closedir($dh);
		    }
		}
	}
	
}

class eatStaticGalleryItem {
	var $source_file_path;
	var $thumb_url;
	var $view_url;
	var $title;
	var $caption;
	var $ext;
}

class eatStaticBlogFeed {
	var $blog_title;
	var $blog_link;
	var $blog_description;
	var $pub_date;
	var $items = array();
}

class eatStaticBlogFeedItem {
	var $title;
	var $pub_date;
	var $author;
	var $url;
	var $summary;
	var $formatted_body;
	var $tags=array();
}


?>