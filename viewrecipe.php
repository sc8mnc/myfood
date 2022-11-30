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
        background-color: #E8f1e8;
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


    .addmsg {
        justify-content: center;
        margin-top: 90px;
    }

    .submit {
        float: right;
        width: 12%;
        height: 25%;
        margin-top: 2%;
    }

    .messages {
        margin-left: 49%;
        margin-right: 15%;
    }

    .messages .card {
        margin-top: 45px;
        background: #E8f1e8;
        padding-left: 20px;
        padding-right: 20px;
    }

    .poster {
        font-weight: bold;
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

    <div style="padding-top:212px;">

    </div>

    <!-- Recipe details -->
    <div class="row d-flex justify-content-center align-items-center">
        <?php
            $message_err = "";

            if (isset($_POST['msg'])) {
                $id = $_GET["recipe_id"];
                // Check if message is empty
                if(empty(trim($_POST['msg']))){
                    $message_err = "Please enter a comment.";
                }
    
                // Check input errors before updating the database
                if(empty($message_err)){
                    $msg = $_POST['msg'];
                    $userid = $_SESSION['id'];
                    // Prepare an insert statement
                    $sql = "INSERT INTO comments (recipe_id, comment_text) VALUES (?, ?)";
                    
                    if($stmt = mysqli_prepare($db, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "is", $param_rid, $param_message);
                        
                        // Set parameters
                        $param_rid = $id;
                        $param_message = $msg;
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            // Retrieve comment no based on latest added comment
                            $latest_cmt_row = mysqli_query($db, "SELECT comment_number FROM comments ORDER BY comment_number DESC LIMIT 1");
                            $cmtno = mysqli_fetch_row($latest_cmt_row)[0];
    
                            // Link user, recipe, and comment
                            mysqli_query($db, "INSERT INTO user_comments (user_id, recipe_id, comment_number) VALUES ($userid, $id, $cmtno)");
                        } else{
                            echo "Your comment could not be added at this time.";
                        }
    
                    // Close statement
                    mysqli_stmt_close($stmt);
                    }
                }
            }

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
                    foreach($recipe_info as $recipe) { 
                        // Check if recipe has been favorited
                        $favorited = false;
                        $recipeid = $recipe['recipe_id'];
                        $userid = $_SESSION['id'];
                        $thisrecipe_fav = mysqli_query($db, "SELECT * FROM `favorites` WHERE recipe_id=$recipeid AND user_id=$userid");
                        // User has favorited this recipe
                        if (mysqli_num_rows($thisrecipe_fav) != 0) {
                            $favorited = true;
                        }
                        ?>
                        
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

    <!-- Comments -->
    <?php
        if (mysqli_num_rows($rid_rows) != 0) { ?>
            <!-- Add comment textbox -->
            <div class="row addmsg text-right">
                <form class="col-sm-8 mb-3" method="post">
                    <label for="msg" class="form-label">Leave a comment about this recipe</label>
                    <textarea class="form-control" name="msg" maxlength="255" rows="3"></textarea>
                    <span class="text-danger"><?php echo $message_err; ?></span>
                    <button type="submit" name="submit" class="submit btn btn-primary">Post</button>
                </form>
            </div>

            <!-- Recipe comments section -->
            <div class="messages">
                <?php
                // Get all messages and data
                $message_rows = mysqli_query($db, "SELECT * FROM comments WHERE recipe_id=$id ORDER BY comment_number DESC");
                if (mysqli_num_rows($message_rows) != 0) {
                    foreach ($message_rows as $comment) {
                        $rid = $comment['recipe_id'];
                        $comno = $comment['comment_number'];
                        $tstamp = $comment['timestamp'];
                        $ctext = $comment['comment_text'];
                        // Get poster's username
                        $poster_rows = mysqli_query($db, "SELECT username FROM user where user_id=
                                                            (SELECT user_id FROM user_comments where recipe_id=$rid AND comment_number=$comno);");
                        $poster_username = mysqli_fetch_row($poster_rows)[0];
                        ?>
                        <div class="card mb-3 msgnopic">
                            <div class="row g-0">
                                <div class="card-body">
                                    <h4 class="card-title poster"><?= $poster_username ?></h4>
                                    <p class="card-text"><small class="text-muted"><?= $tstamp ?></small></p>
                                    <p class="card-text"><?= $ctext ?></p>
                                </div>
                            </div>
                        </div>
                    <?php 
                    }
                }
        }
    ?>
    </div>

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