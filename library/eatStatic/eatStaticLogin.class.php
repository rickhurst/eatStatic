<?php

/**
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */

class eatStaticLogin extends eatStatic {
	
	function __construct(){
		if($this->getValue('postback','post') == "1"){
			
			// TODO: CSRF check
			
			$this->doLogin();
			
		}
	}
	
	private function doLogin(){
		global $err;
		
		// reset any existing session vars relating login
		$_SESSION['logged_in'] = '';
		$_SESSION['user'] = '';
		
		$user = new eatStaticUser;
		$user->username = $this->getValue('username','post');
		$user->password = $this->getValue('password','post');
		
		// check format of username and password is OK before authenticating
		if($user->usernameOK($user->username) && $user->passwordOK($user->password)){
			
			if($user->userAuthenticates($user)){
				
				// set logged in session var
				$_SESSION['logged_in'] = 1;
				
				// load user data
				$stored_user = $user->load($user->username);
				
				$user->teams = $stored_user->teams;
				$user->roles = $stored_user->roles;
				
				$_SESSION['user'] = serialize($user);
				
				header('location:'.SITE_ROOT);
				die();
				
				
			} else {
				$err->add('LOGIN', 'The provided login details were invalid');
			}
			
		} else {
			$err->add('LOGIN', 'The format of the username or password were invalid');
		}
		
		// if($err->exists()){
		// 	$err->printOut();
		// }
		// 
		// die();
	}
	
	public function doLogout(){
		$_SESSION['logged_in'] = '';
		$_SESSION['user'] = '';
		header('location:'.SITE_ROOT.'/login');
	}
	

	

	
}

?>