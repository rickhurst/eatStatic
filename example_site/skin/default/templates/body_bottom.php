    				</div>
    				<div class="span4">
    					<?php if($path[0] == ""){ echo eatStatic::block("about"); } ?>
    				</div>
    			</div><!-- /.row-fluid -->				

				<hr />
				<footer>
			
					<?php echo eatStatic::block("footer"); ?>
				
				</footer>
				
		</div><!-- container -->

	<?php
	if(DISQUS_ENABLED){
		require ROOT.'/skin/global/templates/disqus_js_embed.php';
	}
	?>
	<script src="/skin/global/js/lib/bootstrap.js"></script>
</body>