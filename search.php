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
        background-color: #d1d1d1;
    }

    .card-img {
        width: 100%;
        max-height: 100%;
        object-fit: cover;
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
                
                 ?>

                    <!-- Individual recipe card -->
                    <!-- Click to view recipe's details -->
                    <div class="col-sm-4 cardcol">
                        <div class="card">
                            <div class="card-body">
                                <!-- Favorite icon -->
                                <div class="favorite">
                                    <a href="whoa"><i class="bi-star" style="font-size: 2rem;"></i></a>
                                </div>
                                <!-- Recipe name -->
                                <a href="viewrecipe.php?recipe_id=<?= $results['recipe_id'] ?>" class="stretched-link"><h3 class="card-title"><?= $results['recipe_name'] ?></h3></a>
                            </div>
                            <!-- Recipe image -->
                            <img src="images/genericrecipe.jpg" class="card-img" alt="Default recipe photo">
                        </div>
                    </div>
        
                    <?php } 
                
            }
            else{ // if there is no matching rows do following
                echo "No results";
            }
          
        ?>
            
    </div>

    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>