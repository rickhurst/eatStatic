<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	>

<channel>
	<title><?php echo $feed->blog_title ?></title>
	<link><?php echo $feed->blog_link ?></link>
	<description><?php echo $feed->blog_description ?></description>
	<pubDate><?php echo $feed->pub_date; //last updated e.g. Tue, 01 Jun 2010 13:35:09 +0000 ?></pubDate>
	<generator>http://www.rickhurst.co.uk/dropblog</generator>
	<language>en</language>
	<?php
	foreach($feed->items as $item){
	?>
	<item>
		<title><?php echo $item->title ?></title>
		<link><?php echo $item->url ?></link>
		<comments><?php echo $item->url ?>#disqus_thread</comments>
		<pubDate><?php echo $item->pub_date; //Tue, 01 Jun 2010 13:35:09 +0000 ?></pubDate>
		<dc:creator><?php echo $item->author ?></dc:creator>
		<?php if(sizeof($item->tags) > 0){
			foreach($item->tags as $tag){
		?>
			<category><?php echo $tag; ?></category>
		<?php
			}
		}
		?>
	
		<guid isPermaLink="false"><?php echo $item->url ?></guid>
		<description><![CDATA[<?php echo $item->summary; ?>]]></description>
		<content:encoded><![CDATA[<?php echo $item->formatted_body; ?>]]>
         </content:encoded>
		</item>
		<?php
		}
		?>
		
	</channel>
</rss>
