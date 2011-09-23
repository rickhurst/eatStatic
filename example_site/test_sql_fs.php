<?php

eatStaticFakeFS::gbl_db_connect();

class case_study {
    var $id;
    var $title;
    var $body_text;
    var $skills = array();
}

$case_study = new case_study;
$case_study->id = 'my_case_study';
$case_study->title = 'My case study';
$case_study->body_text = "Some text for the case study it's got an apostrophe! and <b>HTML</b>";
$case_study->skills['css'] = 'CSS';
$case_study->skills['sitebuild'] = 'Site Build';

eatStaticStorage::store('case_studies', 'my_case_study', $case_study);

$case_study2 = eatStaticStorage::retrieve('case_studies', 'my_case_study');

print_r($case_study2);

echo $case_study2->body_text;

print_r(eatStaticStorage::getFileNames('case_studies'));

eatStaticStorage::delete('case_studies', 'my_case_study');


?>