<?php 

class eatStaticImageCacheController {


	function __construct(){

		global $stub, $path, $file_name, $gallery, $width, $url;

		switch($path[1]){
			case "":
				/**
				 * this should be a folder, so if it isn't there, return page not found
				 */
				$stub = "";
			break;
			default:
				switch($path[2]){

					case "":
						$stub = "";
					break;
					default:
						
						/**
						 * this should be a filename
						 */
						if(!eatStatic::fileNameOK($path[2])){
							$stub = "";
						} else {
						
							/**
							 * images URL's are expected to be in format:-
							 * /images/(galleryname)/(filename)_(width).jpg
							 * e.g. /images/misc/mypic_500.jpg
							 */
							if(preg_match('|^/images/([^/.]+)/([^/]+)_([0-9]+).([^/]+)|', $url, $matches)) {
								//print_r($matches);
								$file_name = $matches[2].'.'.$matches[4];
								$gallery = $matches[1];
								$width = $matches[3];
								//print_r($matches);
								//die('ok');
								$stub = "scripts/image_cache.php";
							} else {
								$stub = "";
								//die('here');
							}
						
						}
						
						
					break;
					
					// /scripts/image_cache.php?file_name=$2.$4&gallery=$1&width=$3
				}
			break;
		}

	}

}

?>