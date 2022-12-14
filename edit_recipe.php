<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Very Cool Group">
  <meta name="description" content="A MyFood recipe detail page">      
  <title>MyFood - View Recipe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css” />
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
        height: 45vh;
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
        right: 1%;
    }

    .form-group {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
        color: #017572;
    }
    
    .form-group .checkbox {
        font-weight: normal;
    }
    
    .form-group .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }
    
    .form-group .form-control:focus {
        z-index: 2;
    }
    
    .form-group input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-color:#017572;
    }
    
    h2{
        text-align: center;
        color: #017572;
        font-weight: bold;
    }

    .buttons .btn {
        margin-left: 3%;
        margin-right: 3%;
    }

    .submit {
        width: 35%;
    }

    </style>

<?php include 'protect.php'?>
<?php
// Include config file
require_once "connect-db.php";

 
// Define variables and initialize with empty values
$recipename = $ingredients = $instructions = $cost = "";
$recipename_err = $ingredients_err = $instructions_err = $cost_err = "";
$quick_tag = $cheap_tag = $fancy_tag = $vegan_tag = $healthy_tag = false;
$comfort_food_tag = $spicy_tag = $dessert_tag = $vegetarian_tag = false;
$picture = "";
$id = "";
$recipe_id_err = "";
$delete_recipe = "";
$creator_id = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $creator_id = $_POST["creator_id"];

    if($_SESSION['id'] == $creator_id){

    

    // Validate recipe name
    if(empty(trim($_POST["recipename"]))){
        $recipename_err = "Please enter a recipe name.";
    } else{
        $recipename = trim($_POST["recipename"]);
    }

    // Validate ingredients
    if(empty(trim($_POST["ingredients"]))){
        $ingredients_err = "Please enter the ingredients.";
    } else{
        $ingredients = trim($_POST["ingredients"]);
    }

    // Validate instructions
    if(empty(trim($_POST["instructions"]))){
        $instructions_err = "Please enter the instructions.";
    } else{
        $instructions = trim($_POST["instructions"]);
    }

    // Validate password
    if(empty(trim($_POST["cost"]))){

        $cost_err = "Please enter a cost.";     
    } elseif(trim($_POST["cost"]) <= 0){
        $cost_err = "Please enter a valid cost.";
    } else{
        $cost = trim($_POST["cost"]);
    }

    $recipe_id = trim($_POST["recipe_id"]);

    $quick_tag = $_POST["quick_tag"];
    $cheap_tag = $_POST["cheap_tag"];
    $fancy_tag = $_POST["fancy_tag"];
    $vegan_tag = $_POST["vegan_tag"];
    $healthy_tag = $_POST["healthy_tag"];
    $comfort_food_tag = $_POST["comfort_food_tag"];
    $spicy_tag = $_POST["spicy_tag"];
    $dessert_tag = $_POST["dessert_tag"];
    $vegetarian_tag = $_POST["vegetarian_tag"];
    $delete_recipe = $_POST["delete_recipe"];

    // $next_recipe = mysqli_query($db, "SELECT * FROM `recipe` ORDER BY recipe_id DESC LIMIT 1");
    // foreach ($next_recipe as $next_recipe_indiv){
    //     $next_recipe_id = $next_recipe_indiv['recipe_id'] + 1;
    // }
    $result = mysqli_query($db, "SHOW TABLE STATUS LIKE 'recipe'");
    $data = mysqli_fetch_assoc($result);
    $next_increment = $data['Auto_increment'];
    
    // Check input errors before inserting in database
    if(empty($recipename_err) && empty($ingredients_err) && empty($instructions_err) && empty($cost_err)){
        // Prepare an insert statement
        $sql = "UPDATE recipe SET recipe_name=?, ingredients=?, cost=?, instructions=?  WHERE recipe_id=?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_recipe_name, $param_ingredients, $param_cost, $param_instructions, $param_recipe_id);
            
            // Set parameters
            $param_recipe_name = $recipename;
            $param_ingredients = $ingredients;
            $param_cost = $cost;
            $param_instructions = $instructions;
            $param_recipe_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // $sql = "INSERT INTO uploads (user_id, recipe_id) VALUES (?, ?)";
        // if($stmt = mysqli_prepare($db, $sql)){
        //     // Bind variables to the prepared statement as parameters
        //     mysqli_stmt_bind_param($stmt, "ii", $userid, $param_recipe_id);
        //     
        //     // Set parameters
        //     $param_recipe_id = $next_increment;
        //     $userid = $_SESSION['id'];
        //     
        //     // Attempt to execute the prepared statement
        //     if(mysqli_stmt_execute($stmt)){
        //         // Redirect to login page
        //         // header("location: landing.php");
        //     } else{
        //         echo "Oops! Something went wrong. Please try again later.";
        //     }
        //     // Close statement
        //     mysqli_stmt_close($stmt);
        // }
    }

    if($delete_recipe == true){
        // Prepare an insert statement
        $sql = "DELETE FROM recipe WHERE recipe_id=?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_recipe_id);
            
            // Set parameters
            $param_recipe_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                //header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if($delete_recipe == true){
        // Prepare an insert statement
        $sql = "DELETE FROM recipe_tags WHERE recipe_id=?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_recipe_id);
            
            // Set parameters
            $param_recipe_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                //header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if($delete_recipe == true){
        // Prepare an insert statement
        $sql = "DELETE FROM recipe_pictures WHERE recipe_id=?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_recipe_id);
            
            // Set parameters
            $param_recipe_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                //header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if($delete_recipe == true){
        // Prepare an insert statement
        $sql = "DELETE FROM comments WHERE recipe_id=?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_recipe_id);
            
            // Set parameters
            $param_recipe_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if($delete_recipe == true){
        // Prepare an insert statement
        $sql = "DELETE FROM favorites WHERE recipe_id=?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_recipe_id);
            
            // Set parameters
            $param_recipe_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if($delete_recipe == true){
        // Prepare an insert statement
        $sql = "DELETE FROM posts WHERE recipe_id=?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_recipe_id);
            
            // Set parameters
            $param_recipe_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if($delete_recipe == true){
        // Prepare an insert statement
        $sql = "DELETE FROM uploads WHERE recipe_id=?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_recipe_id);
            
            // Set parameters
            $param_recipe_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if($delete_recipe == true){
        // Prepare an insert statement
        $sql = "DELETE FROM user_comments WHERE recipe_id=?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_recipe_id);
            
            // Set parameters
            $param_recipe_id = $recipe_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    header("location: landing.php");

    // ADD TAGS

    $tag_array = array("Quick" => $quick_tag, "Cheap" => $cheap_tag, "Fancy" => $fancy_tag,
    "Vegan" => $vegan_tag, "Healthy" => $healthy_tag, "Comfort Food" => $comfort_food_tag,
    "Spicy" => $spicy_tag, "Dessert" => $dessert_tag, "Vegetarian" => $vegetarian_tag,);

    // foreach($tag_array as $key_tag => $tag_bool){
    //     if ($tag_bool == true){
    //         // Prepare an insert statement
    //         $sql = "INSERT INTO recipe_tags (recipe_id, tag) VALUES (?, ?)";
    //         if($stmt = mysqli_prepare($db, $sql)){
    //             // Bind variables to the prepared statement as parameters
    //             mysqli_stmt_bind_param($stmt, "is", $param_recipe_id, $param_tag);
    //             
    //             // Set parameters
    //             $param_recipe_id = $next_increment;
    //             $param_tag = $key_tag;
    //             
    //             // Attempt to execute the prepared statement
    //             if(mysqli_stmt_execute($stmt)){
    //                 // Redirect to login page
    //                 // header("location: landing.php");
    //             } else{
    //                 echo "Oops! Something went wrong. Please try again later.";
    //             }
    // 
    //             // Close statement
    //             mysqli_stmt_close($stmt);
    //         }
    //     }
    // }
// 
    // if ($picture != ""){
    //     // Prepare an insert statement
    //     $sql = "INSERT INTO recipe_pictures (recipe_id, picture) VALUES (?, ?)";
    //      
    //     if($stmt = mysqli_prepare($db, $sql)){
    //         // Bind variables to the prepared statement as parameters
    //         mysqli_stmt_bind_param($stmt, "ib", $param_recipe_id, $param_picture);
    //         
    //         // Set parameters
    //         $param_recipe_id = $next_increment;
    //         $param_tag = $picture;
    //         
    //         // Attempt to execute the prepared statement
    //         if(mysqli_stmt_execute($stmt)){
    //             // Redirect to login page
    //             // header("location: landing.php");
    //         } else{
    //             echo "Oops! Something went wrong. Please try again later.";
    //         }
// 
    //         // Close statement
    //         mysqli_stmt_close($stmt);
    //     }
    // }

  
    

    



    // ADD PICTURE
    
    // Close connection
    mysqli_close($db);
    }
}
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
                $tag_rows = mysqli_query($db, "SELECT * FROM recipe_tags WHERE recipe_id=$id");
                $recipe_tags = mysqli_fetch_all($tag_rows);
                // Get recipe details by recipe id
                $recipe_info = mysqli_query($db, "SELECT * FROM recipe WHERE recipe_id=$id");
                $creator_id_obtained_list = mysqli_query($db, "SELECT * FROM uploads WHERE recipe_id=$id");
                foreach($creator_id_obtained_list as $upload_object) {
                    $creator_id_obtained = $upload_object['user_id'];
                }
                //foreach($tag_rows as $rec_tag){
                //    if($rec_tag['tag'] == 'Quick'){
                //        $quick_tag_a = "c";
                //    }
                //    if($rec_tag['tag'] == 'Cheap'){
                //        $cheap_tag = true;
                //    }
                //    if($rec_tag['tag'] == 'Fancy'){
                //        $fancy_tag = true;
                //    }
                //    if($rec_tag['tag'] == 'Vegan'){
                //        $vegan_tag = true;
                //    }
                //    if($rec_tag['tag'] == 'Healthy'){
                //        $healthy_tag = true;
                //    }
                //    if($rec_tag['tag'] == 'Comfort Food'){
                //        $comfort_food_tag = true;
                //    }
                //    if($rec_tag['tag'] == 'Spicy'){
                //        $spicy_tag = true;
                //    }
                //    if($rec_tag['tag'] == 'Dessert'){
                //        $dessert_tag = true;
                //    }
                //    if($rec_tag['tag'] == 'Vegetarian'){
                //        $vegetarian_tag = true;
                //    }
//
                // }
                foreach($recipe_info as $recipe) { ?>
                    <div class="wrapper">
                    <h2>Create your own recipe!</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name of recipe</label>
                            <input type="text" name="recipename" class="form-control <?php echo (!empty($recipename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recipe['recipe_name']; ?>">
                            <span class="invalid-feedback"><?php echo $recipename_err; ?></span>
                        </div>    
                        <div class="form-group">
                            <label>Ingredients</label>
                            <input type="text" name="ingredients" class="form-control <?php echo (!empty($ingredients_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recipe['ingredients']; ?>">
                            <span class="invalid-feedback"><?php echo $ingredients_err; ?></span>
                        </div>     
                        <div class="form-group">
                            <label>Instructions</label>
                            <input type="text" name="instructions" class="form-control <?php echo (!empty($instructions_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recipe['instructions']; ?>">
                            <span class="invalid-feedback"><?php echo $instructions_err; ?></span>
                        </div>    
                        <div class="form-group">
                            <label>Add a cost</label>
                            <input type="number" step="0.01" name="cost" class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recipe['cost']; ?>">
                            <span class="invalid-feedback"><?php echo $cost_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Delete this recipe</label>
                            <input type="checkbox" name="delete_recipe" value="$delete_recipe">
                        </div>
                        
                        
                        <div class="form-group buttons">
                            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                            <input type="submit" class="btn btn-primary submit" value="Confirm">
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="recipe_id" class="form-control <?php echo (!empty($recipe_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recipe['recipe_id']; ?>">
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="creator_id" class="form-control <?php echo (!empty($recipe_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $creator_id_obtained; ?>">
                        </div>
                

            
        </form>
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
       

    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
</body>
</html>