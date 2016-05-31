<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to News Application</title>
 	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style.css"></link>
</head>
<body>
<div id="header"><a href="<?php echo base_url();?>" class="h_title">CROSSOVER APPLICATION PROJECT</a></div>
<div id="container">
	<?php $message = $this->session->flashdata('message'); ?>
	<?php if(isset($message)): ?>
		<div class="message">			
			<?php echo $message;?>
		</div>
	<?php endif ?>
	{content_for_layout}
</div>
<div id="footer">Crossover application project 2016</div>
</body>
</html>