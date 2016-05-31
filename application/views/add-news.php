<form action="<?php echo base_url(); ?>news/add" method="post" enctype="multipart/form-data">
<fieldset>
	<legend>New item form</legend>
	
	<p>
		<label for="title">Title:</label>
		<input type="text" name="title" id="title" value="<?php echo set_value('title'); ?>"/>
	</p>

	<p>
		<label for="file">Image:</label>
		<input type="file" name="image" id="image"/>
	</p>

	<p>
		<label for="text">Description:</label>
		<textarea name="text" id="text"><?php echo set_value('text'); ?></textarea>
	</p>	

	<input type="submit">
</fieldset>
</form>