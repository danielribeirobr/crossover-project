<div id="user_box">
	<?php if(isset($user_data)): ?>
		<fieldset>
			<p>Welcome: <?php echo $user_data->email; ?></p>
			<ul>
				<li><a href="<?php echo base_url() ; ?>news/add">Add new item</a></li>
				<li><a href="<?php echo base_url() ; ?>news/myitens">My Itens</a></li>
				<li><a href="<?php echo base_url();?>user/changepassword">Change password</a></li>
				<li><a href="<?php echo base_url() ; ?>user/logout">Logout</a></li>
			</ul>
		</fieldset>
	<?php else: ?>		
		<form action="<?php echo base_url(); ?>user/adduser/" name="new_user" method="post">
			<fieldset>
				<legend>New user</legend>
				<label for="email">Sign up to add news: </label>
				<input type="text" name="email" id="email">
				<input type="submit"/>
			</fieldset>
		</form>
		<form action="<?php echo base_url(); ?>user/login" name="login" method="post">
			<fieldset>
				<legend>Existing user</legend>
				<label for="email">Email: </label>
				<input type="text" name="email" id="email" value="<?php echo $this->input->post('email');?>">
				<label for="password">Password: </label>
				<input type="password" name="password" id="password">
				<input type="submit"/>
			</fieldset>
		</form>		
	<?php endif; ?>
</div>