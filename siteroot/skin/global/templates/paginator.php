<?php

if($this->current > 1){
	?>
	<a href="">&lt;&lt;</a>
	<?php
}

for($i=1; $i<=$this->pages; $i++){
?>
<a class="<?php if($this->current == $i) echo "current" ?>" href="<?php echo SITE_ROOT ?><?php if ($i > 1): ?>posts/all/<?php echo $i ?><?php endif ?>"><?php echo $i ?></a>
<?php
}
?>