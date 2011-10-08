<?php

/**
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */

class eatStaticTag extends eatStatic {
	
	public $name;
	public $items = array();
	public $file_name;
	
	public function getAll(){
		// TODO - read from folder (seperate out), or index file
		$tags = array();
		$dir = DATA_ROOT.'/cache/tags';

		if(is_dir($dir)){
			//echo 'is a dir';
			if ($dh = opendir($dir)) {
		        while (($file = readdir($dh)) !== false) {
		        	//echo "filename: $file : filetype: " . filetype($dir.'/' . $file) . "\n";
					if(
						(filetype($dir.'/'.$file) == 'file') && (substr($file, 0, 1) != ".")
					){
						
						// for each file found
						$ext = end(explode(".", $file));
						$ext = strtolower($ext);
						//die($ext);
						if($ext == 'json'){
							//try {
								$tag = new eatStaticTag;
								$tag->file_name = $file;
								$tag->loadFromFileName();
								$tags[] = $tag;
							//} catch (Exception $e) {
							//}
						}
						
						
					} else {
						//die('not file or started with a dot?');
					}
		        }
		        closedir($dh);
		    }
		}
		
		return $tags;
	}
	
	public function addItem($item){
		if(!in_array($item, $this->items)){
			$this->items[] = $item;
		}
	}
	
	public function removeItem($item){
		// might be a better way to do this
		$new_items = array();
		foreach($this->items as $original){
			if($original != $item){
				$new_items[] = $original;
			}
		}
		$this->items = $new_items;
	}
	
	public function load() {
		$json_file = DATA_ROOT.'/cache/tags/'.$this->fileNameFromName();
		if(file_exists($json_file)){
			$set_data = json_decode($this->read_file($json_file));
			$this->items = $set_data->items;
			$this->file_name = $this->fileNameFromName();
			return true;
		}
	}
	
	public function loadFromFileName() {
		$json_file = DATA_ROOT.'/cache/tags/'.$this->file_name;
		if(file_exists($json_file)){
			$tag_data = json_decode($this->read_file($json_file));
			$this->name = $tag_data->name;
			$this->items = $tag_data->items;
		}
	}
	
	public function save() {
		$json_file = DATA_ROOT.'/cache/tags/'.$this->fileNameFromName();
		if(file_exists($json_file)){
			// TODO make backup - timestamp + username in filename
		}
		eatStatic::write_file(json_encode($this), $json_file);
	}
	
	public function fileNameFromName(){
		$out = str_replace(' ','-', $this->name);
		$out = strtolower($out);
		$out .= '.json';
		return $out;
	}
	
	public function exists(){
		if(file_exists(DATA_ROOT.'/cache/tags/'.$this->fileNameFromName())){
			return true;
		}
	}
	
	public function getSlug(){
		$out = str_replace(' ','-', $this->name);
		$out = strtolower($out);
		return $out;
	}
	
	public function delete(){
		if($this->exists()){
			$file = DATA_ROOT.'/cache/tags/'.$this->fileNameFromName();
			unlink($file);
		}
	}
	
	public function deleteAll(){
		$tags = eatStaticTag::getAll();
		foreach($tags as $tag){
			$tag->delete();
		}
	}
}
?>