<?php

require EATSTATIC_ROOT.'/eatStaticTag.class.php';

$tags = eatStaticTag::getAll();

eatStatic::template('page_top.php');
eatStatic::template('body_top.php');
?>
<ul class="category-list">	
<?php


foreach($tags as $tag){
	
	?>
	<li><a href="<?php echo SITE_ROOT ?>category/<?php echo $tag->getSlug() ?>"><?php echo $tag->name ?></a></li>		
	<?php
	
}

?>
</ul>
<?php

eatStatic::template('body_bottom.php');
eatStatic::template('page_bottom.php');

?>