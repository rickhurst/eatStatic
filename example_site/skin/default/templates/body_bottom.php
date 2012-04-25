					

				<div class="nav-col">
					<div class="visual-wrapper">
						<?php if($path[0] == ""){ echo eatStatic::block("about"); } ?>
					</div>
				</div>
				<hr />
				<footer>
			
					<?php echo eatStatic::block("footer"); ?>
				
				</footer>
				
		</div><!-- container -->

	</div><!-- main-wrapper-->
	<?php
	if(DISQUS_ENABLED){
		require ROOT.'/skin/global/templates/disqus_js_embed.php';
	}
	?>
	<script src="/skin/<?php echo SKIN ?>/js/bootstrap.js"></script>
</body>