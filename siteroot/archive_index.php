<?php

require EATSTATIC_ROOT.'/eatStaticBlog.class.php';
require EATSTATIC_ROOT.'/eatStaticTag.class.php';

$blog = new eatStaticBlog;
$blog->post_folder = DATA_ROOT.'/posts/';
$items = $blog->getArchiveIndex();
$page_title = BLOG_TITLE.' :: Archive';

$tags = eatStaticTag::getAll();

eatStatic::template('page_top.php');
eatStatic::template('body_top.php');

?>
<div class="post"> 
<?php

$last_year = '';

foreach($items as $item){
    
    $this_year = $item->year;
    
    if($this_year != $last_year){
        ?>
        <h2><?php echo $this_year ?></h2>        
        <?php
    }
	
	?>
	<span class="entry"><a href="<?php echo $item->uri ?>"><?php echo $item->month ?></a> /</span>		
	<?php
	
	$last_year = $this_year;
	
}

?>
<div class="category-list">	
<h2>Tags</h2>
<?php


foreach($tags as $tag){
	
	?>
	<span class="entry"><a href="<?php echo SITE_ROOT ?>category/<?php echo $tag->getSlug() ?>"><?php echo $tag->name ?></a></span> / 		
	<?php
	
}

?>
</div> 
</div>
<?php

eatStatic::template('body_bottom.php');
eatStatic::template('page_bottom.php');

?>