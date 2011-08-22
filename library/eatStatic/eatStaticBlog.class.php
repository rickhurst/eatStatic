<?php

/**
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */



class eatStaticBlog extends eatStatic {
	
	var $post_folder;
	var $recent_limit = 10;
	var $post_files = array();
	
	public function getPostFiles(){
		
		if(USE_CACHE){
			// see if cache file exists
			if(file_exists(DATA_ROOT.'/cache/all_posts.json')){
				$this->post_files = json_decode(eatStatic::read_file(DATA_ROOT.'/cache/all_posts.json'));
			} else {
				// load posts from disk
				$this->getPostFilesFromDisk();
				
				// write array of post files to disk as JSON
				eatStatic::write_file(json_encode($this->post_files), DATA_ROOT.'/cache/all_posts.json');
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
						($post_count < $this->recent_limit) &&
						(substr($file,-3) == "txt")
					){
						// for each post found
						$this->post_files[] = $this->post_folder . $file;
					}
		        }
		        closedir($dh);
		    }
		}
	}
	
	public function getRecentPosts(){
		
		$posts = array();
		//$post_count = 0;
		
		if(USE_CACHE){
			// see if cache file exists
			if(file_exists(DATA_ROOT.'/cache/recent_files.json')){
				$recent_files = json_decode($this->read_file(DATA_ROOT.'/cache/recent_files.json'));
			} else {
				$recent_files = $this->getRecentPostsArray();
				$this->write_file(json_encode($recent_files), DATA_ROOT.'/cache/recent_files.json');
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
				$items[] = $item;
			}
			$last_month = $current_month;	
		}
		return $items;
	}
	
	public function getArchiveList($month_slug){
		$this->getPostFiles();
		$posts = array();
		//echo '['.$month_slug.']';
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
	
	function hydrate(){
		
		$this->raw_data = $this->read_file($this->data_file_path);
		if($this->raw_data == ''){
			// no post content found
		}
		$parts =  split("[\n|\r]", $this->raw_data);
		
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
				if($parts[$i] == '--' && $meta == false){
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
				if($meta && $parts[$i] != '--'){
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
		
		// get gallery items if there are any
		$gallery = new eatStaticGallery(str_replace('.txt','/', $this->file_name ));
		$this->gallery_items = $gallery->gallery_items;
		
	}
	
	private function handleMeta($str){
		$parts = explode(":",$str);
		$key = $parts[0];
		$value = $parts[1];
		switch($key){
			case "tags":
				$tags = explode(",", $value);
				foreach($tags as $tag){
					$this->tags[] = trim($tag);
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