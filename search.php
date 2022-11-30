<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Very Cool Group">
  <meta name="description" content="A MyFood recipe detail page">      
  <title>MyFood - Search</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Icon from https://www.clipsafari.com/clips/o237408-sprouting-green-leaves -->
  <link rel="icon" type="image/png" href="images/siteicon.png" />

  <style>
    .top {
        margin-left: 10%;
        margin-bottom: 0.5%;
    }

    .recipes {
        margin-left: 10%;
        margin-right: 10%;
    }

    .cardcol {
        margin-bottom: 2%;
    }

    .card {
        height: 100%;
        width: 25vw;
    }

    .card-title {
        max-width: 90%;
    }

    .favorite {
        position: absolute;
        right: 4%;
        z-index: 2;
    }

    .card .card-body {
        background-color: #Dae8da;
    }

    .card-img {
        width: 100%;
        max-height: 100%;
        object-fit: cover;
    }

    .bi-star-fill {
        color: #E4A11B;
    }
    </style>

    <?php 
        // Include config file
        require_once "connect-db.php";
    ?>

</head>

<body>

    <div class="fixed-top">
    <?php include 'protect.php'?>
        <?php include('site_heading.html') ?>
        <?php include('navbar.html') ?>
        
    </div>

    <div style="padding-top:208px;">

    </div>
    <style>
        .searchbox {
            margin-left:10%;
    }   
    </style>
    <head>
	<title>Search</title>
    <div align="left" class="row top">
        <h2 style="font-weight:bold;"> Search </h2>
    </div>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
    <div class="searchbox">
	<form action="search.php" method="GET">
        <label for="tags">Choose a tag:</label>
        <select name="tags" id="tags">
        <optgroup label="Recipe Tags">
            <option value="None">None</option>
            <option value="Cheap">Cheap</option>
            <option value="Quick">Quick</option>
            <option value="Fancy">Fancy</option>
            <option value="Vegan">Vegan</option>
            <option value="Healthy">Healthy</option>
            <option value="Comfort Food">Comfort Food</option>
            <option value="Spicy">Spicy</option>
            <option value="Dessert">Dessert</option>
            <option value="Vegetarian">Vegetarian</option>
        </optgroup>
        </select>
		<input type="text" name="query" />
		<input type="submit" class="btn btn-primary submit" value="Search" />
	</form>
    </div>
    
    </body>

    </div>
    <br>
    <div class="row top">
        <h2 style="font-weight:bold;"> Search Results </h2>
    </div>
    <head>
	<title>Search Results</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    
    <!-- Recipe cards -->
    <div class="row recipes">

        <?php
            // Query the latest 6 recipes by recipe_id
            $search = $_GET['query'];
            $tag =  $_GET['tags'];
           
            //$search = $mysqli -> real_escape_string($search);
            $search = htmlspecialchars($search); 
            $tag = htmlspecialchars($tag); 
		    $search = mysqli_real_escape_string($db, $search);
            $tag = mysqli_real_escape_string($db, $tag);
            if ($tag=="None")
            {
                $sql = "SELECT * FROM recipe WHERE recipe_name LIKE '%".$search."%' OR ingredients LIKE '%".$search."%'";

            }
            else 
            {
                $sql = "(SELECT * FROM recipe WHERE recipe_name LIKE '%".$search."%' OR ingredients LIKE '%".$search."%') INTERSECT (SELECT * FROM recipe WHERE recipe_id IN (SELECT recipe_id FROM recipe_tags WHERE tag LIKE '%".$tag."%'))";

            }

		    $raw_results = mysqli_query($db, $sql);
            

            if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
			
                while($results = mysqli_fetch_array($raw_results)){
                // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                
                    // posts results gotten from database(title and text) you can also show id ($results['id'])
                    // Check recipe's favorite status
                    $favorited = false;
                    $recipeid = $results['recipe_id'];
                    $userid = $_SESSION['id'];
                    $thisrecipe_fav = mysqli_query($db, "SELECT * FROM `favorites` WHERE recipe_id=$recipeid AND user_id=$userid");
                    // User has favorited this recipe
                    if (mysqli_num_rows($thisrecipe_fav) != 0) {
                        $favorited = true;
                    }
                    ?>

                    <!-- Individual recipe card -->
                    <!-- Click to view recipe's details -->
                    <div class="col-sm-4 cardcol">
                        <div class="card">
                            <div class="card-body">
                                <!-- Favorite icon -->
                                <div class="favorite">
                                    <?php
                                    // Icon depends on favorited status
                                    if ($favorited) {
                                        echo "<i onclick='unfavorite(this, $userid, $recipeid)' id='fav' class='bi bi-star-fill' style='font-size: 2rem;'></i>";
                                    }
                                    else {
                                        echo "<i onclick='favorite(this, $userid, $recipeid)' id='fav' class='bi bi-star' style='font-size: 2rem;'></i>";                               
                                    }
                                    ?>                              
                                </div>
                                <!-- Recipe name -->
                                <a href="viewrecipe.php?recipe_id=<?= $results['recipe_id'] ?>" class="stretched-link"><h3 class="card-title"><?= $results['recipe_name'] ?></h3></a>
                            </div>
                            <!-- Recipe image -->
			<?php 
                                $sql = "SELECT * FROM recipe_pictures WHERE recipe_id = $recipeid";
                                if($stmt = mysqli_prepare($db, $sql)){
                                    // Attempt to execute the prepared statement
                                    if(mysqli_stmt_execute($stmt)){
                                        // Redirect to login page
                                        // header("location: landing.php");
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        if (mysqli_num_rows($result) > 0 && $recipeid>20) {
                                            ?>
                                            <img src="imageView.php?recipe_id=<?php echo $recipeid ?>" class="card-img">
                                            <?php
                                        }
                                        else 
                                        {
                                            ?>
                                            <img src="images/genericrecipe.jpg" class="card-img" alt="Default recipe photo">
                                            <?php
                                        }
                                    } else{
                                        echo "Oops! Something went wrong. Please try again later.";
                                    }
                        
                                    // Close statement
                                    mysqli_stmt_close($stmt);
                                }
                            ?> 
			    </div>
                    </div>
        
                    <?php } 
                
            }
            else{ // if there is no matching rows do following
                echo "No results";
            }
          
        ?>
            
    </div>

    <!-- Hidden form for updating favorites -->
    <form id="favform" method="post" style="display:none;">
        <input type="hidden" id="favuserid" name="favuserid" required>
        <input type="hidden" id="favrecipeid" name="favrecipeid" required>
        <input type="hidden" id="favchangeto" name="favchangeto" required>
    </form>

    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

     <!-- https://www.w3schools.com/php/php_ajax_database.asp -->
     <script>
        function favorite(icon, userid, recipeid) {
            // Toggle star icon
            icon.classList.toggle("bi-star");
            icon.classList.toggle("bi-star-fill");
            // AJAX request to add favorite
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","getfav.php?userid="+userid+"&recipeid="+recipeid+"&fav=true", true);
            xmlhttp.send();
        }

        function unfavorite(icon, userid, recipeid) {
            // Toggle star icon
            icon.classList.toggle("bi-star-fill");
            icon.classList.toggle("bi-star");
            // AJAX request to remove favorite
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","getfav.php?userid="+userid+"&recipeid="+recipeid+"&fav=false", true);
            xmlhttp.send();
        }
    </script>
    
</body>
</html>
