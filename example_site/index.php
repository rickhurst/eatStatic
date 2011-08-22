<?php

/**
 * This is a so-called "front-controller" i.e. by default all page loads and "friendly urls" are
 * controlled by the logic in this file.
 * 
 * The "friendly" URL is split into an array and a switch is used to load the appropriate page or script.
 *
 * You don't have to use this if you don't want to - feel free to go old skool and just load
 * pages directly! 
 *
 * However, bear in mind that if you don't use it, the image-cache stuff won't work, amongst other things
 *
 * An alternative is to use specific url_rewrite rules in your .htaccess file
 */

/**
 * load the config file
 */

session_start();

require 'eatStatic_config.php';

/**
 * set up a global variable so we can detect if front controller is being used
 */
define('FRONT_CONTROLLER', "1");

/**
 * get the url, and split the parts into an array
 */
$url = str_replace("?".$_SERVER["QUERY_STRING"],"",$_SERVER["REQUEST_URI"]);

/**
 * to accomodate people who can't use url rewriting, this allows a url to
 * be specified in the format ?p=/here/is/the/url
 */
if(($url == '') && (eatStatic::getValue('p') != '')){
	$url = eatStatic::getValue('p');
}

$path = explode("/",trim($url,"/"));
$path = array_pad($path, 10, "");

/**
 * if this is a password protected app, check user is authenticated here
 */
// if(LOGIN_REQUIRED){
// 	require_once EATSTATIC_ROOT.'/eatStaticUser.class.php';
// 	if(eatStatic::getValue('logged_in','session') != 1){
// 		if(!in_array($path[0], $login_exceptions)){
// 			header('location:'.SITE_ROOT.LOGIN_URL);
// 			die();
// 			//print_r($_SESSION);
// 			//die('not logged in');
// 		}
// 	}
// }

// load user object (not a proper eatStaticUser instance) from session
$user = unserialize(eatStatic::getValue('user','session'));
$stub = '';

try {
	switch($path[0]) { 
		
		/**
		 * home page
		 */
		case "":
		
			$stub = '';
			
			$stub = "page_home.php";
			
		break;
		
		/**
		 * questionnaire
		 */
		case "questionnaire":
			// handover to the questionnaire display controller
			require_once 'application/modules/questionnaire/qneController.class.php';
			new qneController;
		break;

		
		/**
		 * if we haven't found a match yet, try against simple page engine
		 */
		default:
			
			$stub = ""; // in case no other matches are found below, set this so the user gets a 404
			
			/**
			 * simple page engine - see if there is a file named e.g. page_<slug>.php in the root
			 */
			if(eatStatic::slugFormatOk($path[0]) && file_exists(ROOT."/page_".$path[0].".php")){
				$stub = "page_".$path[0].".php";
			}
			
			/**
			 * [TODO]: here is where we could redirect to EatStaticCMS engine 
			 * looking for matching folder paths
			 */

		break;
	}		

} catch (Exception $e) {	
	echo "Error: " . $e->getMessage();
}

/**
 * if we have a stub, require it, otherwise return a 404
 */
if ($stub != ''){
	
	require(ROOT."/".$stub);
} else {
	header("HTTP/1.0 404 Not Found");
	$stub = "404.php";
	require(ROOT."/".$stub);
}

?>
