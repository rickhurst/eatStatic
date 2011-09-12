<?php

class eatStaticSQL {
    
    public function sanitize($sql,$paranoid=1){
      $sanitized = mysql_escape_string($sql);
      // TODO: more stuff
      return $sanitized;
    }

    public function gbl_db_connect($server=DB_SERVER,$username=DB_USERNAME,$password=DB_PASSWORD,$database=DB_DATABASE)
    {

    	$conn = mysql_connect($server, $username,$password);
    	if ($conn){
    		$db = mysql_select_db($database);
    		if(!$db){
    			die('could not select database :'. $database);
    		}
    	} else {
    		die('could not connect to the database :'. $server);
    	}
    }


    public function gbl_db_query($query){

    	//return rows into the specified array
    	$result = mysql_query($query);

    	if($result){
    		return $result;
    	} else {

    		$db_err = "Database error:\n";
    		$db_err.="[".$query."]\n";

    		global $production;

    		if(!$production){
    			die($db_err);
    		} else {
    			die('a database error occured');
    		}

    	}
    }

    public function gbl_db_fetch_array($db_query){
    	return mysql_fetch_array($db_query);
    }

    public function gbl_db_rows($db_query){
    	return mysql_numrows($db_query);
    }
    
}

?>