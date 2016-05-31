<?php if(count($highlights)):?>
	<h1>Highlights entries</h1>
	<a href="<?php echo base_url();?>news/rss">RSS Feed</a>	
	<table>
		<tr>
			<th>Title</th>
			<th>Date add</th>
			<th>User</th>
		</tr>
		<?php foreach($highlights as $item): ?>
			<tr>
				<td><a href="news/view/<?php echo $item->news_id;?>"><?php echo $item->title; ?></a></td>
				<td><?php echo $item->date_add; ?></td>
				<td><?php echo $item->email; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php else: ?>
	No records in database 
<?php endif; ?>