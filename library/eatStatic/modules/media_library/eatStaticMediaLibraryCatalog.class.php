<?php

/**
 * @desc a class for maintaining a catalog of media library items
 *
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */

class eatStaticMediaLibraryCatalog {
	
	var $catalog = 'media library';
	var $items = array();
	
	/**
	 * @desc adds or updates an item in the index
	 */
	function updateItem($item){
		
		// load existing items
		$this->load();
		
		$itemArray = array(
			'title' => $item->title,
			'id' => $item->id,
			'modified' => $item->modified,
			'state' => $item->state,
			'published' => $item->published,	
			'categories' => $item->categories
		);
		
		//array_push($this->items, $itemArray);
		$this->items[$item->id] = $itemArray;
		// echo "<pre>";
		// print_r($this);
		// echo "</pre>";
		//die();
		
		$this->save();
	}
	
	function removeItem($item){
		$this->load();
		unset($this->items[$item->id]);
		$this->save();
	}
	
	function load(){
		$catalog = eatStaticStorage::retrieve('media_library', 'catalog');
		//print_r($catalog);
		//die();
		if(is_object($catalog) && isset($catalog->items) && is_object($catalog->items)){
			$this->items = get_object_vars($catalog->items);
		} else {
			$this->items = array();
		}
	}
	
	function save(){
		eatStaticStorage::store('media_library', 'catalog', $this);
	}
	
	function getItems($filter=''){
		if($filter == ''){
			return $this->items;
		} else {
			$filtered_items = array();
			//print_r($this->items);
			foreach($this->items as $item){
				if($item->state == $filter){
					$filtered_items[] = $item;
				}
			}
			return $filtered_items;
		}
	}
	
}

?>