<div class="news_item">
	<h1><?php echo $news_item->title;?></h1>
	<p><a href="<?php echo base_url() . 'news/pdf/' . $news_item->news_id;?>">PDF Version</a></p>	
	<img src="<?php echo base_url() . 'images/' . $news_item->image;?>"/>
	<p class="news_content_item"><?php echo nl2br($news_item->text);?></p>
	<p class="author"><a href="mailto:<?php echo $news_item->email;?>"><?php echo $news_item->email;?></a></p>
<div>