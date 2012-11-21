<?php


$page_title = BLOG_TITLE.' :: About';

require ROOT.'/skin/'.SKIN.'/templates/page_top.php';
require ROOT.'/skin/'.SKIN.'/templates/body_top.php';

?>
<div class="post">
	<h2>Contact</h2>
    <?php
    echo eatStatic::block("contact"); 
    ?>
</div>

<?php

require ROOT.'/skin/'.SKIN.'/templates/body_bottom.php';
require ROOT.'/skin/'.SKIN.'/templates/page_bottom.php';

?>