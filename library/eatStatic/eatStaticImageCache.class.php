<?php
/**
 * @desc image cache class - ideas taken from:-
 * http://icant.co.uk/articles/phpthumbnails/
 * http://www.design-ireland.net/article/Implementing_an_Image_Cache_for_PHP_GD
 *
 * @version 0.1.1
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 * 2011-09-23 - Rick Hurst added option image cache folder to construct
 *                         upped version to 0.1.1
 */

class eatStaticImageCache  extends eatStatic {
	
	var $source_folder;
	var $source_file_name;
	var $source_path;
	var $width = 150;
	var $height = 0;
	var $cache_file_name;
	var $image_cache_folder = 'image-cache';
	var $cache_sub_folder;
	var $allowed_widths = array(150,400,500,600,700); // specify to stop people monkeying with urls
	var $extension;
	var $out_extension; // the extension after conversion e.g. .Jpeg will become .jpg
	var $allowed_extensions = array('jpg','jpeg','png');
	var $type; //jpg or png;
	var $content_type;

	
	function __construct($source_folder='', $source_file_name, $width, $cache_sub_folder, $image_cache_folder=''){
	    
	    if($image_cache_folder != ''){
	        $this->image_cache_folder = $image_cache_folder;
	    }

		if($source_folder !=''){
			$this->source_folder = $source_folder;
			$this->source_file_name = $source_file_name;
			$this->extension = $this->getExtension($source_file_name);
			if(in_array(strtolower($this->extension),$this->allowed_extensions)){
				switch(strtolower($this->extension)){
					case 'jpg':
						$this->type = 'jpg';
						$this->out_extension = 'jpg';
						$this->content_type = 'image/jpeg';
					break;
					case 'jpeg':
						$this->type = 'jpg';
						$this->out_extension = 'jpg';
						$this->content_type = 'image/jpeg';
					break;
					case 'png':
						$this->type = 'png';
						$this->out_extension = 'png';
						$this->content_type = 'image/png';
					break;
				}
				
				$this->source_path = $this->source_folder.$this->source_file_name;
				
				$this->width = $this->forceInt($width, 150);
				if(in_array($this->width, $this->allowed_widths)){
					$this->cache_sub_folder = $cache_sub_folder;
					$this->cache_file_name = str_replace('.'.$this->extension, '_'.$width.'.'.$this->out_extension, $source_file_name);
					$this->image_path = ROOT.'/'.$this->image_cache_folder.'/'.$this->cache_sub_folder.'/'.$this->cache_file_name;
				//die($this->image_path);				
					$this->getImage();
				} else {
					$this->sendErrorImg();
				}
			} else {
				// return default image?
				//exit('invalid extension');
				$this->sendErrorImg();
			}
		}
	}
	
	function getImage(){
	    
        // echo $this->image_path;
        // die();
		
		header('Content-type: '.$this->content_type);
		if (file_exists($this->image_path)) {

		    
			// send the cached image to the output buffer (browser)
		    readfile($this->image_path);
		
		}else{
		
			//TODO: check orientation from exif data
			// and rotate if necessary
			//http://stackoverflow.com/questions/3657023/how-to-detect-shot-angle-of-photo-and-auto-rotate-for-website-display-like-deskt

		
		    // create a new image using GD functions
			if(!file_exists($this->source_path)){
				// try looking for the same file with an uppercase extension
				$this->source_path = str_replace($this->extension, strtoupper($this->extension), $this->source_path);
				//die('source:'.$this->source_path);
			}
			
			
			if(file_exists($this->source_path)){
				
				//die('source:'.$this->source_path);
				
				 if($this->type == 'jpg'){
				 	// the original image
				 	$src_img = ImageCreateFromJPEG($this->source_path);
				 }
				
				 if($this->type == 'png'){
				 	$src_img = ImageCreateFromPNG($this->source_path);
				 }
				//[TODO] - error handling - return placeholder image if above fails
		
				// get original image dimensions
				$old_x=imageSX($src_img);
				$old_y=imageSY($src_img);
			
				if($old_x >= $old_y){
			
					// landscape/square - rescale to specified width
					$percent_height = $old_y/$old_x*100;
					$new_x=$this->width;
					$new_y=$this->width*$percent_height/100;
				
				} 

				if($old_x < $old_y){
			
					// portrait - calculate rescale
					$percent_height = $old_x/$old_y*100;
					$new_y=$this->width;
					$new_x=$this->width*$percent_height/100;
					
					// to suit thumbnail galleries rescale so that 
					// height matches height of a landscape thumbnail
					// TODO: make this optional
					$new_y = $new_x;
					$new_x = $new_x*$percent_height/100;
				
				}


			    // the new image we will create with GD to the new dimensions
			    $new_image = ImageCreateTrueColor($new_x,$new_y);

			    // copy and re-sample the original image to make the new one
			    ImageCopyResampled($new_image, $src_img, 0, 0, 0, 0, $new_x, $new_y, $old_x, $old_y);
				
				
			    // send the new image to the browser
				if($this->type == 'jpg'){
					//print 'yep, jpg';
					//die();
					ImageJPEG($new_image);
				}
				
				if($this->type == 'png'){
					ImagePNG($new_image);
				}
				
				
					
				// check gallery directory exists in cache
				if(!file_exists(ROOT.'/'.$this->image_cache_folder.'/'.$this->cache_sub_folder.'/')){
					// create it
					mkdir(ROOT.'/'.$this->image_cache_folder.'/'.$this->cache_sub_folder.'/');
				}
				
				// now save a copy of the new image to the cache directory
			    if($this->type == 'jpg'){
			    	ImageJPEG($new_image, $this->image_path);
				 }
				 
				 if($this->type == 'png'){
					ImagePNG($new_image, $this->image_path);
				}
				 
			    // destroy the image in memory to free up server resources
			    ImageDestroy($new_image);
		
			} else {
				
				//die('source image not found: '.$this->source_path);
				
				$this->sendErrorImg();
				
			}
		}
	}
	
	function sendErrorImg(){
		
		// send 404
		header("HTTP/1.0 404 Not Found");
		//header("location:404");
		include ROOT.'/404.php';
		die();
		
		// send generated image
		// $this->width = forceInt($this->width, 150);
		// $new_w=$this->width;
		// $new_y=$this->width*(3/4);
		// 	    $new_image = ImageCreateTrueColor($new_w,$new_y);
		// ImageJPEG($new_image);
		// ImageDestroy($new_image);
	}
	
	/**
	 * @desc convenience method to get a link to cached image
	 */
	function imgLink($filename, $path, $width){
		$cached_filename = str_replace('.'.eatStatic::getExtension($filename),'_'.$width.'.'.strtolower(eatStatic::getExtension($filename)), $filename);
		return $path.$cached_filename;
	}
	
}

?>