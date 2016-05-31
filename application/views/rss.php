<?php foreach($highlights as $item): ?>
   <item> 
      <title><?php echo $item->title; ?></title>
      <link><?php echo site_url(base_url() . 'news/view/' . $item->news_id) ?></link>
      <guid><?php echo site_url(base_url() . 'news/view/' . $item->news_id) ?></guid> 
        <description><![CDATA[ <?php echo substr($item->text, 0, 200); ?> ]]></description>
        <pubDate><?php echo $item->date_add; ?></pubDate>
    </item>
<?php endforeach; ?>