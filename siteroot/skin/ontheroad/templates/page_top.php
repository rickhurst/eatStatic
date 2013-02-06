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
	<link type="text/css" rel="stylesheet" href="/min/?g=css" />
	<link rel="icon" 
      type="image/png" 
      href="/skin/ontheroad/img/favicon.png" />
	
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

