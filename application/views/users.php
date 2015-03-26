<!doctype html>
<html lang="en">
<head>
	<?php
	if($this->session->userdata('user_id')){
		 	$user = $this->Bookdb->user_info();
			$book_reviews = $this->Bookdb->book_reviews();
		 	$book_count = $this->Bookdb->book_count(); 
	}
	?>
	<meta charset="utf-8">
	<title><?php if($this->session->userdata('user_id')){echo $user['first_name'] . " " . $user['last_name'];} ?>'s Reviews</title>
	<style type="text/css"></style>
	<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"> 
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/stylesheets/style.css">
</head>
<body>
	<nav class="navbar navbar-default">
	    <div class="container-fluid">
	    	<p class="navbar-text navbar-right"><a href='/books/logoff' class="navbar-link">Logout</a></p>
	    	<p class="navbar-text navbar-right"><a href='/books/add' class="navbar-link">Add Book and Review</a></p>
	    	<p class="navbar-text navbar-right"><a href='/books/view' class="navbar-link">Home</a></p>
	    </div>
	</nav>
	<div class="panel panel-default" id='content'>
		<div class='panel-body'>
			<h3>User Alias: <?php if($this->session->userdata('user_id')){echo $user['alias'];} ?></h3>
			<h4>Name: <?php if($this->session->userdata('user_id')){echo $user['first_name'] . " " . $user['last_name'];} ?></h4>
			<h4>Email: <?php if($this->session->userdata('user_id')){echo $user['email'];} ?></h4>
			<h4>Total Reviews: <?php if($this->session->userdata('user_id')){echo $book_count;} ?></h4>
		</div>
		<div class='panel-body'>
			<h4>Posted Reviews on the following books:</h4>
			<ul>
				<?php
				if($this->session->userdata('user_id')){
					foreach ($book_reviews as $key) {
						foreach ($key as $id => $name) {
							echo "<li><a href='/books/book/" . $id . "'>" . $name . "</a></li>";
						}
					}
				}
				?>
			</ul>
		</div>
	</div>
</body>
</html>