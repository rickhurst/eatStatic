<body>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=157363931108458";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<div class="navbar navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container">
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          <a class="brand" href="/"><?php echo BLOG_TITLE ?></a>
	          <div class="nav-collapse">
	            <ul class="nav">
	              <li class="active"><a href="/">Home</a></li>
	              <li><a href="/about">About</a></li>
				  <li><a href="/contact">Contact</a></li> 
	              <li><a href="/archive">Archive</a></li>
	            </ul>
	          </div><!--/.nav-collapse -->
	        </div>
	      </div>
	    </div>

		<div class="container">
				<?php if($path[0] == ""){ ?>
				<header>
				<h1><?php echo BLOG_TITLE ?></h1>
				</header>
				<?php } ?>
			    <div class="row-fluid">
    				<div class="span8">
