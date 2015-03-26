<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login &#38; Registration</title>
	<style type="text/css"></style>
	<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"> 
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/stylesheets/style.css">
</head>
<body>
	<h2>Welcome!</h2>
	<div id='register'>
		<form action='/books/register' method='post' class="form-group">
			<fieldset>
				<legend>New Users</legend>
				<label for='first_name'>First Name:</label>
				<input type='text' class="form-control" id="first_name" name='first_name' value="<?php echo set_value('first_name'); ?>">
				<?php echo "<span class='error'>" . form_error('first_name') . "</span>"; ?>
				<label for='last_name'>Last Name:</label>
				<input type='text' class="form-control" id="last_name" name='last_name' value="<?php echo set_value('last_name'); ?>">
				<?php echo "<span class='error'>" . form_error('last_name') . "</span>"; ?>
				<label for='alias'>Alias:</label>
				<input type='text' class="form-control" id="alias" name='alias' value="<?php echo set_value('alias'); ?>">
				<?php echo "<span class='error'>" . form_error('alias') . "</span>"; ?>
				<label for='email'>Email:</label>
				<input type='email' class="form-control" id="email" name='email' value="<?php echo set_value('email'); ?>">
				<?php echo "<span class='error'>" . form_error('email') . "</span>"; ?>
				<label for='password'>Password:</label>
				<input type='password' class="form-control" id="password" name='password' value="<?php echo set_value('password'); ?>">
				<?php echo "<span class='error'>" . form_error('password') . "</span>"; ?>
				<p>*Password should be at least 8 characters.</p>
				<label for='confirm'>Confirm Password:</label>
				<input type='password' class="form-control" id="confirm" name='confirm'>
				<?php echo "<span class='error'>" . form_error('confirm') . "</span>"; ?>
				<button type='submit' class="btn btn-default">Register</button>
			</fieldset>
		</form>
	</div>
	<div id='login'>
		<form action='/books/login' method='post' class="form-group">
			<fieldset>
				<legend>Existing Users</legend>
				<label for='emaillogin'>Email:</label>
				<input type='email' class="form-control" id="emaillogin" name='emaillogin' value="<?php echo set_value('emaillogin'); ?>">
				<?php if(isset($emailerror)){echo "<span class='error'>" . $emailerror . "</span>";} ?>
				<label for='passwordlogin'>Password:</label>
				<input type='password' class="form-control" id="passwordlogin" name='passwordlogin'>
				<?php if(isset($pwerror)){echo "<span class='error'>" . $pwerror . "</span>";} ?>
				<button type='submit' class="btn btn-default">Login</button>
			</fieldset>
		</form>
	</div>
</body>
</html>