<?php
/**
 * @desc eatStatic base class - helper functions and 
 * common stuff that might be used across any site or application
 * note: there is nothing revolutionary in here, just handy stuff
 * that I tend to use frequently, so gets copied from project to project.
 *
 * This class is usually extended by other files in eatStatic framework, so 
 * the methods are conveniently available. At the very least this class can be used 
 * on it's own to provide these helpers
 *
 * @version 0.1.3
 * 2011-07-13 - Rick Hurst added notes version number 0.1.0 
 * 2011-08-19 - Rick Hurst changed read_file() to use file_get_contents()
 *              Due to bug with missing last few characters off a file
 * 2011-08-24 - Rick Hurst added getFileType()
 * 2011-09-05 - Rick Hurst updated block() to use EATSTATIC_ROOT 
 * 2011-09-09 - Rick Hurst added option to use array in selected()
 * 2011-09-12 - Rick Hurst merged 2011-09-09 changes from another project
 *                          added uri() method
 */

class eatStatic {
	
	/**
	 * @desc checks that a slug only contains letters, numbers, hypens and underscores
	 */
	public function slugFormatOK($str){
		if (preg_match('/^[a-zA-Z0-9_-]+$/',$str)){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @desc checks that a file name only contains letters, numbers, hypens, underscores and dots
	 */
	public function fileNameOK($str){
		if (preg_match('/^[a-zA-Z0-9._-]+$/',$str)){
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @desc read contents of specified file
	 */
	function read_file($path){
		if(file_exists($path)){
            // $handle = fopen($path,'r');
            // $str = fread($handle, filesize($path));
            // return $str;
            // fclose($handle);
            return file_get_contents($path);
		}
	}
	
	/**
	 * @desc writes file containing specified string
	 */
	function write_file($str, $path){
		$fh = fopen($path, 'w') or die("can't open file");
		fwrite($fh, $str);
		fclose($fh);
		return true; // TODO: make this actually check/ gather errors
	}
	
	/**
	 * @desc returns extension of provided filename
	 */
	function getExtension($filename){
		$path_info = pathinfo($filename);
		return $path_info['extension'];
	}
	
	/**
	 * @desc return file type based on extension
	 */
	function getFileType($filename){
	    switch(strtolower(eatStatic::getExtension($filename))){
	        case "jpg":
	            $type = 'image/jpeg';
	        break;
	        case "gif":
	            $type = 'image/gif';
	        break;
	        case "png":
	            $type = 'image/png';
	        break;
	        case "mov":
	            $type = 'video/quicktime';
	        break;
	    }
	    return $type;
	}

	/**
	 * @desc Take a value and force it to be an integer (defaulting to zero, if it can't be converted).
	 */
	function forceInt($inValue, $defaultValue) {
		$iReturn = intval($inValue);
		return ($iReturn == 0) ? $defaultValue : $iReturn;
	}
	
	/**
	 * @desc convenience method for getting vars from post, cookies, and querystring
	 * hat-tip: this is adapted from a method copied from Craig Francis
	 */
	function getValue($variable, $method = 'request', $validation = 0) {

		$value = '';
		$method = strtolower($method);

		if ($method == 'post') {

			if (isset($_POST[$variable])) {
				$value = $_POST[$variable];
			}

		} elseif ($method == 'cookie') {

			if (isset($_COOKIE[$variable])) {
				$value = $_COOKIE[$variable];
			}

		} elseif ($method == 'request') {

			if (isset($_REQUEST[$variable])) {
				$value = $_REQUEST[$variable];
			}
			
		} elseif ($method == 'session') {

			if (isset($_SESSION[$variable])) {
				$value = $_SESSION[$variable];
			}

		} else {

			if (isset($_GET[$variable])) {
				$value = $_GET[$variable];
			}

		}

		return $value;
	}
	
	/**
	 * @desc converts a string (such as a page title) into something suitable to use
	 * as a URL slug
	 */
	function slugify($str){
		if($str != ''){
			$str = strtolower($str);
			$str = str_replace(" ","-", $str);
			// TODO handle special chars
		}
		return $str;
	}
	
	/**
	 * @desc convenience method to return a block
	 */
	public function block($block){
		require_once(EATSTATIC_ROOT."/eatStaticBlock.class.php");
		$block = new eatStaticBlock($block);
		return $block->getBlock();
	}
	
	/**
	 * @desc check that the front controller variable is set, or return a 404
	 */
	public function checkFront(){
		if(FRONT_CONTROLLER != "1"){
			header("HTTP/1.0 404 Not Found");
			$stub = "404.php";
			require(ROOT."/".$stub);
			die();
		}	
	}
	
	/**
	 * @desc creates a random alphanumeric string
	 */
	function createRandomString($len=10) {
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$pass = '' ;
		while ($i <= $len) {
		    $num = rand() % 33;
		    $tmp = substr($chars, $num, 1);
		    $pass = $pass . $tmp;
		    $i++;
		}
		return $pass;
	}
	
	/**
	 * @desc returns the current date/ datetime in specified format
	 */
	function current_date($format='mysqldatetime'){
		if ($format == 'mysqldatetime'){
			return date("Y-m-d H:i:s");
		}
		// TO DO: other formats
	}
	
	/**
	 * @desc used in forms for deciding if a checkbox should be pre-checked or not
	 * the second value can be an array
	 */
	function checked($val1, $val2){
		if(is_array($val2)){
			foreach($val2 as $val){
				if($val1 == $val){
					return 'checked="checked"';
				}
			}
		}
		if($val1 == $val2){
			return 'checked="checked"';
		}
	}
	
	/**
	 * @desc used in forms to decide if a select list option is pre selected
	 * second value can be array
	 */
	function selected($val1, $val2){
	    if(is_array($val2)){
			foreach($val2 as $val){
				if($val1 == $val){
					return 'selected="selected"';
				}
			}
		}
		if($val1 == $val2){
			return 'selected="selected"';
		}
	}
	
	/**
	 * makes a serialized Array received from ajax post 
	 * e.g. foo[0][name] = x
	 *      foo[0][value] = 1
	 * into a normal key val array e.g. foo[x] = 1;
	 */
	function makeKeyVal($arr){
		$out = array();
		foreach($arr as $item){
			//echo $key;
			foreach($item as $key=>$val){
				if($key == 'name'){
					$name = $val;
				}
				if($key == 'value'){
					$value = $val;
				}
			}
			$out[$name] = $value;
		}
		return $out;
	}
	
	/**
	 * * makes a serialized Array received from ajax post 
	 * e.g. foo[0][name] = x
	 *      foo[0][value] = 1
	 * into a normal array e.g. array(1);
	 */
	function makeNormalArray($arr){
		$out = array();
		if(is_array($arr)){
    		foreach($arr as $item){
    			//echo $key;
    			foreach($item as $key=>$val){
    				if($key == 'value'){
    					$value = $val;
    				}
    			}
    			$out[] = $value;
    		}
	    }
		return $out;
	}
	
	/**
	 * @desc return current URI - on proxied setups this may need
	 * some logic adding
	 */
	public function uri(){
	    return $_SERVER['REQUEST_URI'];
	}

	public function stripLineBreaks($str){
		if ($str != ''){
			return str_replace(array("\r\n", "\n", "\r"), '',$str);
		} else {
			return '';
		}
	}
	

	
}

?>
