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
	if(DISQUS_ENABLED){
		require ROOT.'/skin/global/templates/disqus_js_embed.php';
	}
	?>
	<script src="/skin/global/js/lib/bootstrap.js"></script>
</body>