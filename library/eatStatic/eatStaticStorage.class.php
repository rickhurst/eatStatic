<?php
/**
 * @desc this class handles storage of objects,
 *	this paves the way for different types of storage e.g. disk vs relational db vs mongo
 *
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */

class eatStaticStorage extends eatStatic {
	
	public function store($folder, $object_id, $object){
		
		if(STORAGE_TYPE == 'ES_JSON'){
		
			$file_path = DATA_ROOT.'/'.$folder.'/'.$object_id.'.json';
		
			if(SNAPSHOT && file_exists($file_path)){
			
				// check for snapshot sub directory
				if(!is_dir(DATA_ROOT.'/'.$folder.'/snapshots/')){
					mkdir(DATA_ROOT.'/'.$folder.'/snapshots/');
				}
			
				// check for snapshot directory named as per file
				$snapshot_folder = DATA_ROOT.'/'.$folder.'/snapshots/'.$object_id;
				if(!is_dir($snapshot_folder)){
					mkdir($snapshot_folder, 0775);
				}
				$snapshot_path = $snapshot_folder.'/'.date("Y-m-d-His").'.json';
			
				// take a copy of the existing file
				copy($file_path, $snapshot_path);
			}
		
			// write file out to filesystem
			if(eatStatic::write_file(json_encode($object), $file_path)){
				return true;
			}
		
		}
	}
	
	public function recordExists($folder, $object_id){
		$file_path = DATA_ROOT.'/'.$folder.'/'.$object_id.'.json';
		if(file_exists($file_path)){
			return true;
		}
	}
	
	public function retrieve($folder, $object_id){
		
		global $err;
		
		if(STORAGE_TYPE == 'ES_JSON'){
			if(eatStaticStorage::recordExists($folder, $object_id)){
				$json = eatStatic::read_file(DATA_ROOT.'/'.$folder.'/'.$object_id.'.json');
				return json_decode($json);
			} else {
				$err->add('STORAGE', 'specified file does not exist');
			}
		}
	}
	
	public function newID(){
		//$str = DATA_ROOT.'/'.$folder.'/';
		//$str = tempnam(DATA_ROOT.'/'.$folder.'/', 'foo');
		$str = strtoupper(date('Y-m-d-His').'-'.eatStatic::createRandomString(5));
		return $str;
	}
	
	/**
	 * @desc return an array of file paths for specified data sub dir
	 */
	public function getFileNames($folder){
		$file_names = array();
		$dir = DATA_ROOT.'/'.$folder.'/';
		//echo $dir;
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		        while (($file = readdir($dh)) !== false) {
		            //echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
					if(
						(filetype($dir . $file) == 'file') && 
						(substr($file,-4) == "json")
					){
						// for each post found
						$file_names[] = $file;
					}
		        }
		        closedir($dh);
		    }
		}
		return ($file_names);
	}
	
	public function delete($folder, $object_id){
		if(STORAGE_TYPE == 'ES_JSON'){
			rename(DATA_ROOT.'/'.$folder.'/'.$object_id.'.json', DATA_ROOT.'/deleted_'.$folder.'/'.$object_id.'.json');
		}
	}
	
}

?>
