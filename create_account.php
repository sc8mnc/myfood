
<?php
require("connect_db.php");      // include("connect-db.php");
require("functions_db.php");

// $list_of_friends = getAllFriends();
// $friend_to_update = null;      
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Create account') 
  {
      createNewAccount($_POST['first_name'], $_POST['last_name'], $_POST['password']);
      // $list_of_friends = getAllFriends();  
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Very Cool Group">
  <meta name="description" content="The MyFood site landing page">      
  <title>MyFood - Landing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
        height: 38vh;
        object-fit: cover;
    }

    .groupbtn {
        margin-left: 110px;
        margin-right: 110px;
        padding: 12px;
        width: 12em;
    }
    </style>
</head>

<body>

    <div class="fixed-top">
        <?php include('site_heading.html') ?> 
    </div>

    <div style="padding-top:205px;">

    </div>

    <form name="mainForm" action="index.php" method="post">   
    <div class="row mb-3 mx-3">
        First name:
        <input type="text" class="form-control" name="first_name" required 
            value="<?php ?>"
        />            
    </div>  
    <div class="row mb-3 mx-3">
        Last name:
        <input type="text" class="form-control" name="last_name" required 
        value="<?php ?>"
        />            
    </div> 
    <div class="row mb-3 mx-3">
        Password:
        <input type="text" class="form-control" name="password" required 
        value="<?php ?>"
        />            
    </div>   
    <!-- <div class="row mb-3 mx-3"> -->
    <center> <div>         
        <input type="submit" value="Create account" name="btnAction" class="btn btn-primary" 
            title="Create new account" />            
    </div>  </center>

    </form> 



    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>