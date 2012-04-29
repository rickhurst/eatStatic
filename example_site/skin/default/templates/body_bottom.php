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
	<a href="http://github.com/rickhurst/eatStatic"><img style="position: absolute; top: 0; right: 0; border: 0; z-index:9999" src="https://a248.e.akamai.net/camo.github.com/7afbc8b248c68eb468279e8c17986ad46549fb71/687474703a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub"></a>
	<script src="/skin/global/js/lib/bootstrap.js"></script>
</body>