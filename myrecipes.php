<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Very Cool Group">
  <meta name="description" content="A MyFood recipe detail page">      
  <title>MyFood - My Recipes</title>
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
        margin-bottom: 8%;
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

    <div class="row top">
        <h2 style="font-weight:bold;"> My Recipes</h2>
    </div>

    <!-- Recipe cards -->
    <div class="row recipes">

        <?php
            // Query the latest 6 recipes by recipe_id
            $sql = "SELECT * FROM recipe WHERE recipe_id IN (SELECT recipe_id FROM uploads WHERE user_id = ?)";
            if($stmt = mysqli_prepare($db, $sql))
            {
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                $param_id = $_SESSION["id"];
                if(mysqli_stmt_execute($stmt))
                {
                    $latest_recipes = mysqli_stmt_get_result($stmt);
                    if(mysqli_num_rows($latest_recipes) <= 0)
                    {
                        echo "<div style='margin-bottom:23.5%;'>No recipes uploaded yet.</div>";
                    }
                    else
                    {
                        foreach ($latest_recipes as $recipe) 
                        { 
                            // Check recipe's favorite status
                            $favorited = false;
                            $recipeid = $recipe['recipe_id'];
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
                                    <a href="viewrecipe.php?recipe_id=<?= $recipe['recipe_id'] ?>" class="stretched-link"><h3 class="card-title"><?= $recipe['recipe_name'] ?></h3></a>
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
                          <a href="edit_recipe.php?recipe_id=<?= $recipe['recipe_id'] ?>" class="link"><h3 class="card-title"><?= "Edit this recipe" ?></h3></a>

                        </div>

                        <?php 
                        }
                    }
                }
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            } ?>
            
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
