<?php

/**
 * @desc turn everything on it's head - for projects where we can't use a data folder
 * we can use a MySQL database table to represent the filesystem instead :-
 * id | dir | filename | data
 * this class is used to perform sql versions of common operations for storing and retrieving files
 */
 
 class eatStaticFakeFS extends eatStaticSQL {
     
     public function store($folder, $object_id, $object){
         
         if (eatStaticFakeFS::recordExists($folder, $object_id)){
             // update
             $sql = "
                 UPDATE ".SQL_FS_TABLE." 
                 SET 
                    data = '".eatStaticFakeFS::sanitize(json_encode($object))."'
                 WHERE
                    dir = '".eatStaticFakeFS::sanitize($folder)."'
                 AND
                    filename = '".eatStaticFakeFS::sanitize($object_id).".json'
              ";
              
              eatStaticFakeFS::gbl_db_query($sql);
              
         } else {
             // create
             $sql = "
                    INSERT INTO ".SQL_FS_TABLE."
                    (
                        dir,
                        filename,
                        data    
                    )
                    VALUES
                    (
                        '".eatStaticFakeFS::sanitize($folder)."',
                        '".eatStaticFakeFS::sanitize($object_id).".json',
                        '".eatStaticFakeFS::sanitize(json_encode($object))."'
                    )
                    
             ";
             
             eatStaticFakeFS::gbl_db_query($sql);
         }
         

     }
     
     public function recordExists($folder, $object_id){
         $sql = "
            SELECT
                COUNT(*) AS total
            FROM
                ".SQL_FS_TABLE."
            WHERE
               dir = '".eatStaticFakeFS::sanitize($folder)."'
            AND
               filename = '".eatStaticFakeFS::sanitize($object_id).".json'
         ";
         
         $query = eatStaticFakeFS::gbl_db_query($sql);
         $row = eatStaticFakeFS::gbl_db_fetch_array($query);
         if($row['total'] != '0'){
             return true;
         }
     
     }
     
     public function retrieve($folder, $object_id){
         $sql = "
            SELECT
                data
            FROM
                ".SQL_FS_TABLE."
            WHERE
                dir = '".eatStaticFakeFS::sanitize($folder)."'
             AND
                filename = '".eatStaticFakeFS::sanitize($object_id).".json'
         ";
         
        $query = eatStaticFakeFS::gbl_db_query($sql);
        $row = eatStaticFakeFS::gbl_db_fetch_array($query);
        $json = $row['data'];
        if($json != ''){ 
            return json_decode($json);
        }
     
     }
     
     public function getFileNames($folder, $ext='json'){
        $sql = "
            SELECT
                filename
            FROM
                ".SQL_FS_TABLE."
            WHERE
                dir = '".eatStaticFakeFS::sanitize($folder)."'
            AND
                filename LIKE '%.".$ext."'
            ORDER BY
                filename
        ";
        $file_names = array();
        $query = eatStaticFakeFS::gbl_db_query($sql);
        while($row = eatStaticFakeFS::gbl_db_fetch_array($query)){
            $file_names[] = $row['filename'];
        }
        
        return $file_names;
        
     }
     
     public function delete($folder, $object_id){
        // maybe this will be changed later to use a delete flag
        // for now it's a real delete
        $sql = "
            DELETE FROM
                 ".SQL_FS_TABLE."
            WHERE
                dir = '".eatStaticFakeFS::sanitize($folder)."'
             AND
                filename = '".eatStaticFakeFS::sanitize($object_id).".json'
        ";
        $query = eatStaticFakeFS::gbl_db_query($sql);
     }
     
     
     private function init(){
         $sql = "
         CREATE TABLE `eatstatic`.`fs` (
         `id` MEDIUMINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
         `dir` VARCHAR( 1000 ) NOT NULL ,
         `filename` VARCHAR( 1000 ) NOT NULL ,
         `data` TEXT NOT NULL
         ) ENGINE = MYISAM ;";
     }
     
 }

?>