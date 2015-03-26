<html>
<head>
	<title>Add Book and Review</title>
	<script src=<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js></script>
	<link rel="stylesheet" href=<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css> 
	<link rel="stylesheet" href=<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-theme.min.css>
	<script src=<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js></script>
	<link rel="stylesheet" type="text/css" href=<?php echo base_url(); ?>assets/stylesheets/style.css>
	<script>
		$(document).ready(function(){
      $('#authors').change(function()
      { 
        if($(this).val() == '')
        {
          $("div.conditional").show();
        }
        else
        {
          $("div.conditional").hide();
        }
      });
    });
	</script>
	<style>
		.starRating > label
    {
			background      : url(<?php echo base_url(); ?>assets/images/star-off.svg);
		}
		.starRating > label:before
    {
			background      : url(<?php echo base_url(); ?>assets/images/star-on.svg);
		}
	</style>
</head>
<body>
	<?php $authors = $this->Bookdb->author_list();?>
	<nav class="navbar navbar-default">
	    <div class="container-fluid">
	    	<p class="navbar-text navbar-right"><a href='/books/logoff' class="navbar-link">Logout</a></p>
	    	<p class="navbar-text navbar-right"><a href='/books/view' class="navbar-link">Home</a></p>
	    </div>
	</nav>
	<h4>Add a New Book Title and a Review:</h4>
  <?php if(isset($error)){ echo "<span class='error'>" . $error . "</span>";} ?>
	<form action='/books/create' method='post' id='add' class='form-horizontal'>
		<div class="form-horizontal">
    		<label for="title">Book Title:</label>
    		<input type="text" class="form-control" name='title'>
  		</div>
  		<div class="form-inline">
    		<label for="author">Author:</label>
    		<select id='authors' class="form-control" name='existing'>
          <option value=''>Add New Author</option>
    			<?php
    				foreach ($authors as $key => $value) {
    					echo "<option>" . $value . "</option>";
    				}
    			?>
    		</select>
    		<div class='conditional'>
          <input type="text" class="form-control" id='conditional' name='author'>
        </div>
  		</div>
  		<div class="form-horizontal">
    		<label for="review">Review:</label>
    		<textarea class="form-control" rows='4' name='review'></textarea>
  		</div>
  		<label for='rating'>Rating:</label>
  			<span class="starRating">
			  <input id="rating5" type="radio" name="rating" value=5>
			  <label for="rating5">5</label>
			  <input id="rating4" type="radio" name="rating" value=4>
			  <label for="rating4">4</label>
			  <input id="rating3" type="radio" name="rating" value=3>
			  <label for="rating3">3</label>
			  <input id="rating2" type="radio" name="rating" value=2>
			  <label for="rating2">2</label>
			  <input id="rating1" type="radio" name="rating" value=1 checked="checked">
			  <label for="rating1">1</label>
			</span>
  		<button type='submit' class="btn btn-default">Add Book and Review</button>
  	</form>
</body>
</html>
<script>

</script>