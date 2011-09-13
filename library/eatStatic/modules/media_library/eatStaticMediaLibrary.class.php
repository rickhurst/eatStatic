<?php

/**
 * @desc media library
 *
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */

class eatStaticMediaLibrary {
	
	
	/**
	 * @desc returns an array of media library items
	 */
	function getItems($refs){
		require_once EATSTATIC_ROOT.'/modules/media_library/eatStaticMediaLibraryItem.class.php';
		$items = array();
		foreach($refs as $id=>$filename){
			$item = new eatStaticMediaLibraryItem;
			$item->filename = $filename;
			$item->id = $id;
			$item->loadFromId();
			$items[] = $item;
		}
		return $items;
		print_r($items);
	}
}

?>