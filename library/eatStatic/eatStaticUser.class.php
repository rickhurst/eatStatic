<?php

/**
 * @version 0.1.1
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 * 2011-09-12 - Rick Hurst add loadFromId()
 */

class eatStaticUser  extends eatStatic {
	
	public $username;
	public $password;
	public $password_hash;
	public $fullname;
	public $teams = array();
	public $roles = array();
	
	/**
	 * @desc checks that a username only contains letters, numbers, hypens, underscores and dots
	 */
	public function usernameOK($str){
		if (preg_match('/^[a-zA-Z0-9._-]+$/',$str)){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @desc checks that a password only contains letters, numbers, hypens, underscores and dots
	 */
	public function passwordOK($str){
		if (preg_match('/^[a-zA-Z0-9._-]+$/',$str)){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @desc checks that username and password of provided user match those in user store
	 */
	public function userAuthenticates($user){
		global $err;
		$stored_user = $this->load($user->username);
		if($stored_user){
			if($stored_user->password_hash == md5($user->password)){
				return true;
			} else {
				$err->add('USER', 'The password was incorrect');
			}
		} else {
			$err->add('USER', 'No user data could be found for the specified username');
		}
	}
	
	/**
	 * @desc returns a decoded user instance from stored JSON (not a full eatStaticUser instance)
	 */
	public function load($username){
		$user = eatStaticStorage::retrieve('users', $username);
		return $user;
	}
	
	/**
	 * @desc hydrates the current eatStaticUser
	 */
	public function loadFromId($username){
	    $stored_data = eatStaticStorage::retrieve('users', $username);
	    $this->fullname = $stored_data->fullname;
	    $this->teams = $stored_data->teams;
	    $this->roles = $stored_data->roles;
	    $this->username = $stored_data->username;
	}
	
	/**
	* @desc creates a new user record
	*/
	public function create(){
		
		global $err;
		
		// make hash of password and remove password value
		$this->password_hash = md5($this->password);
		$this->password = '';
		
		//$json_file = DATA_ROOT.'/users/'.$this->username.'.json';
		if(!eatStaticStorage::recordExists('users', $this->username.'.json')){
			
			//$this->write_file(json_encode($this), $json_file);
			eatStaticStorage::store('users', $this->username, $this);
		} else {
			$err->add('USER', 'username already exists');
		}
		
	}
	
	/**
	 * @desc add a string to the teams array
	 */
	public function addTeam($str){
		$this->teams[] = $str;
	}
	
	/**
	 * @desc add a string to the roles array
	 */
	public function addRole($str){
		$this->roles[] = $str;
	}
}
?>