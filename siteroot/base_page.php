<?php

eatStatic::template('page_top.php');
eatStatic::template('body_top.php');

?>
<div class="post">
<?php

echo $page->content;

?>
</div>
<?php

eatStatic::template('body_bottom.php');
eatStatic::template('page_bottom.php');

?>