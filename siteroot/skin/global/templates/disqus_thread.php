	<div id="disqus_thread"></div>
	<script type="text/javascript">
		<?php if(!$production){ ?>
		var disqus_developer = 1;
		<?php } ?>
	  /**
	    * var disqus_identifier; [Optional but recommended: Define a unique identifier (e.g. post id or slug) for this thread] 
	    */
		var disqus_identifier = '<?php echo $post->slug ?>';
	  (function() {
	   var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	   dsq.src = 'http://<?php echo DISQUS_IDENTIFIER ?>.disqus.com/embed.js';
	   (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	  })();
	</script>
	<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript=<?php echo DISQUS_IDENTIFIER ?>">comments powered by Disqus.</a></noscript>
	<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>