<?php

//require_once '../eatStatic_config.php';
require EATSTATIC_ROOT.'/eatStaticImageCache.class.php';

//die($_SERVER['QUERY_STRING']);

// $file_name = getValue('file_name');
// $gallery = getValue('gallery');
// $width = getValue('width');

$source_file_name = $file_name;
$source_folder = DATA_ROOT.'/images/'.$gallery.'/';
$image_cache_sub_folder = $gallery;
$image_cache_folder = 'images';

if($file_name != '' && $gallery != '' && $width != ''){
    //die('here');

	new eatStaticImageCache($source_folder, $source_file_name, $width, $image_cache_sub_folder, $image_cache_folder);

} else {
	echo 'missing params';
}

?>