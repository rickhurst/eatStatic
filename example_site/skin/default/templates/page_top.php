<!DOCTYPE html>
<html>
<head>
	<title><?php echo $page_title ?></title>
	
	<?php
	if(!isset($meta_keywords)){
		$meta_keywords = GLOBAL_KEYWORDS;
	}
	if(!isset($meta_description)){
		$meta_description = GLOBAL_DESCRIPTION;
	}
	?>
	<meta name="keywords" content="<?php echo $meta_keywords ?>" />
	<meta name="description" content="<?php echo $meta_description ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" /> 
	<link rel="alternate" type="application/rss+xml" title="<?php echo BLOG_TITLE ?>" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/feed/" />
	<link type="text/css" rel="stylesheet" href="/skin/global/css/reset.css" />
	<link type="text/css" rel="stylesheet" href="/skin/<?php echo SKIN ?>/css/styles.css" />
	<link type="text/css" rel="stylesheet" href="/css/jquery.lightbox-0.5.css" />
	<link rel="shortcut icon" type="image/x-icon" href="/skin/rickblog/img/favicon.ico" />
	<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.lightbox-0.5.js"></script>
	<script type="text/javascript" src="/js/html5shiv.js"></script>

	<?php
	if($production){ 
		if(GOOGLE_ANALYTICS_ID != ''){
			require ROOT.'/skin/global/templates/google_analytics_embed.php';
		}
	} ?>
</head>

