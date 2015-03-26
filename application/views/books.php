<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Books Home</title>
    <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/stylesheets/style.css">
</head>
<body>
	<?php 
		$user = $this->Bookdb->user_info(); 
	?>
	<nav class="navbar navbar-default">
	    <div class="container-fluid">
	    	<h3 class="navbar-brand">Welcome, <?php echo $user['first_name']; ?></h3>
	    	<p class="navbar-text navbar-right"><a href='/books/logoff' class="navbar-link">Logout</a></p>
	    	<p class="navbar-text navbar-right"><a href='/books/add' class="navbar-link">Add Book and Review</a></p>
	    </div>
	</nav>
    <section id="content" class="panel panel-default">
        <h4 class='panel-title'>Recent Book Reviews</h4>
        <div class="panel-body">
            <?php    
                $data = $this->Bookdb->review();
                $star = '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                $nostar = '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
                $star1 = $star . $nostar . $nostar . $nostar . $nostar;
                $star2 = $star . $star . $nostar . $nostar . $nostar;
                $star3 = $star . $star . $star . $nostar . $nostar;
                $star4 = $star . $star . $star . $star . $nostar;
                $star5 = $star . $star . $star . $star . $star;
                foreach ($data as $row) 
                {
                    if($row->rating == 1){$stars = $star1;}
                    if($row->rating == 2){$stars = $star2;}
                    if($row->rating == 3){$stars = $star3;}
                    if($row->rating == 4){$stars = $star4;}
                    if($row->rating == 5){$stars = $star5;}
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->date);
                    $newdate = $date->format('F j, Y');
                    echo "<h5><a href='/books/book/" . $row->book . "'>" . $row->name . "</a><span class='attribute'> by: " . $row->author . "</span></h5><p>Rating: " . $stars . "</p><p><a href='/books/users/" . $row->id . "'>" . $row->first_name . "</a> says: " . $row->review . "</p><p>Posted on " . $newdate . "</p><hr>";
                } 
            ?> 
  		</div>
    </section>
    <aside class="panel panel-default">
        <h4 class='panel-title'>Other Books with Reviews:</h4>
        <div class="panel-body">
            <?php    
            $list = $this->Bookdb->reviewed_books();
            foreach ($list as $row) 
            {
                echo "<p><a href='/books/book/" . $row->id . "'>" . $row->name . "</a></p>";
            }
            ?>
  		</div>
    </aside>
</body>
</html>




