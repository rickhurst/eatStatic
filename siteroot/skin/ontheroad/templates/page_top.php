<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php if (isset($page_title)) echo $page_title ?></title>
	
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
	<link type="text/css" rel="stylesheet" href="/skin/global/css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="/skin/<?php echo SKIN ?>/css/style.css" />
	<link type="text/css" rel="stylesheet" href="/skin/global/css/bootstrap-responsive.min.css" />
	<link type="text/css" rel="stylesheet" href="/skin/global/css/jquery.lightbox-0.5.css" />
	<script type="text/javascript" src="/skin/global/js/lib/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="/skin/global/js/lib/jquery.lightbox-0.5.js"></script>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php
	if($production){ 
		if(GOOGLE_ANALYTICS_ID != ''){
			require ROOT.'/skin/global/templates/google_analytics_embed.php';
		}
	} ?>
</head>

