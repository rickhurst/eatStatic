					</div><!-- visual-wrapper -->
				</div><!-- col2 -->
				<div class="insert-col">
				    
				</div>
				<div class="nav-col">
					<div class="visual-wrapper">
						<?php if($path[0] == ""){ echo eatStatic::block("about"); } ?>
					</div>
				</div>
				<div class="clear"><!-- --></div>
			</div><!-- inner -->
		</div><!-- content -->
		<footer>
			<div class="inner">
				<div class="visual-padding">
				<?php echo eatStatic::block("footer"); ?>
				</div>
			</div>
		</footer>
	</div><!-- main-wrapper-->
	<?php
	if(DISQUS_ENABLED){
		require ROOT.'/skin/global/templates/disqus_js_embed.php';
	}
	?>
</body>