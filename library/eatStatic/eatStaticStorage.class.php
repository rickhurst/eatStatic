<?php
/**
 * @desc this class handles storage of objects,
 *	this paves the way for different types of storage e.g. disk vs relational db vs mongo
 *
 * @version 0.1.3
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 * 2011-08-19 - Rick Hurst added getCatalogs method
 * 2011-09-05 - Rick Hurst extension parameter added to getFileNames()
 * 2011-09-08 - Rick Hurst added storage type check to recordExists
 *                         added getAll()
 * 2011-09-12 - Rick Hurst merged changes from another project
 *                         added some logic to use eatStaticFakeFS if necessary
 */

class eatStaticStorage extends eatStatic {
	
	public function store($folder, $object_id, $object){
		
		if(STORAGE_TYPE == 'ES_JSON'){
		    
		    if(SQL_FS){
		        eatStaticFakeFS::store($folder, $object_id, $object);
		    } else {
		
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
	}
	
	public function recordExists($folder, $object_id){
	    if(STORAGE_TYPE == 'ES_JSON'){
    		$file_path = DATA_ROOT.'/'.$folder.'/'.$object_id.'.json';
    		if(file_exists($file_path)){
    			return true;
    		}
	    }
	}
	
	public function retrieve($folder, $object_id){
		
		global $err;
		
		if(STORAGE_TYPE == 'ES_JSON'){
		    
		    if(SQL_FS){
		        return eatStaticFakeFS::retrieve($folder, $object_id);
		    } else {
		    
    			if(eatStaticStorage::recordExists($folder, $object_id)){
    				$json = eatStatic::read_file(DATA_ROOT.'/'.$folder.'/'.$object_id.'.json');
    				return json_decode($json);
    			} else {
    				$err->add('STORAGE', 'specified file does not exist');
    			}
			
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
	public function getFileNames($folder, $ext='json'){
	    if(STORAGE_TYPE == 'ES_JSON'){
	        if(SQL_FS){
		        return eatStaticFakeFS::getFileNames($folder);
		    } else {
        		$file_names = array();
        		$dir = DATA_ROOT.'/'.$folder.'/';
        		
        		if (is_dir($dir)) {
        		    if ($dh = opendir($dir)) {
        		        while (($file = readdir($dh)) !== false) {
        		            
        					if(
        						(filetype($dir . $file) == 'file') && 
        						(substr($file,-4) == $ext)
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
	    }
	}
	
	/**
	 * return an array of object id's for specified folder
	 */
	public function getAll($folder, $ext='json'){
	    $items = array();
	    if(STORAGE_TYPE == 'ES_JSON'){
	        $files = eatStaticStorage::getFileNames($folder);
	        
	        foreach($files as $file){
	            $items[] = substr($file, 0, -5);
	        }
	    }
	    return $items;
	}
	
	public function delete($folder, $object_id){
		if(STORAGE_TYPE == 'ES_JSON'){
		    if(SQL_FS){
		        eatStaticFakeFS::delete($folder, $object_id);
		    } else {
			    rename(DATA_ROOT.'/'.$folder.'/'.$object_id.'.json', DATA_ROOT.'/deleted_'.$folder.'/'.$object_id.'.json');
		    }
		}
	}
	
	/**
	 * @desc return a list of catalogs for specified data store
	 */
	public function getCatalogs($folder){
        if(STORAGE_TYPE == 'ES_JSON'){
            $files = eatStaticStorage::getFilenames($folder.'/catalog');
            $items = array();
            foreach($files as $file){
                // remove .json from end and stick in items array
                $items[] = substr($file, 0, -5);
            }
            return $items;
        }
	}
	
}

?>
