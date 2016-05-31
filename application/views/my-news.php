<?php if(count($news)):?>
	<h1>My news</h1>
	<table>
		<tr>
			<th>Title</th>
			<th>Date add</th>
			<th>Actions</th>
		</tr>
		<?php foreach($news as $item): ?>
			<tr>
				<td><a href="<?php echo base_url(); ?>news/view/<?php echo $item->news_id;?>"><?php echo $item->title; ?></a></td>
				<td><?php echo $item->date_add; ?></td>
				<td><a href="<?php echo base_url(); ?>news/delete/<?php echo $item->news_id;?>">delete</a></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php else: ?>
	No records in database 
<?php endif; ?>