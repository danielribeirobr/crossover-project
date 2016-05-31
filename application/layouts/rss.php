<?php header("Content-Type: application/rss+xml"); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">
 
    <channel>
	<title>News Crossover application</title>
	 
	<link><?php echo base_url(); ?></link>
	<description>This is a sample description for rss feed</description>	 
	<dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
	<admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />    
	{content_for_layout}
	</channel>
</rss>	