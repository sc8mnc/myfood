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

    
<?php
// Include config file
require_once "connect-db.php";
 
// Define variables and initialize with empty values
$recipename = $ingredients = $instructions = $cost = "";
$recipename_err = $ingredients_err = $instructions_err = $cost_err = "";
$quick_tag = $cheap_tag = $fancy_tag = $vegan_tag = $healthy_tag = false;
$comfort_food_tag = $spicy_tag = $dessert_tag = $vegetarian_tag = false;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

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
    
    // Check input errors before inserting in database
    if(empty($recipename_err) && empty($recipename_err) && empty($instructions_err) && empty($cost_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO recipe (recipename, ingredients, cost, instructions) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_recipe_name, $param_ingredients, $param_cost, $param_instructions);
            
            // Set parameters
            $param_recipe_name = $recipename;
            $param_ingredients = $ingredients;
            $param_cost = $cost;
            $param_instructions = $instructions;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: landing.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // ADD TAGS



    // ADD PICTURE
    
    // Close connection
    mysqli_close($db);
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

    <div class="wrapper">
        <h2>Create your own recipe!</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name of recipe</label>
                <input type="text" name="recipename" class="form-control <?php echo (!empty($recipename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recipename; ?>">
                <span class="invalid-feedback"><?php echo $recipename_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Ingredients</label>
                <input type="text" name="ingredients" class="form-control <?php echo (!empty($ingredients_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ingredients; ?>">
                <span class="invalid-feedback"><?php echo $ingredients_err; ?></span>
            </div>     
            <div class="form-group">
                <label>Instructions</label>
                <input type="text" name="instructions" class="form-control <?php echo (!empty($instructions_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $instructions; ?>">
                <span class="invalid-feedback"><?php echo $instructions_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Add a cost</label>
                <input type="number" step="0.01" name="cost" class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cost; ?>">
                <span class="invalid-feedback"><?php echo $cost_err; ?></span>
            </div>
            <div class="form-group buttons">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                <input type="submit" class="btn btn-primary submit" value="Submit">
            </div>
        </form>
    </div>    

    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>