<div class="pagination">
	<ul>
		<li class="<?php if($this->current == 1): ?>disabled<?php endif ?>"><a href="<?php echo SITE_ROOT ?><?php if($this->current > 2): ?><?php echo $this->pagination_root ?><?php echo ($this->current -1) ?><?php endif; ?>">&lt;&lt;</a></li>
	<?php


for($i=1; $i<=$this->pages; $i++){
?>
		<li class="<?php if($this->current == $i) echo "active" ?>" ><a href="<?php echo SITE_ROOT ?><?php if ($i > 1): ?><?php echo $this->pagination_root ?><?php echo $i ?><?php endif ?>"><?php echo $i ?></a></li>
<?php
}
?>

		<li <?php if(!$this->current < $this->pages): ?>class="disabled"<?php endif ?>><a <?php if($this->current < $this->pages): ?>href="<?php echo SITE_ROOT ?><?php echo $this->pagination_root ?><?php echo ($this->current + 1) ?>"<?php endif ?>>&gt;&gt;</a></li>
	</ul>
</div>