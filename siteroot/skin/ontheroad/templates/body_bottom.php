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
	<script type="text/javascript" src="/skin/global/js/lib/jquery.easing.min.js"></script>
		
	<script type="text/javascript" src="/skin/global/js/lib/supersized.3.2.7.min.js"></script>

	<script type="text/javascript" src="/skin/global/js/lib/klass.min.js"></script>
	<script type="text/javascript" src="/skin/global/js/lib/code.photoswipe.jquery-3.0.5.min.js"></script>
	<script type="text/javascript">
			
			jQuery(function($){

				pageWidth = $(window).width();
				if(pageWidth > 640){
					$.supersized({
					
						// Functionality
						slide_interval          :   7000,		// Length between transitions
						transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
						transition_speed		:	2000,		// Speed of transition
																   
						// Components							
						slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
						slides 					:  	[			// Slideshow Images
															{image : '/images/misc/rick_t25_1024.jpg'},
															{image : '/images/2013-01-28-my-old-T25-panel-van/IMG_2615_1024.jpg'},
															{image : '/images/2013-01-28-my-old-T25-panel-van/IMG_2632_1024.jpg'},
															{image : '/images/2013-01-06-vw-t25-campervan/IMG_20121006_152827_1024.jpg'}
													]
						
					});
				}
		    });
		    
	</script>
</body>