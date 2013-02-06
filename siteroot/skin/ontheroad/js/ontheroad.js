/* init supersized */
jQuery(function($){

	pageWidth = $(window).width();
	if(pageWidth > 640){
		$.supersized({
		
			// Functionality
			slide_interval    :   7000,		// Length between transitions
			transition        :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
			transition_speed  :	2000,		// Speed of transition
													   
			// Components							
			slide_links		  :	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
			slides 			  :  	[			// Slideshow Images
												{image : '/images/misc/rick_t25_1024.jpg'},
												{image : '/images/2013-01-28-my-old-T25-panel-van/IMG_2615_1024.jpg'},
												{image : '/images/2013-01-28-my-old-T25-panel-van/IMG_2632_1024.jpg'},
												{image : '/images/2013-01-06-vw-t25-campervan/IMG_20121006_152827_1024.jpg'}
										]
			
		});
	}
});

/* init disqus */
var disqus_shortname = 'rickontheroad2';

(function () {
    var s = document.createElement('script'); s.async = true;
    s.type = 'text/javascript';
    s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
    (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
}());