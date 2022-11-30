<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Very Cool Group">
  <meta name="description" content="A MyFood recipe detail page">      
  <title>MyFood - View Recipe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Icon from https://www.clipsafari.com/clips/o237408-sprouting-green-leaves -->
  <link rel="icon" type="image/png" href="images/siteicon.png" />

  <style>
    .card {
        height: 100%;
        width: 65vw;
    }

    .card .body {
        background-color: #d1d1d1;
    }

    .cardimg {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .groupbtn {
        margin-left: 110px;
        margin-right: 110px;
        padding: 12px;
        width: 12em;
    }

    .recipename {
        margin-left: 31%;
    }

    .favorite {
        position: absolute;
        right: 0%;
    }

    .infoblock {
        font-size: 16px;
    }

    /* Prevent username from overlapping with favorites icon */
    .userblock {
        font-size: 16px;
        width: 95%;
    }

    .infoblock .infotext {
        font-size: 14px;
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

    <div style="padding-top:212px;">

    </div>

    <!-- Recipe details -->
    <div class="row d-flex justify-content-center align-items-center">
        <?php 
            if(isset($_GET["recipe_id"])) {
                $id = $_GET["recipe_id"];
                // Check if recipe id exists
                $rid_rows = mysqli_query($db, "SELECT * FROM recipe where recipe_id=$id");
                if (mysqli_num_rows($rid_rows) != 0) {    
                    // Get username of recipe uploader
                    $upload_rows = mysqli_query($db, "SELECT username FROM user where user_id=
                                                        (SELECT user_id FROM uploads where recipe_id=$id);");
                    $upload_username = mysqli_fetch_row($upload_rows)[0];
                    // Get any tags associated with the recipe
                    $tag_rows = mysqli_query($db, "SELECT tag FROM recipe_tags WHERE recipe_id=$id");
                    $recipe_tags = mysqli_fetch_all($tag_rows);
                    // Get recipe details by recipe id
                    $recipe_info = mysqli_query($db, "SELECT * FROM recipe WHERE recipe_id=$id");
                    foreach($recipe_info as $recipe) { ?>
                        <!-- Recipe name -->
                        <div class="row recipename">
                            <h2 style="font-weight:bold;"><?= $recipe['recipe_name'] ?></h2>
                        </div>
                        <div class="card mb-3 p-0">
                            <div class="row">
                                <!-- Recipe image -->
                                <div class="col-md-5 p-0">
                                    <!-- https://www.pexels.com/photo/burger-and-vegetables-placed-on-brown-wood-surface-1565982/-->
                                    <img src="images/genericrecipe.jpg" class="cardimg img-fluid rounded-start" alt="Default recipe photo">
                                </div>
                                <div class="body col-md-7">
                                    <!-- Favorite icon -->
                                    <div class="favorite">
                                        <a href="#"><i class="bi bi-star" style="font-size: 2rem;"></i></a>
                                    </div>
                                    <!-- Recipe information -->
                                    <div class="card-body">
                                    <p class="card-text userblock">
                                        Uploaded by: <?= $upload_username ?>
                                    </p>
                                    <p class="card-text infoblock">
                                        Ingredients: <br>
                                        <span class="card-text infotext">
                                            <?= $recipe['ingredients'] ?>
                                        </span>
                                    </p>
                                    <p class="card-text infoblock">
                                        Instructions: <br>
                                        <span class="card-text infotext"> 
                                            <?= $recipe['instructions'] ?>
                                        </span>
                                    </p>
                                    <p class="card-text infoblock">
                                        Tags: <br>
                                        <span class="card-text infotext"> 
                                            <?php
                                                if (empty($recipe_tags)) {
                                                    echo "No tags found";
                                                }
                                                else {
                                                    foreach($recipe_tags as $tag) {
                                                        echo $tag[0]." ";
                                                    }
                                                }
                                            ?>
                                        </span>
                                    </p>
                                    <p class="card-text infoblock">
                                        Estimated Cost: <br>
                                        <span class="card-text infotext"> 
                                            $<?= $recipe['cost'] ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                }
                // Recipe id doesn't exist
                else {
                    echo "<div class='text-center' style='margin-top:2%; margin-bottom:20%'>Recipe does not exist.</div>";
                }
            }
        ?>
    </div>

    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>