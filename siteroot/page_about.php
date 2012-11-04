<?php


$page_title = BLOG_TITLE.' :: About';

require ROOT.'/skin/'.SKIN.'/templates/page_top.php';
require ROOT.'/skin/'.SKIN.'/templates/body_top.php';

?>
<div class="post">
	<?php
    echo eatStatic::block("about"); 
    ?>
</div>
<?php

require ROOT.'/skin/'.SKIN.'/templates/body_bottom.php';
require ROOT.'/skin/'.SKIN.'/templates/page_bottom.php';

?>