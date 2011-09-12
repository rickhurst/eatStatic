<?php

/**
 * one json file per team, listing users. 
 * user objects also list team for quick lookup in either direction
 */

class eatStaticTeam {
    public $id;
    public $title;
    public $users = array();
    
    public function loadFromId(){
        $stored_data = eatStaticStorage::retrieve('teams', $this->id);
        if(isset($stored_data->title)){
            $this->title = $stored_data->title;
        }
        if(isset($stored_data->users)){
            $this->users = $stored_data->users;
        }
    }
    
    public function addMember($username){
        if(!in_array($username, $this->users)){
            $this->users[] = $username;
        }
    }
    
    public function save(){
        eatStaticStorage::store('teams', $this->id, $this);
    }
    
    public function getAll(){
        $team_ids = eatStaticStorage::getAll('teams');
        $teams = array();
        foreach($team_ids as $id){
            $team = new eatStaticTeam;
            $team->id = $id;
            $team->loadFromId();
            $teams[] = $team;
         }
         return $teams;
    }
}

?>