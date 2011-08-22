<?php

/**
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */

class eatStaticBlock extends eatStatic {
	
	var $block_file;
	var $content;
	
	function __construct($block){
		if(isset($block)){
			$this->block_file = $block;
		}
	}
	
	function getBlock(){
		// TO DO: this needs to run through eatStaticStorage
		if(file_exists(DATA_ROOT.'/blocks/'.$this->block_file.'.txt')){
			$this->content = $this->read_file(DATA_ROOT.'/blocks/'.$this->block_file.'.txt');
			return '<span class="block block-'.$this->block_file.'">'.$this->content.'</span>';
		}
	}
	
}

?>