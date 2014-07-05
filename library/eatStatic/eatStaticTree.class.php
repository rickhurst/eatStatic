<?php 

/**
 * Used as a sitebuilder based on a nested folder full of pages
 * 
 */

class eatStaticTree extends eatStatic {
	
	var $root = '';
	var $dirList = Array();

	function __construct($root){
		$this->root = $root;
	}

	/**
	 * @desc returns an array of pages based on contents of specified dir
	 * array will primarily be used for menus and submenus
	 * - index.csv specifies order, and will be created if it does not exist
	 * - additional flags can be added to csv as needed (e.g. skip nav, alternative title for menu, redirect)
	 */
	public function getFolder($sub_path){

	}

	/**
	 * the page will be a content file in a folder matching the path
	 *      or /foo/bar/edd/content.md
	 *		or even /foo/bar/edd/content.html
	 *		HTML pages with a filename starting with _ are assumed to be partials
	 *		if not, full HTML pages
	 *
	 *		markdown pages are partials, using a default base template
	 *		or a custom base template specified in meta
	 * 
	 */
	public function getPage($sub_path){

		require_once(EATSTATIC_ROOT."/eatStaticPage.class.php");

		$page = new eatStaticPage();

		if(file_exists($this->root.$sub_path.".md")){
			$raw_content = $this->read_file($this->root.$sub_path.".md");
			$ext = "md";
		} else {
			return;
		}

		switch($ext){
			case "md":
				// extract meta
				$split_content = explode('--', $raw_content);
				if(sizeOf($split_content) > 1){
					$raw_meta = $split_content[1];
				}
				// process remainder and return
				require_once(LIB_ROOT."/php-markdown/Markdown.inc.php");
				$page->content = Michelf\Markdown::defaultTransform($split_content[0]);

			break;
			case "html":
				// TODO: get first char of filename to see if it is a partial
				// TODO: return as whole page, or embedded in base template
			break;
		}

		return $page;

	}

}

?>