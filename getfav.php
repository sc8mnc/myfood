<?php
    // Include config file
    require_once "connect-db.php";

    $uid = intval($_GET['userid']);
    $rid = intval($_GET['recipeid']);
    $fav = $_GET['fav'];

    // Add recipe to user's favorites if favorited
    if($fav == "true") {
        $sql="INSERT INTO `favorites` (`recipe_id`, `user_id`) VALUES ($rid, $uid)";
    }
    // Remove recipe from user's favorites if unfavorited
    else {
        $sql="DELETE FROM `favorites` WHERE recipe_id=$rid AND user_id=$uid";
    }

    mysqli_query($db, $sql);
?>