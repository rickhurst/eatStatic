<?php
require '../eatStatic_config.php';

// check data folder exists
if(file_exists(DATA_ROOT)){
	echo 'Data folder exists at: '.DATA_ROOT.'<br />';
} else {
	echo 'Data folder does not exist at: '.DATA_ROOT.'<br />';
}

// check data folder is writable
if(eatStatic::write_file('setup test (written by /scripts/setup.php)', DATA_ROOT.'/.setup-test.txt')){
	echo 'Data folder is writeable <br />';
} else {
	echo 'Data folder is not writeable <br />';
}

if(unlink(DATA_ROOT.'/.setup-test.txt')){
	echo 'Data folder content can be deleted <br />';
}

// check cache folder exists
if(file_exists(DATA_ROOT.'/cache')){
	echo 'Cache folder exists <br />';
} else {
	echo 'Cache folder does not exist - creating.. <br />';
	if(mkdir(DATA_ROOT.'/cache', 0775)){
		echo 'Cache folder created <br />';
	}
}

// check cache/tags folder exists
if(file_exists(DATA_ROOT.'/cache/tags')){
	echo 'Tag cache folder exists <br />';
} else {
	echo 'Tag cache folder does not exist - creating.. <br />';
	if(mkdir(DATA_ROOT.'/cache/tags', 0775)){
		echo 'Cache folder created <br />';
	}
}

// check cache/tags folder is writeable
?>
