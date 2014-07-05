<?php

$show_prev_next = false;

eatStatic::template('page_top.php');
eatStatic::template('body_top.php');

foreach($posts as $post){
	eatStatic::template('post_item.php');
}

$paginator->render();

eatStatic::template('body_bottom.php');
eatStatic::template('page_bottom.php');

?>