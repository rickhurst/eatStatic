<?php

require EATSTATIC_ROOT.'/eatStaticTag.class.php';

$tags = eatStaticTag::getAll();

require ROOT.'/skin/'.SKIN.'/templates/page_top.php';
require ROOT.'/skin/'.SKIN.'/templates/body_top.php';
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

require ROOT.'/skin/'.SKIN.'/templates/body_bottom.php';
require ROOT.'/skin/'.SKIN.'/templates/page_bottom.php';

?>