<div class="post">
	<a href="<?php echo $post->uri ?>" class="link"><h2><?php echo $post->title ?></h2></a>
	
	<div class="ago">
	This post was written <?php echo eatStaticBlog::time_elapsed_string($post->timestamp);?> ago.
	</div>
	
	<div class="date"><?php echo $post->nice_date ?></div>
	<div class="body"><?php echo $post->formatted_body ?></div>
	<?php
	if(sizeof($post->gallery_items) > 0){
	?>
	<div class="gallery">
		<?php
		foreach($post->gallery_items as $item){
			?>
				<div class="thumb">
					<a href="<?php echo $item->view_url ?>" class="lightbox-<?php echo $post->slug ?>" title="<?php echo $item->caption ?>">
						<img src="<?php echo $item->thumb_url ?>" alt="<?php echo $item->caption ?>" />
					</a>
				</div>
			<?php
		}
		?>
		<div class="clear"><!-- --></div>
		<?php //echo "here";print_r($gallery->captions); ?>
	</div>
	<script type="text/javascript">
	$(function() {
		$('.gallery a.lightbox-<?php echo $post->slug ?>').lightBox({fixedNavigation:true});
	});
	</script>
	<?php	
	}
	
	eatStaticBlog::obsoleteWarning($post->timestamp);
	
	if(sizeof($post->tags) > 0){
	?>
	<div class="tags">
		Tags: 
	<?php
		foreach($post->tags as $tag){
	?>
	<a href="<?php echo SITE_ROOT ?>category/<?php echo $post->slugify($tag) ?>"><?php echo $tag ?></a> / 
	<?php
		}
	?>
	</div>
	<?php
	}
	?>
	<?php if (DISQUS_ENABLED): ?>
	<a href="<?php echo $post->uri ?>#disqus_thread" data-disqus-identifier="<?php echo $post->slug ?>">Comments</a>
	<?php endif; ?>
</div>