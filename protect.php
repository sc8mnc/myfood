<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
//checking if the session exists
//if the session is not set it redirects the user to the index form/page

  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
      header("location:index.php");
  }

?>