<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Very Cool Group">
  <meta name="description" content="A MyFood recipe detail page">      
  <title>MyFood - Search Index</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Icon from https://www.clipsafari.com/clips/o237408-sprouting-green-leaves -->
  <link rel="icon" type="image/png" href="images/siteicon.png" />

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

    <div style="padding-top:208px;" >

    </div>
    <style>
        .searchbox {
            margin-left:10%;
    }   
    </style>
    <head>
	<title>Search</title>
    <div align="left" class="row top">
        <h2 style="font-weight:bold;margin-left:10%;"> Search </h2>
    </div>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
    <div class="searchbox" style="margin-bottom:19%;">
	<form action="search.php" method="GET">
        <label for="tags">Choose a tag:</label>
        <select name="tags" id="tags">
        <optgroup label="Recipe Tags">
            <option value="None">None</option>
            <option value="Cheap">Cheap</option>
            <option value="Quick">Quick</option>
            <option value="Fancy">Fancy</option>
            <option value="Vegan">Vegan</option>
            <option value="Healthy">Healthy</option>
            <option value="Comfort Food">Comfort Food</option>
            <option value="Spicy">Spicy</option>
            <option value="Dessert">Dessert</option>
            <option value="Vegetarian">Vegetarian</option>
        </optgroup>
        </select>
		<input type="text" name="query" />
		<input type="submit" value="Search" />
	</form>
    </div>
    
    </body>
    
    <?php include('footer.html') ?> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>