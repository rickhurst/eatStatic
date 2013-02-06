<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

return array(
    'js' => array('//skin/global/js/lib/jquery-1.7.2.js', 
    			'//skin/global/js/lib/bootstrap.js', 
    			'//skin/global/js/lib/jquery.easing.min.js', 
    			'//skin/global/js/lib/supersized.3.2.7.min.js', 
    			'//skin/global/js/lib/klass.min.js', 
    			'//skin/global/js/lib/code.photoswipe.jquery-3.0.5.min.js',
    			'//skin/ontheroad/js/ontheroad.js'),
    'css' => array('//skin/global/css/bootstrap.css', 
    				'//skin/ontheroad/css/style.css', 
    				'//skin/global/css/bootstrap-responsive.css', 
    				'//skin/global/css/photoswipe.css')
);