<?php

/**
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */

class eatStaticPage {
	
	public $id; // analagous to slug
	public $type; // map type to XML/ other human editable schema to pre-populate fields
	public $title;
	
	public $created;
	public $modified;

	// each field is an array, and key = field name e.g.:-
	// $this->fields['body'] = array('type' => 'textarea', 'widget' => 'HTML', 'value' => '<p>.....</p>');
	// $this->fields['skills used'] = array('type' => 'list', 'value' => array('CSS','HTML','PHP'));
	// $this->fields['intro'] = array('type' => 'textarea', 'value' => '<p>This is an example</p>');
	
	public $fields = array();
}
?>