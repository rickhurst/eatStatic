<?php 

/**
 * reads a directory tree and returns contained text file as
 * as page, along with a list of sister pages
 * structure is recorded in json file, so order can be manipulated
 */

class eatStaticTree extends eatStatic {
	
	var $root = '';

	function __construct($root){
		$this->root = $root;
	}

	public function getPage($sub_path){
		/**
		 * the page will be a content file in a folder matching the path
		 * e.g. /foo/bar/egg/content.txt
		 * 
		 */
	}

}

?>