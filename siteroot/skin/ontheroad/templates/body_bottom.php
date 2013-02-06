    				</div>
    				<div class="span4">
    					<?php if($path[0] == ""){ 
    						?>
    						<div class="well">
    						<?php
    						echo eatStatic::block("about"); 
    						 ?>
    						 <a class="btn btn-primary" href="/about">Read More</a>
    						</div>
    						<?php
    					} ?>
    				</div>
    			</div><!-- /.row-fluid -->				

				<hr />
				<footer>
			
					<?php echo eatStatic::block("footer"); ?>
				
				</footer>
				
		</div><!-- container -->

	<?php
	// if(DISQUS_ENABLED){
	// 	require ROOT.'/skin/global/templates/disqus_js_embed.php';
	// }
	?>
	<script type="text/javascript">
	var galleries = Array();
	<?php 
	if(isset($blog)){
		foreach($blog->gallery_ids as $gallery_id){ ?>
	galleries.push('<?php echo $gallery_id ?>');
	<?php
		}
	} ?>
	</script>
	<script src="/min/?g=js"></script>

</body>