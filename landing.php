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
    <div class="row d-flex justify-content-center align-items-center">
        <div class="row recipename">
            <h2 style="font-weight:bold;">Recipe 1</h2>
        </div>
        <div class="card mb-3 p-0">
            <div class="row">
                <div class="col-md-5 p-0">
                    <!-- Image from https://www.pexels.com/photo/pasta-with-vegetable-dish-on-gray-plate-beside-tomato-fruit-on-white-table-769969/ -->
                    <img src="images/spaghetti.jpg" class="cardimg img-fluid rounded-start" alt="Picture of spaghetti">
                </div>
                <div class="body col-md-7">
                    <div class="favorite">
                        Star
                    </div>
                    <div class="card-body">
                        <h2 class="card-title" style="font-weight:bold;">Welcome to MyFood.</h5>
                        <p class="card-text" style="font-size:22px;">
                            Upload and share delicious recipes with other users. Try new dishes today with MyFood!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>