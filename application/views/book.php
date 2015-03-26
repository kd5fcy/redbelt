<!doctype html>
<html lang="en">
<head>
    <?php
        $data = $this->Bookdb->book_info($id); 
        foreach ($data as $row => $key) 
        {
            $book_name = $key->name;
            $author = $key->author;
        }
    ?>
    <meta charset="utf-8">
    <title><?php if(isset($book_name)){echo $book_name;} ?> by: <?php if(isset($author)){echo $author;} ?></title>
    <style type="text/css"></style>
    <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/stylesheets/style.css">
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
	<nav class="navbar navbar-default">
	    <div class="container-fluid">
	    	<p class="navbar-text navbar-right"><a href='/books/logoff' class="navbar-link">Logout</a></p>
	    	<p class="navbar-text navbar-right"><a href='/books/view' class="navbar-link">Home</a></p>
	    </div>
	</nav>
	<h2><?php if(isset($book_name)){echo $book_name;} ?></h2>
	<h3>Author: <?php if(isset($author)){echo $author;} ?></h3>
	<section id="content" class="panel panel-default">
        <h4 class='panel-title'>Reviews:</h4>
        <div class="panel-body">
            <div class="panel-body">
            <?php
                $star = '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                $nostar = '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
                $star1 = $star . $nostar . $nostar . $nostar . $nostar;
                $star2 = $star . $star . $nostar . $nostar . $nostar;
                $star3 = $star . $star . $star . $nostar . $nostar;
                $star4 = $star . $star . $star . $star . $nostar;
                $star5 = $star . $star . $star . $star . $star;
                $count = 0;
                foreach ($data as $row => $key) 
                {
                    $bookid = $key->book_id;
                    $count++;
                    if($key->rating == 1){$stars = $star1;}
                    if($key->rating == 2){$stars = $star2;}
                    if($key->rating == 3){$stars = $star3;}
                    if($key->rating == 4){$stars = $star4;}
                    if($key->rating == 5){$stars = $star5;}
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $key->created_at);
                    $newdate = $date->format('F j, Y');
                    echo "<p>Rating: " . $stars . "</p><p><a href='/books/users/" . $key->user_id . "'>" . $key->first_name . "</a> says: " . $key->review . "</p><p>Posted on " . $newdate;
                    if($key->user_id == $this->session->userdata('user_id'))
                    {
                        if($count>1)
                        {
                            $this->session->set_flashdata('last_book', $key->book_id);
                            $delete = "<a href='/books/delete/" . $key->id . "'>Delete this review</a>";
                        }
                        else
                        {
                            $this->session->set_flashdata('book', $key->book_id);
                            $delete = "<a href='/books/delete/" . $key->id . "'>Delete this review</a>";
                        }
                    }  
                    else
                    {
                        $delete = '';
                    }
                    echo "<span class='right'>" . $delete . "</span></p><hr>";
                } 
            ?> 
  		</div><!--  id='add' class='form-horizontal' -->
    </section>
    <aside class="panel panel-default">
        <form action='/books/update' method='post'>
            <label for="review">Add a Review:</label>
            <textarea class="form-control" rows='3' name='review'></textarea>
            <input type='hidden' name='book_id' value='<?php echo $bookid; ?>'>
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
            <button type='submit' class="btn btn-default">Submit Review</button>
        </form>
    </aside>
</body>
</html>