<?php

/**
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */

class eatStaticBlock extends eatStatic {
	
	var $block_file;
	var $content;
	var $raw_content;
	
	function __construct($block){
		if(isset($block)){
			$this->block_file = $block;
		}
	}
	
	function getBlock(){
		// TO DO: this needs to run through eatStaticStorage
		if(file_exists(DATA_ROOT.'/blocks/'.$this->block_file.'.txt')){
			$this->content = $this->read_file(DATA_ROOT.'/blocks/'.$this->block_file.'.txt');
			
		}
		if(file_exists(DATA_ROOT.'/blocks/'.$this->block_file.'.md')){
			$this->raw_content = $this->read_file(DATA_ROOT.'/blocks/'.$this->block_file.'.md');
			require_once(LIB_ROOT."/php-markdown/Markdown.inc.php");
			$this->content = Michelf\Markdown::defaultTransform($this->raw_content);
		}
		return '<span class="block block-'.$this->block_file.'">'.$this->content.'</span>';
	}
	
}

?>