<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Very Cool Group">
  <meta name="description" content="MyFood User Settings">      
  <title>MyFood - Settings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css” />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Icon from https://www.clipsafari.com/clips/o237408-sprouting-green-leaves -->
  <link rel="icon" type="image/png" href="images/siteicon.png" />

  <style>
         body {
            text-align:center;
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
         
         .form-group input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
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

         .submit {
            width: 35%;
         }

         .alert {
            width: 55%;
         }
    </style>
</head>

<body>

    <div class="fixed-top">
    <?php include 'protect.php'?>
        <?php include('site_heading.html') ?>
        <?php include('navbar.html') ?>
        
    </div>

    <div style="padding-top:208px;">

    </div>

    <!-- Recipe details -->
    <?php
// Initialize the session
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "connect-db.php";
 
// Define variables and initialize with empty values
$firstname = $lastname = $new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate first name
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your first name.";
    } else{
        $firstname = trim($_POST["firstname"]);
    }

    // Validate last name
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter your last name.";
    } else{
        $lastname = trim($_POST["lastname"]);
    }

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($firstname_err) && empty($lastname_err) && empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE user SET first_name = ?, last_name = ?, password = ? WHERE user_id = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_firstname, $param_lastname, $param_password, $param_id);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                //session_destroy();
                //header("location: landing.php");
                echo '<script>alert("Changed Successfully!")</script>';
                //exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($db);
}
?>

    <div class="wrapper">
        <h2>Settings</h2>
        <p>Please fill out this form to reset your information.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
            </div> 
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <a class="btn btn-link ml-2" href="landing.php">Cancel</a>
                <input type="submit" class="submit btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>

    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>