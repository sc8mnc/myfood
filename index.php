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
        height: 40vh;
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

    <!-- Site introduction -->
    <div class="row d-flex justify-content-center align-items-center">
        <div class="card mb-3 p-0">
            <div class="row">
                <div class="body col-md-7">
                    <div class="card-body">
                        <h2 class="card-title" style="font-weight:bold;">Welcome to MyFood.</h5>
                        <p class="card-text" style="font-size:22px;">
                            Upload and share delicious recipes with other users. Try new dishes today with MyFood!
                        </p>
                    </div>
                </div>
                <div class="col-md-5 p-0">
                    <!-- Image from https://www.pexels.com/photo/pasta-with-vegetable-dish-on-gray-plate-beside-tomato-fruit-on-white-table-769969/ -->
                    <img src="images/spaghetti.jpg" class="cardimg img-fluid rounded-start" alt="Picture of spaghetti">
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons below intro -->
    <div class="button-group d-flex justify-content-center" style="padding-top: 30px;">
        <a class="groupbtn btn btn-primary" href="register.php" role="button">Create Account</a>
        <a class="groupbtn btn btn-primary" href="login.php" role="button">Login</a>
    </div>



    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
