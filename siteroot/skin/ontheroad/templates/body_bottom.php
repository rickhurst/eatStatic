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
    					<a class="twitter-timeline" href="https://twitter.com/campervanthings" data-widget-id="301036070043262976">Tweets by @campervanthings</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

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